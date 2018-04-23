<?php

namespace backend\controllers;

use common\models\YxServer;
use common\models\YxStaffServer;
use common\models\YxServerSearch;
use common\tools\CheckController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * YxServerController implements the CRUD actions for YxServer model.
 */
class YxServerController extends CheckController
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
     * Lists all YxServer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxServerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxServer model.
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
     * Creates a new YxServer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxServer();
        #设置一级服务ID
        $level_1_server = YxServer::getLvServer(1, 0);
        reset($level_1_server);
        $model->one_server = key($level_1_server);
        #修改输入参数
        $InsertParams = Yii::$app->request->post();
        if ($InsertParams) {

            if ($InsertParams['YxServer']['server_type'] == 2) {
                $InsertParams['YxServer']['server_parent'] = $InsertParams['YxServer']['one_server'];
            }
            if ($InsertParams['YxServer']['server_type'] == 1) {
                $InsertParams['YxServer']['server_parent'] = 0;
            }
            unset($InsertParams['YxServer']['one_server']);
        }
        if ($model->load($InsertParams)) {
            $model->server_pic = $model->server_pic[0];
            if ($model->save()) {
                #修改三级服务
                if ($InsertParams['YxServer']['server_type'] == 3) {
                    $isset_model = YxStaffServer::find()->where(['server_parent_id' => $model->server_parent])->all();
                    if ($isset_model) {
                        foreach ($isset_model as $key => $value) {
                            $staff_server_model = new YxStaffServer();
                            $staff_server_model->staff_id = $isset_model[$key]['staff_id'];
                            $staff_server_model->server_id = $model->server_id;
                            $staff_server_model->server_name = $model->server_name;
                            $staff_server_model->server_parent_id = $model->server_parent;
                            $staff_server_model->server_type = 1;
                            $staff_server_model->save();
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->server_id]);
            };
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxServer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $res = YxServer::getTopServer($id);
        $model->one_server = $res->server_id;
        $InsertParams = Yii::$app->request->post();
        #修改插入参数
        if (isset($InsertParams['YxServer']['one_server'])) {
            if ($InsertParams['YxServer']['server_type'] == 2) {
                $InsertParams['YxServer']['server_parent'] = $InsertParams['YxServer']['one_server'];
            }
            if ($InsertParams['YxServer']['server_type'] == 1) {
                $InsertParams['YxServer']['server_parent'] = 0;
            }
            unset($InsertParams['YxServer']['one_server']);
        }
        if ($model->load($InsertParams)) {
            $model->server_pic = $model->server_pic[0];
            if ($model->save()) {
                #修改三级服务
                if ($InsertParams['YxServer']['server_type'] == 3) {
                    $staff_server_model = YxStaffServer::find()->where(['server_id' => $model->server_id])->all();
                    foreach ($staff_server_model as $key => $value) {
                        $staff_server_model[$key]->server_name = $model->server_name;
                        $staff_server_model[$key]->server_parent_id = $model->server_parent;
                        $staff_server_model[$key]->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->server_id]);
            };
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing YxServer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $server_model = $this->findModel($id);
        $server_model->delete();
        $staff_server_model = YxStaffServer::find()->where(['server_id' => $id])->all();
        if ($staff_server_model) {
            foreach ($staff_server_model as $key => $value) {
                $staff_server_model[$key]->delete();
            }
        }

        return $this->redirect(['index']);
    }

    public function actionServerlink($server_id)
    {
        $server = YxServer::getLvServer(2, $server_id);
        foreach ($server as $key => $value) {
            echo "<option value='" . $key . "'>" . $value . "</option>";
        }
    }

    /**
     * Finds the YxServer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxServer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxServer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
