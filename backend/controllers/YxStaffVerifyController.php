<?php

namespace backend\controllers;

use common\models\YxStaff;
use common\models\YxStaffImg;
use common\models\YxStaffImgSearch;
use common\models\YxStaffVerify;
use common\models\YxStaffVerifySearch;
use common\models\YxCompany;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\tools\CheckController;
/**
 * YxStaffVerifyController implements the CRUD actions for YxStaffVerify model.
 */
class YxStaffVerifyController extends CheckController
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
                    // 'view' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all YxStaffVerify models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxStaffVerifySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxStaffVerify model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new YxStaffImgSearch();
        $model = $this->findModel($id);
        $model2 = YxStaffImg::find()->where(['verify_state' => 1, 'staff_verify_id' => $id])->all();
        #资格证书查询参数
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['YxStaffImgSearch'] = ['staff_verify_id' => $id];
        $dataProvider = $searchModel->search($queryParams);

        $staff_model = '';
        $ext_fraction = 0;
        if (isset($model->staff_id)) {
            $staff_model = YxCompany::findOne($model->staff_id);
            if ($staff_model) {
                $ext_fraction = $staff_model->ext_fraction / 1000;
            }
        }

        if (Yii::$app->request->post()) {

            $params = Yii::$app->request->post();
            $model = $this->findModel($id);

            $model->staff_verify_state = 2;
            $model->staff_verify_memo = $params['staff_verify_memo'];

            $model->save();
            foreach ($model2 as $key => $value) {
                $model2[$key]['verify_state'] = 2;
                $model2[$key]->save();
            }
        }

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ext_fraction' => $ext_fraction,

        ]);
    }

    /**
     * Creates a new YxStaffVerify model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxStaffVerify();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxStaffVerify model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $UpdataParams = Yii::$app->request->post();

        #取相关证书
        $staff_type1_model2 = YxStaffImg::find()->where(['staff_verify_id' => $id])->all();
        if (!empty($staff_type1_model2)) {
            $memory = array();
            $memory['image'] = array();
            foreach ($staff_type1_model2 as $key => $value) {
                array_push($memory['image'], $value['image']);
            }
            $type1_model2 = $staff_type1_model2[0];
            $type1_model2->image = $memory['image'];
        } else {
            $type1_model2 = new YxStaffImg();
        }
        $model->staff_age = date('Y-m-d', $model->staff_age);
        #员工的修改
        if ($model->load(Yii::$app->request->post())) {
            $model->staff_age = strtotime($model->staff_age);

            #所有服务的ID，以逗号隔开，数组转字符串
            if (!empty($model->staff_all_server_id)) {
                $arr_staff_all_server_id = $model->staff_all_server_id;
                $str_staff_all_server_id = '';
                foreach ($arr_staff_all_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_staff_all_server_id = $value;
                    } else {
                        $str_staff_all_server_id = $str_staff_all_server_id . ',' . $value;
                    }
                }
                $model->staff_all_server_id = $str_staff_all_server_id;
            }

            #修改搜索关键词
            $str_server_id = $model->staff_all_server_id . ',' . $model->staff_main_server_id;
            if (empty($model->staff_all_server_id)) {
                $str_server_id = $model->staff_main_server_id;
            }
            $model->staff_query = YxStaff::getAllServer($str_server_id);

            #修改图片路径
            $model->staff_img = $model->staff_img[0];
            $model->staff_idcard_front = $model->staff_idcard_front[0];
            $model->staff_idcard_back = $model->staff_idcard_back[0];
            $model->staff_health_img = $model->staff_health_img[0];
            if ($model->save()) {
                #相关证书的修改
                if ($UpdataParams) {
                    $count_model2 = count($staff_type1_model2);
                    if (isset($UpdataParams['YxStaffImg'])) {
                        $count_params = count($UpdataParams['YxStaffImg']['image']);
                        foreach ($UpdataParams['YxStaffImg']['image'] as $key => $value) {
                            if (isset($staff_type1_model2[$key])) {
                                $staff_type1_model2[$key]['image'] = $value;
                                $staff_type1_model2[$key]->save();
                            } else {
                                $insert_ysi_model = new YxStaffImg();
                                $insert_ysi_model->staff_verify_id = $id;
                                $insert_ysi_model->image = $value;
                                $insert_ysi_model->verify_state = $model->staff_verify_state;
                                $insert_ysi_model->save();
                            }
                        }
                        if ($count_model2 > $count_params) {
                            for ($key = $key + 1; $key < $count_model2; $key++) {
                                $staff_type1_model2[$key]->delete();
                            }
                        }
                    } else if (isset($staff_type1_model2)) {
                        foreach ($staff_type1_model2 as $key => $value) {
                            $staff_type1_model2[$key]->delete();
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model2' => $type1_model2,
        ]);
    }

    /**
     * Deletes an existing YxStaffVerify model.
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
     * [actionPass 通过审核]
     * @Author   Yoon
     * @DateTime 2018-03-19T18:28:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function actionPass($id)
    {
        $model = $this->findModel($id);
        $model->staff_verify_state = 3;
        $params = Yii::$app->request->post();
        $ext_fraction = $params['ext_fraction'];
        $base_fraction = 70;
        $ext_fraction = $params['ext_fraction'];
        if (empty($ext_fraction)) {
            $ext_fraction = 0;
        }
        $staff_model = [];

        if (!empty($model->staff_id)) {
            $staff_model = YxStaff::find()->where(['staff_id' => $model->staff_id])->one();
        } else {
            $staff_model = new YxStaff();

        }
        if (!empty($model['staff_img'])) {
            $base_fraction += 0.5;
        }
        if (!empty($model['staff_name']) && !empty($model['staff_idcard_front']) && !empty($model['staff_idcard']) && !empty($model['staff_idcard_back'])) {
            $base_fraction += 1;
        }
        if ($model['staff_manage_time'] == 1) {
            $base_fraction += 1;
        }
        if ($model['staff_manage_time'] >= 2) {
            $base_fraction += 2;
        }
        if (!empty($model['staff_health_img'])) {
            $base_fraction += 1.5;
        }
        if (!empty($model['staff_train']) && trim($model['staff_train']) != '无') {
            $base_fraction += 1;
        }
        if (!empty($model['staff_crime_record']) && trim($model['staff_crime_record']) != '无') {
            $base_fraction -= 30;
        }
        if (!empty($model['staff_sin_record']) && trim($model['staff_sin_record']) != '无') {
            $base_fraction -= 10;
        }
        if (!empty($params['ext_fraction'])) {
            $base_fraction += $ext_fraction;
        }
        $staff_model['staff_name'] = $model['staff_name'];
        $staff_model['company_id'] = $model['company_id'];
        $staff_model['staff_province'] = $model['staff_province'];
        $staff_model['staff_city'] = $model['staff_city'];
        $staff_model['staff_district'] = $model['staff_district'];
        $staff_model['staff_address'] = $model['staff_address'];
        $staff_model['staff_sex'] = $model['staff_sex'];
        $staff_model['staff_age'] = $model['staff_age'];
        $staff_model['staff_img'] = $model['staff_img'];
        // $staff_model['longitude']=$model['longitude'];
        // $staff_model['latitude']=$model['latitude'];
        $staff_model['staff_idcard'] = $model['staff_idcard'];
        $staff_model['staff_intro'] = $model['staff_intro'];
        $staff_model['staff_state'] = $model['staff_state'];
        $staff_model['staff_memo'] = $model['staff_memo'];
        $staff_model['staff_login_ip'] = $model['staff_login_ip'];
        $staff_model['staff_login_time'] = $model['staff_login_time'];
        $staff_model['staff_main_server_id'] = $model['staff_main_server_id'];
        $staff_model['staff_all_server_id'] = $model['staff_all_server_id'];
        $staff_model['staff_query'] = $model['staff_query'];

        $staff_model['staff_fraction'] = $base_fraction * 1000;
        if (!empty($model->staff_id)) {
            $staff_model['staff_fraction'] = $base_fraction * 1000 + $staff_model['staff_history_fraction'];
        }
        $staff_model['staff_base_fraction'] = $base_fraction * 1000;
        $staff_model['ext_fraction'] = $ext_fraction;

        $staff_model['staff_manage_time'] = $model['staff_manage_time'];
        $staff_model['staff_idcard_front'] = $model['staff_idcard_front'];
        $staff_model['staff_idcard_back'] = $model['staff_idcard_back'];
        $staff_model['staff_address'] = $model['staff_address'];
        $staff_model['staff_educate'] = $model['staff_educate'];
        $staff_model['staff_skill'] = $model['staff_skill'];
        $staff_model['staff_crime_record'] = $model['staff_crime_record'];
        $staff_model['staff_sin_record'] = $model['staff_sin_record'];
        $staff_model['staff_health_img'] = $model['staff_health_img'];
        $staff_model['staff_train'] = $model['staff_train'];
        $staff_model['staff_number'] = $model['staff_number'];

        if (empty($model['staff_number'])) {
            $staff_model['staff_number'] = YxStaff::getStaffNumber($model->staff_district);
        }

        if ($staff_model->save()) {
            $staff_id = $staff_model->attributes['staff_id'];
            $model->staff_id = $staff_id;
            if ($model->save()) {
                $model2 = YxStaffImg::find()->where(['and', 'staff_id' => $staff_id, ['or', 'staff_verify_id' => $id]])->all();
                if ($model2) {
                    foreach ($model2 as $key => $value) {
                        if ($model2[$key]['staff_verify_id'] == $id) {
                            $model2[$key]['verify_state'] = 3;
                            $model2[$key]['staff_id'] = $staff_id;
                            $model2[$key]->save();
                        } else {
                            $model2[$key]['verify_state'] = 2;
                            $model2[$key]['staff_id'] = $staff_id;
                            $model2[$key]->save();
                        }

                    }
                    $count_model2 = YxStaffImg::find()->where(['staff_id' => $staff_id, 'verify_state' => 3])->count();
                    if ($count_model2 > 0) {
                        $staff_model->updateCounters(['staff_fraction' => 1000]);
                        $staff_model->updateCounters(['staff_base_fraction' => 1000]);
                        $staff_model->updateCounters(['ext_fraction' => 1000]);
                    }
                }

                return $this->redirect(['yx-staff/view', 'id' => $model->staff_id]);
            }
        }
    }

    /**
     * Finds the YxStaffVerify model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxStaffVerify the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxStaffVerify::findOne($id)) !== null) {
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
