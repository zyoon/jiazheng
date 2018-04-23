<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Region;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxUserAddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的收货地址';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.grid-view .summary{
  display: none;
}
</style>
<?php  $GLOBALS['order_id'] = $order_id ?>
<div class="yx-user-address-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建收货地址', ['create?order_id='.$order_id], ['class' => 'btn','style' => 'color:#40bbff;border-color:#40bbff']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showHeader' => false,
        'emptyText' => '还没有收货地址',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'province',
                'value' => function($model) {
                    return Region::getOneName($model->province);
                }
            ],
            [
                'attribute'=>'city',
                'value' => function($model) {
                    return Region::getOneName($model->city);
                }
            ],
            [
                'attribute'=>'district',
                'value' => function($model) {
                    return Region::getOneName($model->district);
                }
            ],
            'phone',
            'address',
            'consignee',

            [
                'attribute'=>'is_main',
                'value' => function($model) {
                    return $model::getIsMain()[$model->is_main];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{update} {delete} {setmain}',
                'buttons'=>[
                    'setmain' => function ($url, $model, $key){
                        return $model->is_main == 2 ? Html::a('<span style="font-weight: bold;">设为默认地址</span>',
                            ['setmain?id='.$key.'&order_id='.$GLOBALS['order_id']],
                            ['title' => '设为默认地址', 'data' => ['method' => 'post'], 'class'=> 'shelf']) : '';
                    }
                ]
            ],
        ],
    ]); ?>
</div>
<script>
</script>
