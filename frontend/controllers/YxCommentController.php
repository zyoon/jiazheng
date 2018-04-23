<?php

namespace frontend\controllers;

use Yii;
use common\models\YxComment;
use frontend\models\YxCommentSearch;
use common\models\YxOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YxCommentController implements the CRUD actions for YxComment model.
 */
class YxCommentController extends Controller
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
     * Lists all YxComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YxCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
    public function actionCreate($order_id)
    {
        $model = new YxComment();
        $order = YxOrder::findOne($order_id);
        if(!$order){
            return $this->goBack();
        }
        $comment_count = YxComment::find()->where(['yx_order_id' => $order_id])->count();
        if($comment_count > 0){
            return $this->goBack();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $order->order_state = 10;
            $order->save();
            return $this->redirect(['/yx-order/index', 'yx_user_id' => Yii::$app->user->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'order' => $order,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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

        return $this->redirect(['index']);
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

    // 根据订单插入值
    public function actionComment() {
      $request = Yii::$app->request;
  		$id = $request->get('order_id');
      return $this->render('comment');
    }
}
