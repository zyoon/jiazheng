<?php

namespace console\controllers;

use common\models\YxStaff;
use common\models\YxStaffImg;
use common\models\YxStaffImgSearch;
use common\models\YxStaffVerify;
use common\models\YxStaffVerifySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * YxStaffVerifyController implements the CRUD actions for YxStaffVerify model.
 */
class YxStaffVerifyController extends Controller
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
        #在查询参数中添加公司ID
        $user_info = Yii::$app->user->identity;
        $company_id = $user_info['company_id'];
        $queryParams = Yii::$app->request->queryParams;
        if (!empty($company_id)) {
            if (!isset($queryParams['YxStaffVerifySearch'])) {
                $queryParams['YxStaffVerifySearch'] = ['company_id' => $company_id];
            } else {
                $queryParams['YxStaffVerifySearch'] = array_merge($queryParams['YxStaffVerifySearch'], ['company_id' => $company_id]);
            }
        } else {
            $queryParams['YxStaffVerifySearch'] = ['company_id' => -1];
        }

        $dataProvider = $searchModel->search($queryParams);

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
        $model2 = YxStaffImg::findAll($id);
        #资格证书查询参数
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['YxStaffImgSearch'] = ['staff_verify_id' => $id];
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

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
        $updateParams = Yii::$app->request->post();
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
        $updateParams['YxStaffVerify']['company_id']=$model->company_id;
        $updateParams['YxStaffVerify']['staff_id']=$model->staff_id;
        if(!empty($model->staff_number)){
            $updateParams['YxStaffVerify']['staff_number']=$model->staff_number;
        }

        $model->staff_age = date('Y-m-d', $model->staff_age);
        if ($model->load(Yii::$app->request->post())) {

            #所有服务的ID，以逗号隔开，数组转字符串
            if (!empty($model->staff_all_server_id)) {
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
                $model->staff_verify_state = 1;

                if ($model->save()) {
                    #相关证书的修改
                    if ($updateParams) {
                        $count_model2 = count($staff_type1_model2);
                        if (isset($updataParams['YxStaffImg'])) {
                            $count_params = count($updataParams['YxStaffImg']['image']);
                            foreach ($updataParams['YxStaffImg']['image'] as $key => $value) {
                                if (isset($staff_type1_model2[$key])) {
                                    $staff_type1_model2[$key]['image'] = $value;
                                    $staff_type1_model2[$key]->save();
                                } else {
                                    $insert_ysi_model = new YxStaffImg();
                                    $insert_ysi_model->staff_id = $model->staff_id;
                                    $insert_ysi_model->image = $value;
                                    $insert_ysi_model->staff_verify_id = $id;
                                    $insert_ysi_model->verify_state = 1;
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
        if ($model->staff_id) {
            $staff_model = YxStaff::find()->where(['staff_id' => $model->id])->one();
        } else {
            $staff_model = new YxStaff();

        }
        $staff_model['staff_name'] = $model['staff_name'];
        $staff_model['company_id'] = $model['company_id'];
        // $staff_model['province']=$model['province'];
        // $staff_model['city']=$model['city'];
        // $staff_model['district']=$model['district'];
        // $staff_model['address']=$model['address'];
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
        $staff_model['staff_account'] = $model['staff_account'];
        $staff_model['staff_password'] = $model['staff_password'];
        $staff_model['staff_main_server_id'] = $model['staff_main_server_id'];
        $staff_model['staff_all_server_id'] = $model['staff_all_server_id'];
        $staff_model['staff_query'] = $model['staff_query'];
        if ($staff_model->save()) {
            $staff_id = $staff_model->attributes['staff_id'];
            $model->staff_id = $staff_id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
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
