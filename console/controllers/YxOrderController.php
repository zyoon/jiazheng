<?php

namespace console\controllers;

use common\models\YxOrder;
use common\models\YxOrderSearch;
use common\tools\CheckController;
use common\tools\Helper;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use \Pingpp\Pingpp;
use \Pingpp\WxpubOAuth;

/**
 * YxOrderController implements the CRUD actions for YxOrder model.
 */
class YxOrderController extends CheckController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all YxOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxOrderSearch();

        $user_info = Yii::$app->user->identity;
        $company_id = $user_info['company_id'];
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['company_id']=$company_id;
        $user_id = '';
        if (isset($queryParams['user_id'])) {
            $user_id = $queryParams['user_id'];
            $queryParams['YxOrderSearch'] = ['yx_user_id' => $queryParams['user_id']];
        }
        if (isset($queryParams['company_id'])) {
            $queryParams['YxOrderSearch']['yx_company_id']=$queryParams['company_id'];
        }
        if (isset($queryParams['staff_id'])) {
            $queryParams['YxOrderSearch']['yx_staff_id']=$queryParams['staff_id'];
        }
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'yx_user_id' => $user_id,
        ]);
    }

    /**
     * Displays a single YxOrder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new YxOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxOrder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing YxOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $queryParams = Yii::$app->request->post();
        $index_url='index';
        $uri='';
        if (isset($queryParams['company_id'])) {
            $uri='?company_id='.$queryParams['company_id'];
        }
        if (isset($queryParams['staff_id'])) {
            $uri='?staff_id='.$queryParams['staff_id'];
        }
        if (isset($queryParams['user_id'])) {
            $uri='?user_id='.$queryParams['user_id'];
        }
        $index_url=$index_url.$uri;
        return $this->redirect([$index_url]);
    }

    public function actionPayment($id)
    {
        $isWechat = Helper::isWechatBrowser();
        $order = $this->findModel($id);
        return $this->render('payment', [
            'model' => $order,
            'isWechat' => $isWechat,
        ]);
    }
    public function actionPaysuccess($id)
    {
        $order = $this->findModel($id);
        return $this->render('paysuccess', [
            'model' => $order,
        ]);
    }

    public function actionPay($id, $channel)
    {
        $order = $this->findModel($id);
        \Pingpp\Pingpp::setApiKey(Yii::$app->params['ping++']['API_KEY']);
        \Pingpp\Pingpp::setPrivateKeyPath(__DIR__ . '/../../' . Yii::$app->params['ping++']['PRIVATE_KEY_DIR']);

        $extra = [];
        switch ($channel) {
            case 'alipay_pc_direct':
                $extra = array(
                    'success_url' => Yii::$app->params['webuploader']['backendEndDomain'] . 'yx-order/paysuccess?id=' . $id,
                );
                break;
            case 'wx_pub':
                $cookies = Yii::$app->request->cookies;
                $wx_code = $cookies->getValue('wx_code'); //下面有將怎麼獲取
                $wx_app_id = Yii::$app->params['wechat']['wx_app_id'];
                $wx_app_secret = Yii::$app->params['wechat']['wx_app_secret'];
                $open_id = WxpubOAuth::getOpenid($wx_app_id, $wx_app_secret, $wx_code);
                // return $this->render('pay', [
                //     'model' => $order,
                //     'res' => $open_id,
                // ]);
                $extra = array(
                    'open_id' => $open_id, // 用户在商户微信公众号下的唯一标识，获取方式可参考 pingpp-php/lib/WxpubOAuth.php
                );
                break;
        }
        try {
            $ch = \Pingpp\Charge::create(array(
                'order_no' => '20180328' . $id,
                'amount' => $order->order_money, //订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
                'app' => array('id' => Yii::$app->params['ping++']['PAPP_ID']),
                'channel' => $channel,
                'currency' => 'cny',
                'client_ip' => '127.0.0.1',
                'subject' => $order->order_name,
                'body' => date('Y-m-d H:i', $order->created_at),
                'extra' => $extra,
            ));
            $chargeJson = json_encode($ch);
            //Yii::$app->response->cookies->remove('wx_code');
            return $this->render('pay', [
                'model' => $order,
                'chargeJson' => $chargeJson,
            ]);
        } catch (\Pingpp\Error\Base $e) {
            //如果发起支付请求失败，则抛出异常
            // 捕获报错信息
            if ($e->getHttpStatus() != null) {
                header('Status: ' . $e->getHttpStatus());
                echo $e->getHttpBody();
            } else {
                echo $e->getMessage();
            }
        }
    }
    /**
     * 判断是否在微信客户端打开链接
     * 如果是就跳转到微信code的重定向url地址
     * 如果不是就跳到支付宝支付界面
     */
    public function actionGetcode($id, $channel)
    {
        $isWechat = Helper::isWechatBrowser();
        if ($isWechat) {
            $url = Helper::GetWxCodeUrl($id, $channel);
            header("Location: $url");
            exit();
        } else {
            $this->redirect(['yx-order/pay?id=' . $id . '&channel=' . $channel]);
        }
    }

    /**
     * 通过微信重定向url获取code，
     * 并且把code设置为cookie
     */

    public function actionGetwxcode()
    {
        $yx_order_id = Yii::$app->request->get('yx_order_id');
        $channel = Yii::$app->request->get('channel');
        $code = Yii::$app->request->get('code');
        if (!empty($code)) {
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'wx_code',
                'value' => $code,
                'expire' => time() + 1800,
            ]));
        }
        $this->redirect(['yx-order/pay?id=' . $yx_order_id . '&channel=' . $channel]);
    }

    public function actionfinishOrder()
    {
        $event = json_decode(file_get_contents("php://input"));
        // 对异步通知做处理
        if (!isset($event->type)) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            exit("fail");
        }
        switch ($event->type) {
            case "charge.succeeded":
                // 开发者在此处加入对支付异步通知的处理代码
                header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                break;
            case "refund.succeeded":
                // 开发者在此处加入对退款异步通知的处理代码
                header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                break;
            default:
                header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                break;
        }
        return;
    }

/**
 * [actionAcceptorder 接受订单]
 * @Author   Yoon
 * @DateTime 2018-04-12T14:43:18+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public function actionAcceptorder($id)
    {
        $model = YxOrder::findOne($id);
        $model->order_state = 4;
        $model->save();
        $this->redirect(['view', 'id' => $id]);
    }
/**
 * [actionNotacceptorder 拒绝订单]
 * @Author   Yoon
 * @DateTime 2018-04-12T14:43:37+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public function actionNotacceptorder($id)
    {
        $model = YxOrder::findOne($id);
        $model->order_state = 6;
        $model->save();
        #设置运营分数
        $model->setHistoryFraction();
        $this->redirect(['view', 'id' => $id]);
    }
/**
 * [actionOverorder 强制完成]
 * @Author   Yoon
 * @DateTime 2018-04-12T14:43:42+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public function actionOverorder($id)
    {
        $model = YxOrder::findOne($id);
        $model->order_state = 8;
        $model->save();
        $this->redirect(['yx-comment/create', 'order_id' => $id]);
    }
/**
 * [actionNotoverorder 强制退款]
 * @Author   Yoon
 * @DateTime 2018-04-12T14:43:46+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public function actionNotoverorder($id)
    {
        $model = YxOrder::findOne($id);
        $model->order_state = 7;
        $model->save();
        $this->redirect(['view', 'id' => $id]);
    }
    /**
     * Finds the YxOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
