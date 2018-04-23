<?php

namespace console\controllers;

use common\models\YxStaff;
use common\models\YxStaffImg;
use common\models\YxStaffImgSearch;
use common\models\YxStaffSearch;
use common\models\YxStaffVerify;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * YxStaffController implements the CRUD actions for YxStaff model.
 */
class YxStaffController extends Controller
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
     * Lists all YxStaff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxStaffSearch();
        $user_info = Yii::$app->user->identity;
        $company_id = $user_info['company_id'];
        #在查询参数中添加公司ID
        $queryParams = Yii::$app->request->queryParams;
        // $queryParams['YxStaffSearch'] = ['staff_state_range' => 1];
        if (!empty($company_id)) {
            if (!isset($queryParams['YxStaffSearch'])) {
                $queryParams['YxStaffSearch'] = ['company_id' => $company_id];
            } else {
                $queryParams['YxStaffSearch'] = array_merge($queryParams['YxStaffSearch'], ['company_id' => $company_id]);
            }
        } else {
            $queryParams['YxStaffSearch'] = ['company_id' => -1];
        }
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxStaff model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new YxStaffImgSearch();
        $searchModel2 = new YxStaffImgSearch();
        $model = $this->findModel($id);
        $staff_id = $model->staff_id;
        #资格证书查询参数
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['YxStaffImgSearch'] = ['staff_id' => $staff_id];
        $queryParams['YxStaffImgSearch'] = array_merge($queryParams['YxStaffImgSearch'], ['verify_state' => 3]);
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);

    }

    /**
     * Creates a new YxStaff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxStaffVerify();
        $type1_model2 = new YxStaffImg();
        $UpdataParams = Yii::$app->request->post();

        $user_info = Yii::$app->user->identity;
        $company_id = $user_info['company_id'];
        if ($model->load(Yii::$app->request->post())) {
            $model->staff_age = strtotime($model->staff_age);
            $model->company_id = $company_id;
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
                    if (isset($UpdataParams['YxStaffImg'])) {
                        foreach ($UpdataParams['YxStaffImg']['image'] as $key => $value) {
                            $insert_ysi_model = new YxStaffImg();
                            $insert_ysi_model->staff_id = $model->staff_id;
                            $insert_ysi_model->staff_verify_id = $model->id;
                            $insert_ysi_model->image = $value;
                            $insert_ysi_model->verify_state = 1;
                            $insert_ysi_model->save();
                        }
                    }
                }
                return $this->redirect(['index']);
            }
            // return print_r($model->getErrors());
        }

        return $this->render('create', [
            'model' => $model,
            'model2' => $type1_model2,
        ]);
    }

    /**
     * Updates an existing YxStaff model.
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
        $staff_type1_model2 = YxStaffImg::find()->where(['staff_id' => $id, 'verify_state' => 3])->all();
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
        $model->staff_age = date('Y-m-d');
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
                                $insert_ysi_model->staff_id = $id;
                                $insert_ysi_model->image = $value;
                                $insert_ysi_model->verify_state = 3;
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
                return $this->redirect(['view', 'id' => $model->staff_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model2' => $type1_model2,
        ]);
    }
    /**
     * Updates an existing YxStaff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerify($id)
    {
        $model = $this->findModel($id);
        $model2 = new YxStaffVerify();
        $updateParams = Yii::$app->request->post();
        #取相关证书
        $staff_type1_model2 = YxStaffImg::find()->where(['staff_id' => $model->staff_id,'verify_state'=>3])->all();
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

        if ($updateParams) {
            $updateParams['YxStaff']['company_id'] = $model->company_id;
            $updateParams['YxStaff']['staff_id'] = $model->staff_id;
            if(!empty($model->staff_number)){
                $updateParams['YxStaffVerify']['staff_number']=$model->staff_number;
            }
            $updateParams['YxStaffVerify'] = $updateParams['YxStaff'];
            unset($updateParams['YxStaff']);
        }

        $model->staff_age = date('Y-m-d', $model->staff_age);
        if ($model2->load($updateParams)) {
            $model2->staff_age = strtotime($model->staff_age);

            #所有服务的ID，以逗号隔开，数组转字符串
            if (!empty($model2->staff_all_server_id)) {
                $arr_staff_all_server_id = $model2->staff_all_server_id;
                $str_staff_all_server_id = '';
                foreach ($arr_staff_all_server_id as $key => $value) {
                    if ($key == 0) {
                        $str_staff_all_server_id = $value;
                    } else {
                        $str_staff_all_server_id = $str_staff_all_server_id . ',' . $value;
                    }
                }
                $model2->staff_all_server_id = $str_staff_all_server_id;
            }

            #修改搜索关键词
            $str_server_id = $model2->staff_all_server_id . ',' . $model2->staff_main_server_id;
            if (empty($model2->staff_all_server_id)) {
                $str_server_id = $model2->staff_main_server_id;
            }
            $model2->staff_query = YxStaff::getAllServer($str_server_id);

            #修改图片路径
            $model2->staff_img = $model2->staff_img[0];
            $model2->staff_idcard_front = $model2->staff_idcard_front[0];
            $model2->staff_idcard_back = $model2->staff_idcard_back[0];
            $model2->staff_health_img = $model2->staff_health_img[0];
            $model2->staff_verify_state = 1;

            if ($model2->save()) {
                #相关证书的修改
                if ($updateParams) {
                    $count_model2 = count($staff_type1_model2);
                    if (isset($updateParams['YxStaffImg'])) {
                        $count_params = count($updateParams['YxStaffImg']['image']);
                        foreach ($updateParams['YxStaffImg']['image'] as $key => $value) {
                            $insert_ysi_model = new YxStaffImg();
                            $insert_ysi_model->staff_id = $model2->staff_id;
                            $insert_ysi_model->staff_verify_id = $model2->id;
                            $insert_ysi_model->image = $value;
                            $insert_ysi_model->verify_state = $model2->staff_verify_state;
                            $insert_ysi_model->save();
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->staff_id]);
            }
        }

        return $this->render('verify', [
            'model' => $model,
            'model2' => $type1_model2,
        ]);
    }
    /**
     * Deletes an existing YxStaff model.
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
     * Finds the YxStaff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxStaff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxStaff::findOne($id)) !== null) {
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
