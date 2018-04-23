<?php

namespace frontend\controllers;

use Yii;
use frontend\models\YxOrderSearch;
use common\models\YxOrder;
use common\models\YxOrderServer;
use common\models\YxUserAddress;
use common\models\YxStaff;
use common\models\YxStaffServer;
use common\models\YxCmpServer;
use common\models\YxCompany;
use common\models\YxServer;
use common\tools\CheckController;
use common\tools\Helper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        // $searchModel = new YxOrderSearch();
        // $params = Yii::$app->request->queryParams;
        // $order_state = 0;
        // if(isset($params["order_state"])){
        //   $order_state = (int)$params["order_state"];
        // }
        // $query = YxOrder::find();
        // $yx_user_id = Yii::$app->user->id;
        // $query->andFilterWhere([
        //     'yx_user_id' => $yx_user_id,
        //     'is_delete' => 0,
        // ]);
        // var_dump($order_state);
        // switch ($order_state) {
        //     case 1:
        //         $query->andFilterWhere(['order_state' => 1]);
        //         break;
        //     case 2:
        //         $query->andFilterWhere(['between', 'order_state',2,4]);
        //         break;
        //     case 3:
        //         $query->andFilterWhere(['order_state' => 5]);
        //         break;
        //     case 4:
        //         $query->andFilterWhere(['between', 'order_state',6,8]);
        //         break;
        //     default:
        //         break;
        // }
        // $query->orderBy(['created_at'=>SORT_DESC]);
        // $allOrder = $query->asarray()->all();
        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'orderDatas' => $allOrder,
        // ]);
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
        $this->enableCsrfValidation = false;
        $reJson = [ 'msg' => "下单失败", 'code' => -1, 'order_id' => 0];
        $timeDatas = [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];
        $transaction = Yii::$app->db->beginTransaction();
        Yii::$app->response->format = 'json';
        if(Yii::$app->request->isAjax) {
            $params = Yii::$app->request->post();
            if(!isset($params['start_time']) || $params['start_time'] < ( time() - 86400)){
                $reJson["msg"] = "上门服务时间不正确";
                return $reJson;
            }
            if(!isset($params['yx_company_id']) || $params['yx_company_id'] <= 0){
                $reJson["msg"] = "缺少商家信息";
                return $reJson;
            }
            if(!isset($params['order_server']) || $params['order_server'] <= 0){
                $reJson["msg"] = "未选择服务";
                return $reJson;
            }
            if(!isset($params['amount']) || round($params['amount']) < 1){
                $reJson["msg"] = "未选择服务数量";
                return $reJson;
            }
            if(!isset($params['order_type']) || $params['order_type'] < 1){
                $reJson["msg"] = "订单类型有误";
                return $reJson;
            }
            if(!isset($params['extra_server']) || !is_array($params['extra_server'])){
                $extra_server = [];
            }else {
                $extra_server = $params['extra_server'];
            }
            $start_time = $params['start_time'];
            $yx_company_id = $params['yx_company_id'];
            $yx_staff_id = $params['yx_staff_id'];
            $order_server = $params['order_server'];
            $amount = round($params['amount']);
            $order_type = $params['order_type'];

            $all_money = 0;
            $yxCompany = YxCompany::findOne(['id'=>$yx_company_id]);
            if(!$yxCompany){
                $reJson["msg"] = "商家信息有误";
                return $reJson;
            }
            $model = new YxOrder();
            $model->order_name = "原象屋-".$yxCompany['name'];
            $model->yx_company_id = $yx_company_id;
            $model->created_at = time();
            $model->updated_at = time();
            $model->time_start = $start_time;
            $model->order_state = 1;
            $model->yx_user_id = Yii::$app->user->id;
            $model->is_delete = 0;
            $model->order_type = $order_type;
            $addressData = YxUserAddress::findOne(['yx_user_id'=>Yii::$app->user->id,'is_main'=>1]);
            if(!$addressData){
                $reJson["msg"] = "请选择默认收货地址";
                return $reJson;
            }
            $model->address = $addressData['address'];
            $model->phone = $addressData['phone'];
            $model->user_name = $addressData['consignee'];
            $mian_server = null;
            $extra_server_info = [];  //附加服务的详情
            $extra_server_models = []; //生成订单详情的model

            if($order_type == 2){  //服务者下单
                $mian_server = YxServer::getServerByStaff($yx_staff_id,$order_server);
                foreach ($extra_server as $serverItem) {  //遍历前端提交的数据，获取附加服务的详情
                    $serverData = YxServer::getServerByStaff($yx_staff_id,$serverItem["id"]);
                    if(!$serverData){
                        $reJson["msg"] = "服务信息有误";
                        return $reJson;
                    }
                    $serverData['server_amount'] = $serverItem["amount"];
                    array_push($extra_server_info,$serverData);
                }
            }else {  //商家下单
                $mian_server = YxServer::getServerByCompany($yx_company_id,$order_server);
                foreach ($extra_server as $serverItem) {  //遍历前端提交的数据，获取附加服务的详情
                    $serverData = YxServer::getServerByCompany($yx_company_id,$serverItem["id"]);
                    if(!$serverData){
                        $reJson["msg"] = "服务信息有误";
                        return $reJson;
                    }
                    $serverData['server_amount'] = $serverItem["amount"];
                    array_push($extra_server_info,$serverData);
                }
            }
            foreach ($extra_server_info as $serverItem) {
                $extra_server_model = new YxOrderServer();
                $extra_server_model->server_name = $serverItem["server_name"];
                $extra_server_model->server_price = $serverItem["server_price"];
                $extra_server_model->server_unit = $serverItem["server_unit"];
                $extra_server_model->server_amount = $serverItem["server_amount"];
                $extra_server_model->is_main = 0;
                $all_money += $serverItem["server_price"] * $serverItem["server_amount"];
                array_push($extra_server_models,$extra_server_model);
            }
            if(!$mian_server){
                $reJson["msg"] = "服务信息有误";
                return $reJson;
            }


            $main_server_model = new YxOrderServer();
            $main_server_model->server_name = $mian_server["server_name"];
            $main_server_model->server_price = $mian_server["server_price"];
            $main_server_model->server_unit = $mian_server["server_unit"];
            $main_server_model->server_amount = $amount;
            $main_server_model->is_main = 1;
            array_push($extra_server_models,$main_server_model);
            $all_money += $mian_server["server_price"] * $amount;

            if($mian_server["server_unit"] == "小时"){
                $model->time_end = $model->time_start + ($amount+1)*3600;
            }else {
                $model->time_end = $model->time_start + 3 * 3600;
            }

            if($order_type == 2){  //服务者下单
                $model->order_no = YxOrder::generateOrderNumber($mian_server["server_id"],$order_type,$yx_staff_id);
            }else {  //商家下单
                $model->order_no = YxOrder::generateOrderNumber($mian_server["server_id"],$order_type,$yx_company_id);
            }

            switch ($order_type) {
              case 1:    //商家下单
                $model->order_money = $all_money;
                # code...
                break;
              case 2:    //服务者下单
                $model->yx_staff_id = $yx_staff_id;
                $model->order_money = $all_money;
                $yxStaff = YxCompany::findOne(['id'=>$yx_staff_id]);
                if(!$yxCompany){
                    $reJson["msg"] = "服务者信息有误";
                    return $reJson;
                }
                $staffHasOrder = YxOrder::returnStaffOrderCountByTime($yx_staff_id,$model->time_start,$model->time_end);
                if($staffHasOrder > 0){
                    $reJson["msg"] = "服务人员该时间段繁忙，请重新选择下单时间";
                    return $reJson;
                }
                break;
              case 3:    //商家预约
                $model->order_money = 30000;
                break;
            }
            $allSaveOk = true;
            $errorMsg = "";
            if($model->save()){
                foreach ($extra_server_models as $serverModelItem) {
                    $serverModelItem->yx_order_id = $model->id;
                    if($serverModelItem->save()){
                    }else {
                        $allSaveOk = false;
                        foreach ($serverModelItem->errors as $errorItem) {
                          if(is_array($errorItem)){
                              foreach ($errorItem as $errorStr) {
                                  $errorMsg = $errorMsg.$errorStr.",  ";
                              }
                          }else {
                              $errorMsg = $errorMsg.$errorItem.",  ";
                          }
                        }
                        $transaction->rollback();
                    }
                }
            }else {
                $allSaveOk = false;
                foreach ($model->errors as $errorItem) {
                  if(is_array($errorItem)){
                      foreach ($errorItem as $errorStr) {
                          $errorMsg = $errorMsg.$errorStr.",  ";
                      }
                  }else {
                      $errorMsg = $errorMsg.$errorItem.",  ";
                  }
                }
                $transaction->rollback();
            }

            if(!$allSaveOk){
                $reJson["msg"] = $errorMsg;
                return $reJson;
            }else {
                $reJson["code"] = 0;
                $reJson["order_id"] = $model->id;
                $reJson["msg"] = '下单成功';
                $transaction->commit();
            }


        }
        return $reJson;
        // $model = new YxOrder();
        //
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }
        //
        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Updates an existing YxOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate_memo()
    {
      $code = -1;
      Yii::$app->response->format = 'json';
      if(Yii::$app->request->isAjax) {
          $params = Yii::$app->request->post();
          if(!isset($params['order_id']) || !isset($params['order_memo']) || $params['order_id'] < 1){
              return [  'code' => $code];
          }
          $model = $this->findModel($params['order_id']);
          if($model){
            $model->order_memo = $params['order_memo'];
            if ($model->save()) {
                $code = 0;
            }
          }
      }
        return [  'code' => $code];
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

        return $this->redirect(['index']);
    }

    public function actionPayment($id)
    {
        $isWechat = Helper::isWechatBrowser();
        $order = YxOrder::find()->with('yx_order_server')->where(["id"=>$id])->one();
        if($order->order_type ==2){
            $yxStaffName = (YxStaff::findOne(['staff_id'=>$order->yx_staff_id]))->staff_name;
        }else {
            $yxStaffName = "商家指定";
        }

        $yxCompany = YxCompany::findOne(['id'=>$order->yx_company_id]);
        return $this->render('payment', [
            'model' => $order,
            'isWechat' => $isWechat,
            'yxStaffName' => $yxStaffName,
            'yxCompany' => $yxCompany,
        ]);
    }
    public function actionPaysuccess($id)
    {
        $order = $this->findModel($id);
        return $this->render('paysuccess', [
            'model' => $order
        ]);
    }

    public function actionPay($id,$channel)
    {
        $order = $this->findModel($id);
        \Pingpp\Pingpp::setApiKey(Yii::$app->params['ping++']['API_KEY']);
        \Pingpp\Pingpp::setPrivateKeyPath(__DIR__ . '/../../'.Yii::$app->params['ping++']['PRIVATE_KEY_DIR']);

        $extra = [];
        switch ($channel) {
            case 'alipay_pc_direct':
                $extra = array(
                    'success_url' => Yii::$app->params['webuploader']['frontendEndDomain'].'yx-order/paysuccess?id='.$id,
                );
                break;
            case 'wx_pub':
                $cookies = Yii::$app->request->cookies;
                $wx_code = $cookies->getValue('wx_code');//下面有將怎麼獲取
                $wx_app_id = Yii::$app->params['wechat']['wx_app_id'];
                $wx_app_secret = Yii::$app->params['wechat']['wx_app_secret'];
                $open_id = WxpubOAuth::getOpenid($wx_app_id, $wx_app_secret, $wx_code);
                // return $this->render('pay', [
                //     'model' => $order,
                //     'res' => $open_id,
                // ]);
                $extra = array(
                    'open_id' => $open_id,// 用户在商户微信公众号下的唯一标识，获取方式可参考 pingpp-php/lib/WxpubOAuth.php
                );
                break;
        }
        try {
          $ch = \Pingpp\Charge::create(array(
            'order_no'  => $order->order_no,
            'amount'    => $order->order_money,//订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
            'app'       => array('id' => Yii::$app->params['ping++']['PAPP_ID']),
            'channel'   => $channel,
            'currency'  => 'cny',
            'client_ip' => '127.0.0.1',
            'subject'   => $order->order_name,
            'body'      => date('Y-m-d H:i', $order->created_at),
            'extra'     => $extra
          ));
          $chargeJson = json_encode($ch);
          //Yii::$app->response->cookies->remove('wx_code');
          return $this->render('pay', [
              'model' => $order,
              'chargeJson' => $chargeJson,
          ]);
        } catch (\Pingpp\Error\Base $e) { //如果发起支付请求失败，则抛出异常
             // 捕获报错信息
             if ($e->getHttpStatus() != NULL) {
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
    public function actionGetcode($id,$channel)
   {
       $isWechat = Helper::isWechatBrowser();
       if($isWechat){
           $url = Helper::GetWxCodeUrl($id,$channel);
           header("Location: $url");
           exit();
       } else {
           $this->redirect(['yx-order/pay?id='.$id.'&channel='.$channel]);
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
       if(!empty($code)){
           $cookies = Yii::$app->response->cookies;
           $cookies->add(new \yii\web\Cookie([
               'name' => 'wx_code',
               'value' => $code,
               'expire'=>time()+1800,
           ]));
       }
       $this->redirect(['yx-order/pay?id='.$yx_order_id.'&channel='.$channel]);
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
