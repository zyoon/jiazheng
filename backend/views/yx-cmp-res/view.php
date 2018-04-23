<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\YxCmpRes */

$this->title = $model->cmp_res_id;
$this->params['breadcrumbs'][] = ['label' => '公司成果列表', 'url' => ['index?company_id='.$model->company_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-cmp-res-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->cmp_res_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->cmp_res_id], [
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
            'cmp_res_id',
            // 'company_id',
            [
                'attribute'=>'cmp_res_img',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->cmp_res_img;
                }
            ],
        ],
    ]) ?>

</div>
