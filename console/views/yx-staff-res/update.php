<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaffRes */

$this->title = $model->staff_res_id;
$this->params['breadcrumbs'][] = ['label' => '员工成果列表', 'url' => ['index?staff_id='.$model->staff_id]];
$this->params['breadcrumbs'][] = ['label' => $model->staff_res_id, 'url' => ['view', 'id' => $model->staff_res_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="yx-staff-res-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
