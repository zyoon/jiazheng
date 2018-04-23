<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\YxUser;
use common\models\YxUserSearch;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-user-index">

    <h1><?=Html::encode($this->title);?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ;?>

<!--     <p>
        <?=Html::a('新增', ['create'], ['class' => 'btn btn-success']);?>
    </p> -->

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        'username',
        'nickname',
        // 'auth_key',
        // 'password_hash',
        // 'password_reset_token',
        //'email:email',
        //'role',
        //'status',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('Y-m-d', $model->created_at);
            },
        ],
        // [
        //     'attribute' => 'updated_at',
        //     'value' => function ($model) {
        //         return date('Y-m-d', $model->updated_at);
        //     },
        // ],
        // 'province',
        // 'city',
        // [
        //     'attribute' => 'img',
        //     'format' => ['image', ['width' => '200', 'height' => '200']],
        //     'value' => function ($model) {
        //         return $model->img;
        //     },
        // ],
        [
            'attribute' => 'sex',
            'filter'=>YxUser::getUserSex(),
            'value' => function ($model) {
                return YxUser::getName($model->sex,'getUserSex');
            },
        ],
        'phone',
        'address',

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{view} {delete} {order-list} {address-list}',
            'buttons' => [
                'order-list' => function ($url, $model) {
                    $url = "/yx-order/index?user_id=" . $model->id;
                    return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, ['title' => '订单列表', 'target' => '_blank']);
                },
                'address-list' => function ($url, $model) {
                    $url = "/yx-user-address/index?yx_user_id=" . $model->id;
                    return Html::a('<span class="glyphicon glyphicon-gift"></span>', $url, ['title' => '收货地址', 'target' => '_blank']);
                },
            ],
        ],
    ],
]);?>
</div>
