<?php

namespace backend\controllers;

use Yii;
use common\models\YxCompany;
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new YxCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxCompany();

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
            #商家编码
            $model->number=YxCompany::getCmpNumber($model->district);
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

    /**
     * [actionAdjustfraction 分数调整]
     * @Author   Yoon
     * @DateTime 2018-04-09T18:31:29+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function actionAdjustfraction($id){
        $params=Yii::$app->request->post();
        $fraction=$params['ext_history_fraction'];
        if(empty($fraction)){
            $fraction=0;
        }
        $fraction=$fraction*1000;
        $model=YxCompany::findOne($id);
        $model->updateCounters(['total_fraction'=>$fraction]);
        $model->updateCounters(['history_fraction'=>$fraction]);
        $model->updateCounters(['ext_history_fraction'=>$fraction]);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }
}
