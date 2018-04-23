<?php

namespace console\controllers;

use Yii;
use common\models\YxComment;
use common\models\YxCommentSearch;
use common\tools\CheckController;
use common\models\YxOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\YxStaff;
/**
 * YxCommentController implements the CRUD actions for YxComment model.
 */
class YxCommentController extends CheckController
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all YxComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxCommentSearch();
        $queryParams=Yii::$app->request->queryParams;
        if(!isset($queryParams['YxCommentSearch'])||empty($queryParams['YxCommentSearch'])){
            $queryParams['YxCommentSearch']=array();
        }
        if (isset($queryParams['company_id'])) {
            $queryParams['YxCommentSearch']['yx_company_id']=$queryParams['company_id'];
        }
        if (isset($queryParams['staff_id'])) {
            $queryParams['YxCommentSearch']['yx_staff_id']=$queryParams['staff_id'];
        }
        if (isset($queryParams['order_id'])) {
            $queryParams['YxCommentSearch']['yx_order_id']=$queryParams['order_id'];
        }
        // if ($queryParams) {
        //     return print_r($queryParams);
        // }
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YxComment model.
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
     * Creates a new YxComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YxComment();
        $queryParams=Yii::$app->request->queryParams;
        $view_url='view';
        $uri="";
        if (isset($queryParams['company_id'])) {
            $model->yx_company_id=$queryParams['company_id'];
            $uri='?company_id='.$queryParams['company_id'];
        }
        if (isset($queryParams['staff_id'])) {
            $model->yx_staff_id=$queryParams['staff_id'];
            $model->yx_company_id=(YxStaff::findOne($queryParams['staff_id']))['company_id'];
            $uri='?staff_id='.$queryParams['staff_id'];
        }
        if (isset($queryParams['order_id'])) {
            $order_model=YxOrder::findOne($queryParams['order_id']);
            $model->yx_order_id=$queryParams['order_id'];
            $model->yx_company_id=$order_model->yx_company_id;
            $model->yx_staff_id=$order_model->yx_staff_id;
            $model->yx_user_id=$order_model->yx_user_id;
            $uri='?order_id='.$queryParams['order_id'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $view_url=$view_url.$uri.'&id='.$model->id;
            #设置运营分数
            $model->setHistoryFraction();
            return $this->redirect([$view_url]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing YxComment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $view_url='view';
        $uri="";
        if (isset($queryParams['company_id'])) {
            $uri='?company_id='.$queryParams['company_id'];
        }
        if (isset($queryParams['staff_id'])) {
            $uri='?staff_id='.$queryParams['staff_id'];
        }
        if (isset($queryParams['order_id'])) {
            $uri='?order_id='.$queryParams['order_id'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $view_url=$view_url.$uri.'&id='.$model->id;
            return $this->redirect(['view_url']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing YxComment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $index_url='index';
        $uri='';
        if (isset($queryParams['company_id'])) {
            $uri='?company_id='.$queryParams['company_id'];
        }
        if (isset($queryParams['staff_id'])) {
            $uri='?staff_id='.$queryParams['staff_id'];
        }
        if (isset($queryParams['order_id'])) {
            $uri='?order_id='.$queryParams['order_id'];
        }
        $index_url=$index_url.$uri;
        return $this->redirect([$index_url]);
    }

    /**
     * Finds the YxComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YxComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YxComment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
