<?php

namespace backend\controllers;

use Yii;
use common\models\YxRecomLeft;
use common\models\YxRecomLeftSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\tools\CheckController;
use yii\filters\VerbFilter;

/**
 * YxRecomLeftController implements the CRUD actions for YxRecomLeft model.
 */
class YxRecomLeftController extends CheckController
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
     * Lists all YxRecomLeft models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxRecomLeftSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxRecomLeft model.
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
     * Creates a new YxRecomLeft model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sum = YxRecomLeft::find()->count();
        $model = new YxRecomLeft();
        if ($sum < 4) {
            if ($model->load(Yii::$app->request->post())) {
                $model->recom_left_pic = $model->recom_left_pic[0];
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->recom_left_id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxRecomLeft model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->recom_left_pic = $model->recom_left_pic[0];
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->recom_left_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing YxRecomLeft model.
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
     * Finds the YxRecomLeft model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxRecomLeft the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxRecomLeft::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
