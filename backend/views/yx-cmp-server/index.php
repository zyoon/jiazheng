<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxCmpServerSearch;
use common\models\YxServer;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxCmpServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$queryParams = Yii::$app->request->queryParams;
$company_id = $queryParams['company_id'];
$this->title = '服务列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-cmp-server-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增', ['create?company_id='.$company_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
         // 'staff_id',
        [
            'label' => '服务名称',
            'attribute' => 'server.server_name',
        ],
        // 'server_id',
        [
            'attribute' => 'server_parent_id',
            'filter' => YxServer::getAllLvServer(1,0),
            'value' => function ($model) {
                return YxServer::getCmpParentName($model->server_parent_id);
            },
        ],
        [
            'attribute' => 'server_least',
            'value' => function ($model) {
                return $model->server_least . $model->server->server_unit;
            },
        ],
        [
            'label' => '单位',
            'attribute' => 'server.server_unit',
        ],
        [
            'attribute' => 'server_price',
            'value' => function ($model) {
                $price = $model->server_price / 100;
                return $price . '元';
            },
        ],
        [
            'label' => '状态',
            'attribute' => 'server.server_state',
            'filter' => YxServer::getCmpState(),
            'value' => function ($model) {
                return YxServer::getCmpStateName($model->server->server_state);
            },
        ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作', 
                'template' => '{view} {update} {delete} {append-list}',
                'buttons'=>[
                    'append-list'=>function($url,$model){
                        $url="/yx-cmp-server/append?company_id=".$model->company_id."&server_id=".$model->server_id;
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', $url, ['title' => '附加服务列表']);
                    },
                ]
            ],
        ],
    ]); ?>
</div>
