<?php

use common\models\YxServer;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\YxStaffServer */
$queryParams = Yii::$app->request->queryParams;
$staff_id = $queryParams['staff_id'];
$server_id = $queryParams['server_id'];



$this->title = $model->server->server_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '已选服务列表'), 'url' => ['index?staff_id=' . $model->staff_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-server-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?=Html::a(Yii::t('app', '修改'), ['update', 'staff_id' => $model->staff_id, 'server_id' => $model->server_id], ['class' => 'btn btn-primary']);?>
        <?=Html::a(Yii::t('app', '删除'), ['delete', 'staff_id' => $model->staff_id, 'server_id' => $model->server_id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => Yii::t('app', '您确定删除此项吗?'),
        'method' => 'post',
    ],
]);?>
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        // 'staff_id',
        [
            'label' => '服务名称',
            'attribute' => 'server.server_name',
        ],
        [
            'label' => '服务图片',
            'attribute' => 'server.server_pic',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->server->server_pic;
            },
        ],
        [
            'label' => '服务人数',
            'attribute' => 'server.server_mans',
            'filter' => YxServer::getMans(),
            'value' => function ($model) {
                return YxServer::getMansName($model->server->server_mans);
            },
        ],
        // 'server_id',
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
            'value' => function ($model) {
                return YxServer::getCmpStateName($model->server->server_state);
            },
        ],
        [
            'attribute' => 'server_parent_id',
            'value' => function ($model) {
                return YxServer::getCmpParentName($model->server_parent_id);
            },
        ],
    ],
]);?>

</div>
