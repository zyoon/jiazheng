<?php

namespace backend\controllers;

use Yii;
use common\models\YxCmpRes;
use common\models\YxCmpResSearch;
use common\tools\CheckController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YxCmpResController implements the CRUD actions for YxCmpRes model.
 */
class YxCmpResController extends CheckController
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
     * Lists all YxCmpRes models.
     * @return mixed
     */
    public function actionIndex($company_id)
    {
        $searchModel = new YxCmpResSearch();
        #在查询参数中添加公司ID
        $queryParams = Yii::$app->request->queryParams;
        if (!empty($company_id)) {
            if (!isset($queryParams['YxCmpResSearch'])) {
                $queryParams['YxCmpResSearch'] = ['company_id' => $company_id];
            } else {
                $queryParams['YxCmpResSearch'] = array_merge($queryParams['YxCmpResSearch'], ['company_id' => $company_id]);
            }
        } else {
            $queryParams['YxCmpResSearch'] = ['company_id' => -1];
        }
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxCmpRes model.
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
     * Creates a new YxCmpRes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($company_id)
    {
        $model = new YxCmpRes();
        $model->company_id=$company_id;
        if ($model->load(Yii::$app->request->post())) {
            $model->cmp_res_img=$model->cmp_res_img[0];
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->cmp_res_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxCmpRes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->cmp_res_img=$model->cmp_res_img[0];
            if($model->save()){
               return $this->redirect(['view', 'id' => $model->cmp_res_id]); 
            }
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing YxCmpRes model.
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
     * Finds the YxCmpRes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxCmpRes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxCmpRes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
