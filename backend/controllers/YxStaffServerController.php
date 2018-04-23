<?php

namespace backend\controllers;

use common\models\YxStaffServer;
use common\models\YxServer;
use common\models\YxStaffServerSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\tools\CheckController;

/**
 * YxStaffServerController implements the CRUD actions for YxStaffServer model.
 */
class YxStaffServerController extends CheckController
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
     * Lists all YxStaffServer models.
     * @return mixed
     */
    public function actionIndex($staff_id)
    {
        $searchModel = new YxStaffServerSearch();
        #在查询参数中添加服务人员ID
        $queryParams = Yii::$app->request->queryParams;
        if (!empty($staff_id)) {
            if (!isset($queryParams['YxStaffServerSearch'])) {
                $queryParams['YxStaffServerSearch'] = ['staff_id' => $staff_id];
                $queryParams['YxStaffServerSearch']['server_type'] = 0;
            } else {
                $queryParams['YxStaffServerSearch']['staff_id'] =$staff_id;
                $queryParams['YxStaffServerSearch']['server_type'] = 0;
            }
        } else {
            $queryParams['YxStaffServerSearch'] = ['staff_id' => -1];
        }
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAppend($staff_id,$server_id)
    {
        $searchModel = new YxStaffServerSearch();
        #修改查询参数
        $queryParams = Yii::$app->request->queryParams;
        if (!empty($staff_id)) {
            if (!isset($queryParams['YxStaffServerSearch'])) {
                $queryParams['YxStaffServerSearch'] = ['staff_id' => $staff_id];
                $queryParams['YxStaffServerSearch']['server_type'] =1;
                $queryParams['YxStaffServerSearch']['server_parent_id'] = $server_id;

            } else {
                $queryParams['YxStaffServerSearch']['staff_id'] =$staff_id;
                $queryParams['YxStaffServerSearch']['server_type'] =1;
                $queryParams['YxStaffServerSearch']['server_parent_id'] = $server_id;
            }
        } else {
            $queryParams['YxStaffServerSearch'] = ['staff_id' => -1];
        }
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('append', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxStaffServer model.
     * @param integer $staff_id
     * @param integer $server_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($staff_id, $server_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($staff_id, $server_id),
        ]);
    }

    public function actionAppendview($staff_id, $server_id)
    {
        return $this->render('appendview', [
            'model' => $this->findModel($staff_id, $server_id),
        ]);
    }

    /**
     * Creates a new YxStaffServer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($staff_id)
    {
        $model = new YxStaffServer();

        if ($model->load(Yii::$app->request->post())) {
            $model->staff_id=$staff_id;
            $model->server_price=$model->server_price * 100;
            $server_model=YxServer::find()->where(['server_id'=>$model->server_id])->one();
            if ($model->save()) {
                // $append_server_model=YxServer::find()->where(['server_parent'=>$model->server_id])->all();
                // foreach ($append_server_model as $key => $value) {
                //     $new_model = new YxStaffServer();
                //     $new_model->staff_id=$staff_id;
                //     $new_model->server_id=$append_server_model[$key]->server_id;
                //     $new_model->server_parent_id=$append_server_model[$key]->server_parent;
                //     $new_model->server_name=$append_server_model[$key]->server_name;
                //     $new_model->server_type=1;
                //     $new_model->save();
                // }
                return $this->redirect(['view', 'staff_id' => $model->staff_id, 'server_id' => $model->server_id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionAppendcreate($staff_id,$server_id)
    {
        $model = new YxStaffServer();
        $model->server_parent_id=$server_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->staff_id=$staff_id;
            $model->server_price=$model->server_price * 100;
            $model->server_type=1;
            if ($model->save()) {
                return $this->redirect(['appendview', 'staff_id' => $model->staff_id, 'server_id' => $model->server_id]);
            }

        }

        return $this->render('appendcreate', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxStaffServer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $staff_id
     * @param integer $server_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($staff_id, $server_id)
    {
        $model = $this->findModel($staff_id, $server_id);
        $model->server_price = $model->server_price / 100;
        $server_model=YxServer::find()->where(['server_id'=>$model->server_id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->server_price = $model->server_price * 100;
            $model->staff_id = $staff_id;
            if ($model->save()) {
                return $this->redirect(['view', 'staff_id' => $model->staff_id, 'server_id' => $model->server_id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionAppendupdate($staff_id, $server_id)
    {
        $model = $this->findModel($staff_id, $server_id);
        $model->server_price = $model->server_price / 100;
        $server_type=$model->server_type;
        if ($model->load(Yii::$app->request->post())) {
            $model->server_price = $model->server_price * 100;
            $model->staff_id = $staff_id;
            $model->server_type=$server_type;
            if ($model->save()) {
                return $this->redirect(['view', 'staff_id' => $model->staff_id, 'server_id' => $model->server_id]);
            }

        }

        return $this->render('appendupdate', [
            'model' => $model,
        ]);
    }

    public function actionTest($server_id)
    {
        $server = YxStaffServer::getChildServer($server_id);
        foreach ($server as $key => $value) {
            echo "<option value='" . $key . "'>" . $value . "</option>";
        }
    }
    /**
     * Deletes an existing YxStaffServer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $staff_id
     * @param integer $server_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($staff_id, $server_id)
    {
        $this->findModel($staff_id, $server_id)->delete();

        return $this->redirect(['index','staff_id'=>$staff_id]);
    }

    /**
     * Finds the YxStaffServer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $staff_id
     * @param integer $server_id
     * @return YxStaffServer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($staff_id, $server_id)
    {
        if (($model = YxStaffServer::findOne(['staff_id' => $staff_id, 'server_id' => $server_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
