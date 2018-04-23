<?php

use common\models\Region;
use common\models\YxUser;
use common\models\YxUserAddress;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\YxUserAddress */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '地址列表', 'url' => ['index?yx_user_id=' . $model->yx_user_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-user-address-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
<!--         <?=Html::a('修改', ['update', 'id' => $model->id, 'address' => $model->address], ['class' => 'btn btn-primary']);?> -->
<!--         <?=Html::a('删除', ['delete', 'id' => $model->id, 'address' => $model->address], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => '您确定删除此项吗?',
        'method' => 'post',
    ],
]);?> -->
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        // 'yx_user_id',
        [
            'attribute' => 'yx_username',
            'value' => function ($model) {
                $model = YxUser::findOne($model->yx_user_id);
                return $model['username'];
            },
        ],
        [
            'attribute' => 'yx_nickname',
            'value' => function ($model) {
                $model = YxUser::findOne($model->yx_user_id);
                return $model['nickname'];
            },
        ],
        [
            'attribute' => 'province',
            'value' => function ($model) {
                return Region::getOneName($model->province);
            },
        ],
        [
            'attribute' => 'city',
            'value' => function ($model) {
                return Region::getOneName($model->city);
            },
        ],
        [
            'attribute' => 'district',
            'value' => function ($model) {
                return Region::getOneName($model->district);
            },
        ],
        'phone',
        'address',
        'consignee',
        // 'is_delete',
        [
            'attribute' => 'is_main',
            'value' => function ($model) {
                return YxUserAddress::getName($model->is_main, 'getIsMain');
            },
        ],
    ],
]);?>

</div>
