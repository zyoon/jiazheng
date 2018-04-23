<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Region;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HmCompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公司列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加公司', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'number',
            'name',

           //         'image',
           // 'total_fraction',
            [
                'attribute'=>'provinceName',
                'value' => function($model) {
                    return Region::getOneName($model->province);
                }
            ],
            [
                'attribute'=>'cityName',
                'value' => function($model) {
                    return Region::getOneName($model->city);
                }
            ],
            [
                'attribute'=>'districtName',
                'value' => function($model) {
                    return Region::getOneName($model->district);
                }
            ],
            //'address',
            //'telephone',
            //'charge_phone',
            //'charge_man',
            //'longitude',
            //'latitude',
            //'operating_radius',
            //'wechat',
            //'created_at',
            //'updated_at',
            //'number',
            [
              'attribute'=>'status',
              'filter'=>common\models\YxCompany::getCmpStatus(),
              'value' => function($model) {
                  return common\models\YxCompany::getCmpStatusName($model->status);
              }
            ],
           //  [
           //     'attribute'=>'business_licences',
           //     'format' => ['image',['width'=>'30','height'=>'30',]],
           //     'value' => function($model){
           //             return $model->business_licences;
           //     }
           // ],
            //'models',
            //'introduction:ntext',
            //'main_server_id', 
           //'all_server_id', 
           //'query:ntext',
            //'base_fraction',
           //'history_fraction',
           //'clinch',
           //'price',
           //'manage_time',
           //'banck_card',
           //'alipay',
          //'business_code',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作', 
                'template' => '{view} {update} {delete} {waiter-list} {res-list} {server-list} {comment-list} {order-list}',
                'buttons'=>[
                    'waiter-list'=>function($url,$model){
                        $url="/yx-staff/index?company_id=".$model->id;
                        return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, ['title' => '服务者列表', 'target' => '_blank']);
                    },
                    'res-list'=> function ($url, $model) {
                        $url = "/yx-cmp-res/index?company_id=" . $model->id;
                        return Html::a('<span class="glyphicon glyphicon-th-large"></span>', $url, ['title' => '公司成果列表', 'target' => '_blank']);
                    },
                    'server-list'=> function ($url, $model) {
                        $url = "/yx-cmp-server/index?company_id=" . $model->id;
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', $url, ['title' => '服务列表', 'target' => '_blank']);
                    },
                    'comment-list'=> function ($url, $model) {
                        $url = "/yx-comment/index?company_id=" . $model->id;
                        return Html::a('<span class="glyphicon glyphicon-star"></span>', $url, ['title' => '评论列表', 'target' => '_blank']);
                    },
                    'order-list'=> function ($url, $model) {
                        $url = "/yx-order/index?company_id=" . $model->id;
                        return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, ['title' => '订单列表', 'target' => '_blank']);
                    },
                ]
            ],
        ],
    ]); ?>
</div>
