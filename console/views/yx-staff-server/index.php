<?php

use common\models\YxServer;
use common\models\YxStaffServer;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxStaffServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '已选服务列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-server-index">

    <h1><?=Html::encode($this->title);?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ;;?>

    <p>
        <?php

$queryParams = Yii::$app->request->queryParams;
$staff_id = $queryParams['staff_id'];
?>

        <?=Html::a(Yii::t('app', '添加服务'), ['create?staff_id=' . $staff_id], ['class' => 'btn btn-success']);?>
    </p>

    <?=GridView::widget([
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
            'filter' => YxStaffServer::getParentServer($staff_id),
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
                        $url="/yx-staff-server/append?staff_id=".$model->staff_id."&server_id=".$model->server_id;
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', $url, ['title' => '附加服务列表']);
                    },
                ]
            ],
    ],
]);?>
</div>
