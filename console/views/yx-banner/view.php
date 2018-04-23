<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\YxBanner */

$this->title = $model->banner_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '轮播图列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-banner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->banner_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->banner_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '您确定删除此项吗?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'banner_id',
            [
                'attribute'=>'banner_pic',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->banner_pic;
                }
            ],
            'banner_href',
        ],
    ]) ?>

</div>
