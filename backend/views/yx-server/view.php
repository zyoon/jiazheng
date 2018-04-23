<?php

use common\models\YxServer;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\YxServer */

$this->title = $model->server_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '服务列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-server-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?=Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->server_id], ['class' => 'btn btn-primary']);?>
        <?=Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->server_id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => Yii::t('app', '您确定要删除此项吗?'),
        'method' => 'post',
    ],
]);?>
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        'server_id',
        'server_name',
        [
            'attribute' => 'server_type',
            'value' => function ($model) {
                return YxServer::getCmpTypeName($model->server_type);
            },
        ],
        [
            'attribute' => 'server_parent',
            'value' => function ($model) {
                return YxServer::getCmpParentName($model->server_parent);
            },
        ],
        [
            'attribute' => 'server_state',
            'value' => function ($model) {
                return YxServer::getCmpStateName($model->server_state);
            },
        ],
        'server_memo',
        'server_unit',
        [
            'attribute' => 'server_pic',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->server_pic;
            },
        ],
        'server_class',
        [
            'attribute' => 'server_mans',
            'filter' => YxServer::getMans(),
            'value' => function ($model) {
                return YxServer::getMansName($model->server_mans);
            },
        ],
    ],
]);?>

</div>
