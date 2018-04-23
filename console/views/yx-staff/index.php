<?php

use common\models\YxStaff;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\YxStaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '员工列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-index">

    <h1><?=Html::encode($this->title);?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?=Html::a(Yii::t('app', '添加员工'), ['create'], ['class' => 'btn btn-success']);?>
    </p>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'staff_id',
        // 'company_id',
        'staff_name',
        [
            'attribute' => 'staff_sex',
            'filter' => YxStaff::getCmpSex(),
            'value' => function ($model) {
                return YxStaff::getCmpSexName($model->staff_sex);
            },
        ],
        [
            'attribute' => 'staff_age',
            'value' => function ($model) {
                return date('Y-m-d', $model->staff_age);
            },
        ],
        //'staff_img',
        'staff_idcard',
        //'staff_intro',
        //'staff_found',
        //'staff_main_server',
        //'staff_all_server',
        [
            'attribute' => 'staff_state',
            'filter' => YxStaff::getCmpState(),
            'value' => function ($model) {
                return YxStaff::getCmpStateName($model->staff_state);
            },
        ],
        //'staff_memo',
        //'staff_login_ip',
        //'staff_login_time',
        //'staff_account',
        //'staff_password',
        //'staff_main_server_id',
        //'staff_all_server_id',
        //'staff_query:ntext',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{view} {server-list} {res-list} {order-list} {comment-list}',
            'buttons' => [
                'server-list' => function ($url, $model) {
                    $url = "/yx-staff-server/index?staff_id=" . $model->staff_id;
                    return Html::a('<span class="glyphicon glyphicon-list"></span>', $url, ['title' => '已选服务列表', 'target' => '_blank']);
                },
                'res-list' => function ($url, $model) {
                    $url = "/yx-staff-res/index?staff_id=" . $model->staff_id;
                    return Html::a('<span class="glyphicon glyphicon-th-large"></span>', $url, ['title' => '员工成果列表', 'target' => '_blank']);
                },
                'comment-list' => function ($url, $model) {
                    $url = "/yx-comment/index?staff_id=" . $model->staff_id;
                    return Html::a('<span class="glyphicon glyphicon-star"></span>', $url, ['title' => '评论列表', 'target' => '_blank']);
                },
                'order-list' => function ($url, $model) {
                    $url = "/yx-order/index?staff_id=" . $model->staff_id;
                    return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, ['title' => '订单列表', 'target' => '_blank']);
                },
            ],
        ],
    ],
]);?>
</div>
