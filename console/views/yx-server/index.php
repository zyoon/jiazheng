<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxServer;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '服务列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-server-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '添加服务'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'server_id',
            'server_name',
            [
              'attribute'=>'server_type',
              'filter'=>YxServer::getCmpType(),
              'value' => function($model) {
                  return YxServer::getCmpTypeName($model->server_type);
              }
            ],
           // 'server_parent',
            [
              'attribute'=>'server_parent',
              'filter'=>YxServer::getCmpParent(),
              'value' => function($model) {
                  return YxServer::getCmpParentName($model->server_parent);
              }
            ],
            [
              'attribute'=>'server_state',
              'filter'=>YxServer::getCmpState(),
              'value' => function($model) {
                  return YxServer::getCmpStateName($model->server_state);
              }
            ],

            //'server_memo',
            //'server_sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
