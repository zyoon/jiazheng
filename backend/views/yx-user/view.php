<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\YxUser;
use common\models\Region;
/* @var $this yii\web\View */
/* @var $model common\models\YxUser */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<!--         <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除此项吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('Y-m-d', $model->created_at);
            },
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return date('Y-m-d', $model->updated_at);
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
            'attribute' => 'img',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->img;
            },
        ],
        [
            'attribute' => 'sex',
            'value' => function ($model) {
                return YxUser::getName($model->sex,'getUserSex');
            },
        ],
        [   
            'label'=>'出生日期',
            'attribute' => 'birthday',
            'format'=>['date', 'Y-m-d']
        ],
            'phone',
            'address',
            'nickname',
        ],
    ]) ?>

</div>
