<?php

namespace console\controllers;

use common\models\YxCmpServer;
use common\models\YxCmpServerSearch;
use common\tools\CheckController;
use common\models\YxServer;
use common\models\YxStaffServer;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * YxCmpServerController implements the CRUD actions for YxCmpServer model.
 */
class YxCmpServerController extends CheckController
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
     * Lists all YxCmpServer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxCmpServerSearch();
        #在查询参数中添加服务人员ID
        $queryParams = Yii::$app->request->queryParams;
        $user_info=Yii::$app->user->identity;
        $company_id=$user_info['company_id'];
        $queryParams['company_id']=$company_id;
        if (!empty($company_id)) {
            if (!isset($queryParams['YxCmpServerSearch'])) {
                $queryParams['YxCmpServerSearch'] = ['company_id' => $company_id];
                $queryParams['YxCmpServerSearch']['server_type'] = 0;
            } else {
                $queryParams['YxCmpServerSearch']['company_id'] = $company_id;
                $queryParams['YxCmpServerSearch']['server_type'] = 0;
            }
        } else {
            $queryParams['YxCmpServerSearch'] = ['company_id' => -1];
        }
        $dataProvider = $searchModel->search($queryParams);
        Yii::$app->request->queryParams=$queryParams;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAppend($company_id,$server_id)
    {
        $searchModel = new YxCmpServerSearch();
        #修改查询参数
        $queryParams = Yii::$app->request->queryParams;
        if (!empty($company_id)) {
            if (!isset($queryParams['YxCmpServerSearch'])) {
                $queryParams['YxCmpServerSearch'] = ['company_id_id' => $company_id];
                $queryParams['YxCmpServerSearch']['server_type'] =1;
                $queryParams['YxCmpServerSearch']['server_parent_id'] = $server_id;

            } else {
                $queryParams['YxCmpServerSearch']['company_id'] =$company_id;
                $queryParams['YxCmpServerSearch']['server_type'] =1;
                $queryParams['YxCmpServerSearch']['server_parent_id'] = $server_id;
            }
        } else {
            $queryParams['YxCmpServerSearch'] = ['company_id' => -1];
        }
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('append', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single YxCmpServer model.
     * @param integer $company_id
     * @param integer $server_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($company_id, $server_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($company_id, $server_id),
        ]);
    }
    public function actionAppendview($company_id, $server_id)
    {
        return $this->render('appendview', [
            'model' => $this->findModel($company_id, $server_id),
        ]);
    }
    /**
     * Creates a new YxCmpServer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($company_id)
    {
        $model = new YxCmpServer();

        if ($model->load(Yii::$app->request->post())) {
            $model->company_id = $company_id;
            $model->server_price = $model->server_price * 100;
            $server_model = YxServer::find()->where(['server_id' => $model->server_id])->one();
            if ($model->save()) {
                // $append_server_model = YxServer::find()->where(['server_parent' => $model->server_id])->all();
                // foreach ($append_server_model as $key => $value) {
                //     $new_model = new YxCmpServer();
                //     $new_model->company_id = $company_id;
                //     $new_model->server_id = $append_server_model[$key]->server_id;
                //     $new_model->server_parent_id = $append_server_model[$key]->server_parent;
                //     $new_model->server_type = 1;
                //     $new_model->save();
                // }
                return $this->redirect(['view', 'company_id' => $model->company_id, 'server_id' => $model->server_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionAppendcreate($company_id,$server_id)
    {
        $model = new YxCmpServer();
        $model->server_parent_id=$server_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->company_id=$company_id;
            $model->server_price=$model->server_price * 100;
            $model->server_type=1;
            if ($model->save()) {
                return $this->redirect(['appendview', 'staff_id' => $model->company_id, 'server_id' => $model->server_id]);
            }

        }

        return $this->render('appendcreate', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxCmpServer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $company_id
     * @param integer $server_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($company_id, $server_id)
    {
        $model = $this->findModel($company_id, $server_id);
        $model->server_price = $model->server_price / 100;
        $server_model = YxServer::find()->where(['server_id' => $model->server_id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->server_price = $model->server_price * 100;
            $model->company_id = $company_id;
            if ($model->save()) {
                return $this->redirect(['view', 'company_id' => $model->company_id, 'server_id' => $model->server_id]);
            }

        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAppendupdate($company_id, $server_id)
    {
        $model = $this->findModel($company_id, $server_id);
        $model->server_price = $model->server_price / 100;
        $server_type=$model->server_type;
        if ($model->load(Yii::$app->request->post())) {
            $model->server_price = $model->server_price * 100;
            $model->company_id = $company_id;
            $model->server_type=$server_type;
            if ($model->save()) {
                return $this->redirect(['view', 'company_id' => $model->company_id, 'server_id' => $model->server_id]);
            }

        }

        return $this->render('appendupdate', [
            'model' => $model,
        ]);
    }

    public function actionServerlink($server_id)
    {
        $server = YxServer::getLvServer(2, $server_id);
        foreach ($server as $key => $value) {
            echo "<option value='" . $key . "'>" . $value . "</option>";
        }
    }

    public function actionTest($server_id)
    {
        $server = YxStaffServer::getChildServer($server_id);
        foreach ($server as $key => $value) {
            echo "<option value='" . $key . "'>" . $value . "</option>";
        }
    }
    /**
     * Deletes an existing YxCmpServer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $company_id
     * @param integer $server_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($company_id, $server_id)
    {
        $this->findModel($company_id, $server_id)->delete();

        return $this->redirect(['index', 'company_id' => $company_id]);
    }

    /**
     * Finds the YxCmpServer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $company_id
     * @param integer $server_id
     * @return YxCmpServer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($company_id, $server_id)
    {
        if (($model = YxCmpServer::findOne(['company_id' => $company_id, 'server_id' => $server_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
