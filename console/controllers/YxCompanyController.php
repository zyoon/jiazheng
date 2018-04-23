<?php

namespace console\controllers;

use Yii;
use common\models\YxCompany;
use common\models\YxCompanyVerify;
use common\models\YxCompanySearch;
use common\models\YxStaff;



use common\tools\CheckController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YxCompanyController implements the CRUD actions for YxCompany model.
 */
class YxCompanyController extends CheckController
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
     * Lists all YxCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user_info=Yii::$app->user->identity;
        $id=$user_info['company_id'];
        $model=YxCompany::findOne($id);
        if($model){
            return $this->redirect(['view']);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxCompany model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $user_info=Yii::$app->user->identity;
        $id=$user_info['company_id'];
        $model=YxCompany::findOne($id);
        if($model){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->redirect(['index']);
        }
    }

    /**
     * Creates a new YxCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxCompanyVerify();
        $user_info=Yii::$app->user->identity;
        $cmp_user_id=$user_info['id'];
        if ($model->load(Yii::$app->request->post())) {

            #主打服务的ID，以逗号隔开，数组转字符串
            if (!empty($model->main_server_id)) {
                $arr_main_server_id = $model->main_server_id;
                $str_main_server_id = '';
                foreach ($arr_main_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_main_server_id = $value;
                    } else {
                        $str_main_server_id = $str_main_server_id . ',' . $value;
                    }
                }
                $model->main_server_id = $str_main_server_id;
            }
            #副服务的ID，以逗号隔开，数组转字符串
            if (!empty($model->all_server_id)) {
                $arr_all_server_id = $model->all_server_id;
                $str_all_server_id = '';
                foreach ($arr_all_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_all_server_id = $value;
                    } else {
                        $str_all_server_id = $str_all_server_id . ',' . $value;
                    }
                }
                $model->all_server_id = $str_all_server_id;
            }

            #修改搜索关键词
            // $str_server_id = $model->all_server_id . ',' . $model->main_server_id;
            // if(empty($model->all_server_id)){
            //     $str_server_id=$model->main_server_id;
            // }
            // $model->query = YxStaff::getAllServer($str_server_id);
            
            $model->business_licences = $model->business_licences[0];
            $model->image = $model->image[0];
            $model->cmp_user_id=$cmp_user_id;
            if ($model->save()) {
                $model->setKeywords();
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            #主打服务的ID，以逗号隔开，数组转字符串
            if (!empty($model->main_server_id)) {
                $arr_main_server_id = $model->main_server_id;
                $str_main_server_id = '';
                foreach ($arr_main_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_main_server_id = $value;
                    } else {
                        $str_main_server_id = $str_main_server_id . ',' . $value;
                    }
                }
                $model->main_server_id = $str_main_server_id;
            }
            #副服务的ID，以逗号隔开，数组转字符串
            if (!empty($model->all_server_id)) {
                $arr_all_server_id = $model->all_server_id;
                $str_all_server_id = '';
                foreach ($arr_all_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_all_server_id = $value;
                    } else {
                        $str_all_server_id = $str_all_server_id . ',' . $value;
                    }
                }
                $model->all_server_id = $str_all_server_id;
            }

            #修改搜索关键词
            // $str_server_id = $model->all_server_id . ',' . $model->main_server_id;
            // if(empty($model->all_server_id)){
            //     $str_server_id=$model->main_server_id;
            // }
            // $model->query = YxStaff::getAllServer($str_server_id);
            $model->business_licences = $model->business_licences[0];
            $model->image = $model->image[0];
            if ($model->save()) {
                $model->setKeywords();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing YxCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerify($id)
    {
        $model = $this->findModel($id);
        $model2=new YxCompanyVerify();

        $model2['name']=$model['name'];
        $model2['province']=$model['province'];
        $model2['city']=$model['city'];
        $model2['district']=$model['district'];
        $model2['address']=$model['address'];
        $model2['telephone']=$model['telephone'];
        $model2['charge_phone']=$model['charge_phone'];
        $model2['charge_man']=$model['charge_man'];
        $model2['longitude']=$model['longitude'];
        $model2['latitude']=$model['latitude'];
        $model2['operating_radius']=$model['operating_radius'];
        $model2['wechat']=$model['wechat'];
        //$model2['created_at']=$model['created_at'];
        //$model2['updated_at']=$model['updated_at'];
        $model2['number']=$model['number'];
        $model2['status']=$model['status'];
        $model2['business_licences']=$model['business_licences'];
        $model2['models']=$model['models'];
        $model2['introduction']=$model['introduction'];
        $model2['main_server_id']=$model['main_server_id'];
        $model2['all_server_id']=$model['all_server_id'];
        $model2['query']=$model['query'];
        $model2['cmp_user_id']=$model['cmp_user_id'];
        $model2['image']=$model['image'];
        $model2['total_fraction']=$model['total_fraction'];
        $model2['base_fraction']=$model['base_fraction'];
        $model2['history_fraction']=$model['history_fraction'];
        $model2['clinch']=$model['clinch'];
        $model2['price']=$model['price'];
        $model2['manage_time']=$model['manage_time'];
        $model2['alipay']=$model['alipay'];
        $model2['business_code']=$model['business_code'];
        $model2['ext_fraction']=$model['ext_fraction'];

        $user_info=Yii::$app->user->identity;
        $cmp_user_id=$user_info['id'];

        $updateParams=Yii::$app->request->post();

        if($updateParams){
            $updateParams['YxCompanyVerify']['cmp_user_id']=$cmp_user_id;
        }

        if ($model2->load($updateParams)) {
            $model2->company_id=$model->id;
            $model2->number=$model->number;
            #主打服务的ID，以逗号隔开，数组转字符串
            if (!empty($model2->main_server_id)) {
                $arr_main_server_id = $model2->main_server_id;
                $str_main_server_id = '';
                foreach ($arr_main_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_main_server_id = $value;
                    } else {
                        $str_main_server_id = $str_main_server_id . ',' . $value;
                    }
                }
                $model2->main_server_id = $str_main_server_id;
            }
            #副服务的ID，以逗号隔开，数组转字符串
            if (!empty($model2->all_server_id)) {
                $arr_all_server_id = $model2->all_server_id;
                $str_all_server_id = '';
                foreach ($arr_all_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_all_server_id = $value;
                    } else {
                        $str_all_server_id = $str_all_server_id . ',' . $value;
                    }
                }
                $model2->all_server_id = $str_all_server_id;
            }

            #修改搜索关键词
            // $str_server_id = $model2->all_server_id . ',' . $model2->main_server_id;
            // if(empty($model2->all_server_id)){
            //     $str_server_id=$model2->main_server_id;
            // }
            // $model2->query = YxStaff::getAllServer($str_server_id);
            $model2->business_licences = $model2->business_licences[0];
            $model2->image = $model2->image[0];
            if ($model2->save()) {
                $model->setKeywords();
                return $this->redirect(['index']);
            }
        }
        // return print_r($model2->getErrors());

        return $this->render('verify', [
            'model' => $model2,
        ]);
    }
    /**
     * Deletes an existing YxCompany model.
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

    /**
     * Finds the YxCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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
