<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaffRes */

$this->title = $model->staff_res_id;
$this->params['breadcrumbs'][] = ['label' => '员工成果列表', 'url' => ['index?staff_id='.$model->staff_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-res-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->staff_res_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->staff_res_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定删除此项吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'staff_res_id',
            'staff_id',
            [
                'attribute'=>'staff_res_img',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->staff_res_img;
                }
            ],
        ],
    ]) ?>

</div>
