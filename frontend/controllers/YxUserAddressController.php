<?php

namespace frontend\controllers;

use Yii;
use common\models\YxUserAddress;
use common\models\YxUserAddressSearch;
use common\models\YxOrder;
use common\models\Region;
use common\tools\CheckController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YxUserAddressController implements the CRUD actions for YxUserAddress model.
 */
class YxUserAddressController extends CheckController
{
    /**
     * {@inheritdoc}
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
     * Lists all YxUserAddress models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxUserAddressSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $params = Yii::$app->request->queryParams;
        $order_id = 0;
        if(isset($params['order_id'])){
          $order_id = $params['order_id'];
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order_id' => $order_id,
        ]);
    }

    /**
     * Displays a single YxUserAddress model.
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
     * Creates a new YxUserAddress model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($order_id)
    {

        $model = new YxUserAddress();

        if ($model->load(Yii::$app->request->post())){
            $this->setMainBefore(Yii::$app->user->id);
            $model->yx_user_id = Yii::$app->user->id;
            $model->is_main = 1;
            if($model->save()) {
                return $this->redirect(['index?yx_user_id='.$model->yx_user_id.'&order_id='.$order_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxUserAddress model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())){
            $this->setMainBefore(Yii::$app->user->id);
            if($model->save()) {
                return $this->redirect(['index', 'yx_user_id' => $model->yx_user_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionSetmain($id,$order_id)
    {
        $model = $this->findModel($id);
        $this->setMainBefore(Yii::$app->user->id);
        $model->is_main = 1;
        if($order_id && $order_id > 0){
            $yxOrder = YxOrder::findOne(['id'=>$order_id]);
            $yxOrder->address = Region::getOneName($model->province).Region::getOneName($model->city).Region::getOneName($model->district).'  '.$model->address;
            $yxOrder->phone = $model->phone;
            $yxOrder->user_name = $model->consignee;
            if($model->save() && $yxOrder->save()) {
                return $this->redirect(['/yx-order/payment', 'id' => $order_id]);
            }
        }else {
            if($model->save()) {
                return $this->redirect(['index', 'yx_user_id' => $model->yx_user_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing YxUserAddress model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_delete = 1;
        if ($model->save()) {

        }
        return $this->redirect(['index', 'YxUserAddressSearch[yx_user_id]' => $model->yx_user_id]);
    }

    /**
     * Finds the YxUserAddress model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxUserAddress the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id)
     {
         if (($model = YxUserAddress::findOne($id)) !== null) {
             return $model;
         }

         throw new NotFoundHttpException('发生了一个未知的错误');
     }

     public function setMainBefore($yx_user_id)
     {
          //update YxUserAddress set is_main = 2 where status = 1 and yx_user_id = $yx_user_id;
          if($res = YxUserAddress::updateAll(['is_main' => 2],['is_main' => 1,'yx_user_id' => $yx_user_id])) {
              //print_r('yx_user_id = '.$yx_user_id.'    res = '.$res);
          };
          return;
     }

    public function actions()
    {
        $actions=parent::actions();
        $actions['get-region']=[
            'class'=>\chenkby\region\RegionAction::className(),
            'model'=>\common\models\Region::className()
        ];
        return $actions;
    }
}
