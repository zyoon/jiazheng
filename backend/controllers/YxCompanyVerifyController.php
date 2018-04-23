<?php

namespace backend\controllers;

use common\models\YxCompanyVerify;
use common\models\YxCompanyVerifySearch;
use common\tools\CheckController;
use common\models\YxStaff;
use common\models\YxCmpUser;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use common\models\YxCompany;

/**
 * YxCompanyVerifyController implements the CRUD actions for YxCompanyVerify model.
 */
class YxCompanyVerifyController extends CheckController
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
                    'view' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all YxCompanyVerify models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxCompanyVerifySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxCompanyVerify model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $company_model='';
        $ext_fraction=0;
        if(isset($model->company_id)){
            $company_model=YxCompany::findOne($model->company_id);
            if($company_model){
                $ext_fraction=$company_model->ext_fraction/1000;
            }
        }
        if(Yii::$app->request->post()){
            $params=Yii::$app->request->post();
            
            $model->verify_sate=2;
            $model->verify_memo=$params['verify_memo'];
            $model->save();
        }
        return $this->render('view', [
            'model' => $model,
            'ext_fraction'=>$ext_fraction,
        ]);
    }

    /**
     * Creates a new YxCompanyVerify model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxCompanyVerify();
            #所有服务的ID，以逗号隔开，数组转字符串
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
        if ($model->load(Yii::$app->request->post())) {
            $model->business_licences = $model->business_licences[0];
            $model->image = $model->image[0];
            if ($model->save()) {
                $model->setKeywords();
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxCompanyVerify model.
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
     * Deletes an existing YxCompanyVerify model.
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

    public function actionPass($id)
    {
        $model = $this->findModel($id);
        $params=Yii::$app->request->post();
        $ext_fraction=$params['ext_fraction'];
        if(empty($ext_fraction)){
            $ext_fraction=0;
        }
        $model->verify_sate=3;
        $base_fraction=70;
        if(!empty($model->company_id)){
        $company_model=YxCompany::find()->where(['id'=>$model->company_id])->one();
    }else{
        $company_model=new YxCompany();
    }

        if($model['manage_time']==1){
            $base_fraction=$base_fraction+1;
        }
        if($model['manage_time']==3||$model['manage_time']==5){
            $base_fraction=$base_fraction+2;
        }
        if($model['models']==1){
            $base_fraction=$base_fraction+1;
        }
        if(!empty($model['business_licences']&&!empty($model['business_code']))){
            $base_fraction=$base_fraction+2;
        }
        if(!empty($params['ext_fraction'])){
            $base_fraction=$base_fraction+$ext_fraction;
        }
        $company_model['name']=$model['name'];
        $company_model['province']=$model['province'];
        $company_model['city']=$model['city'];
        $company_model['district']=$model['district'];
        $company_model['address']=$model['address'];
        $company_model['telephone']=$model['telephone'];
        $company_model['charge_phone']=$model['charge_phone'];
        $company_model['charge_man']=$model['charge_man'];
        $company_model['longitude']=$model['longitude'];
        $company_model['latitude']=$model['latitude'];
        $company_model['operating_radius']=$model['operating_radius'];
        $company_model['wechat']=$model['wechat'];
        //$company_model['created_at']=$model['created_at'];
        //$company_model['updated_at']=$model['updated_at'];
        $company_model['status']=$model['status'];
        $company_model['business_licences']=$model['business_licences'];
        $company_model['models']=$model['models'];
        $company_model['introduction']=$model['introduction'];
        $company_model['main_server_id']=$model['main_server_id'];
        $company_model['all_server_id']=$model['all_server_id'];
        $company_model['query']=$model['query'];
        $company_model['cmp_user_id']=$model['cmp_user_id'];
        $company_model['image']=$model['image'];
        $company_model['total_fraction']=$base_fraction*1000;
        if(!empty($model->company_id)){
            $company_model['total_fraction']=$base_fraction*1000+$company_model['history_fraction'];
        }
        $company_model['base_fraction']=$base_fraction*1000;
        $company_model['ext_fraction']=$ext_fraction*1000;
        $company_model['banck_card']=$model['banck_card'];
        $company_model['manage_time']=$model['manage_time'];
        $company_model['alipay']=$model['alipay'];
        $company_model['business_code']=$model['business_code'];
        $company_model['number'] = $model['number'];

        if(empty($model['number'])){
            $company_model['number']=YxCompany::getCmpNumber($model->district);
        }
        
        $user = YxCmpUser::findOne($model['cmp_user_id']);
        if($company_model->save()){
            $company_id=$company_model->attributes['id'];
            $model->company_id=$company_id;
            $user->company_id=$company_id;
            if($model->save()&&$user->save()){
                return $this->redirect(['yx-company/view', 'id' => $model->company_id]);
            }
        }
        return print_r($company_model->getErrors());
    }
    /**
     * Finds the YxCompanyVerify model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxCompanyVerify the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxCompanyVerify::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actions()
    {
        $actions = parent::actions();
        $actions['get-region'] = [
            'class' => \chenkby\region\RegionAction::className(),
            'model' => \common\models\Region::className(),
        ];
        return $actions;
    }
}
