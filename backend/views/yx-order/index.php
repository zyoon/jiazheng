<?php

use common\models\YxCompany;
use common\models\YxOrder;
use common\models\YxStaff;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '订单列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-order-index">

    <h1><?=Html::encode($this->title);?></h1>
    <?php

// echo $this->render('_search', ['model' => $searchModel]); ;;;;;;;?>


    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        'order_no',
        // 'address',
        // 'phone',

        //'order_state',
        //'order_memo',
        [
            'label' => '员工编号',
            'attribute' => 'staff_number',
            'value' => function ($model) {
                return (YxStaff::findOne($model->yx_staff_id))['staff_number'];
            },
        ],
        [
            'label' => '公司编号',
            'attribute' => 'cmp_number',
            'value' => function ($model) {
                return (YxCompany::findOne($model->yx_company_id))['number'];
            },
        ],
        [
            'attribute' => 'order_state',
            'filter' => YxOrder::getOrderState(),
            'value' => function ($model) {
                return YxOrder::getName($model->order_state, 'getOrderState');
            },
        ],
        [
            'attribute' => 'order_type',
            'filter' => YxOrder::getOrderType(),
            'value' => function ($model) {
                return YxOrder::getName($model->order_type, 'getOrderType');
            },
        ],
        // 'yx_user_id',
        //'user_name',
        //'created_at',
        //'updated_at',
        //'is_delete',
        [
            'attribute' => 'time_start',
            'filter' => Html::input('date', 'YxOrderSearch[time_start]', $searchModel['time_start'], ['class' => 'form-control']),
            'value' => function ($model) {
                return date('Y-m-d', $model->time_start);
            },
        ],
        [
            'attribute' => 'time_end',
            'filter' => Html::input('date', 'YxOrderSearch[time_end]', $searchModel['time_end'], ['class' => 'form-control']),
            'value' => function ($model) {
                return date('Y-m-d', $model->time_end);
            },
        ],
        // 'order_server',
        // 'yx_staff_id',
        // 'yx_company_id',
        [
            'attribute' => 'order_money',
            'value' => function ($model) {
                $order_money = ($model->order_money) / 100;
                return $order_money;
            },
        ],
        ['class' => 'yii\grid\ActionColumn', 'header' => '操作', 'template' => '{view} {delete} {payment} {comment-list}', 'options' => ['style' => 'width: 100px;'],
            'buttons' => [
                'payment' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('app', 'Pay Ment'),
                        'aria-label' => Yii::t('app', 'Payment'),
                        'data-pjax' => '0',
                        'style' => 'padding:0 5px',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-shopping-cart"></span>', $url, $options);
                },
                'view' => function ($url, $model, $yx_user_id) {

                    $queryParams = Yii::$app->request->queryParams;
                    $uri='';
                    if (isset($queryParams['company_id'])) {
                        $uri = '&company_id=' . $queryParams['company_id'];
                    }
                    if (isset($queryParams['user_id'])) {
                        $uri = '&user_id=' . $queryParams['user_id'];
                    }
                    if (isset($queryParams['staff_id'])) {
                        $uri = '&staff_id=' . $queryParams['staff_id'];
                    }
                    $url = "/yx-order/view?id=" . $model->id . $uri ;

                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看']);
                },
                'delete' => function ($url, $model, $yx_user_id) {

                    $queryParams = Yii::$app->request->queryParams;
                    $uri='';
                    if (isset($queryParams['company_id'])) {
                        $uri = '&company_id=' . $queryParams['company_id'];
                    }
                    if (isset($queryParams['user_id'])) {
                        $uri = '&user_id=' . $queryParams['user_id'];
                    }
                    if (isset($queryParams['staff_id'])) {
                        $uri = '&staff_id=' . $queryParams['staff_id'];
                    }
                    $url = "/yx-order/delete?id=" . $model->id . $uri;
                    $options=[
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', '您确定要删除此项吗?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                },
                'comment-list' => function ($url, $model) {
                    $url = "/yx-comment/index?order_id=" . $model->id;
                    return Html::a('<span class="glyphicon glyphicon-star"></span>', $url, ['title' => '评论列表', 'target' => '_blank']);
                },
            ],
        ],
    ],
]);?>
</div>
