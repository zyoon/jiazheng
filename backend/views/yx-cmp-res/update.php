<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxCmpRes */

$this->title = $model->cmp_res_id;
$this->params['breadcrumbs'][] = ['label' => '公司成果列表', 'url' => ['index?company_id='.$model->company_id]];
$this->params['breadcrumbs'][] = ['label' => $model->cmp_res_id, 'url' => ['view', 'id' => $model->cmp_res_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="yx-cmp-res-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
