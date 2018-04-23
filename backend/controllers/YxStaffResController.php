<?php

namespace backend\controllers;

use Yii;
use common\models\YxStaffRes;
use common\models\YxStaffResSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\tools\CheckController;

/**
 * YxStaffResController implements the CRUD actions for YxStaffRes model.
 */
class YxStaffResController extends CheckController
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
     * Lists all YxStaffRes models.
     * @return mixed
     */
    public function actionIndex($staff_id)
    {
        $searchModel = new YxStaffResSearch();
        #在查询参数中添加公司ID
        $queryParams = Yii::$app->request->queryParams;
        if (!empty($staff_id)) {
            if (!isset($queryParams['YxStaffResSearch'])) {
                $queryParams['YxStaffResSearch'] = ['staff_id' => $staff_id];
            } else {
                $queryParams['YxStaffResSearch'] = array_merge($queryParams['YxStaffResSearch'], ['staff_id' => $staff_id]);
            }
        } else {
            $queryParams['YxStaffResSearch'] = ['staff_id' => -1];
        }
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxStaffRes model.
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
     * Creates a new YxStaffRes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($staff_id)
    {
        $model = new YxStaffRes();
        $model->staff_id=$staff_id;
        if ($model->load(Yii::$app->request->post())) {
            $model->staff_res_img=$model->staff_res_img[0];
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->staff_res_id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxStaffRes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->staff_res_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing YxStaffRes model.
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
     * Finds the YxStaffRes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxStaffRes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxStaffRes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
