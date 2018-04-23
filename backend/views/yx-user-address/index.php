<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\YxUserAddressSearch;
use common\models\YxUser;
use common\models\Region;
use common\models\YxUserAddress;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxUserAddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '地址列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-user-address-index">

    <h1><?=Html::encode($this->title);?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ;?>

<!--     <p>
        <?=Html::a('Create Yx User Address', ['create'], ['class' => 'btn btn-success']);?>
    </p> -->

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        // [
        //     'attribute' => 'province',
        //     'value' => function ($model) {
        //         return Region::getOneName($model->province);
        //     },
        // ],
        // [
        //     'attribute' => 'city',
        //     'value' => function ($model) {
        //         return Region::getOneName($model->city);
        //     },
        // ],
        // [
        //     'attribute' => 'district',
        //     'value' => function ($model) {
        //         return Region::getOneName($model->district);
        //     },
        // ],
        'phone',
        'address',
        'consignee',
        //'is_delete',
        [
            'attribute' => 'is_main',
            'value' => function ($model) {
                return YxUserAddress::getName($model->is_main, 'getIsMain');
            },
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{view} {delete}',
        ],
    ],
]);?>
</div>
