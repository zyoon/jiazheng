<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TestH */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Hs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-h-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
	    [
   	   	'attribute'=>'img_url',
   	   	'format' => ['image',['width'=>'60','height'=>'60',]],
   	   	'value' => function($model){
   	       		return $model->img_url;
   	   	}
	    ],
        ],
    ]) ?>

</div>
