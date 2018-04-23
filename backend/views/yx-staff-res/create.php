<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxStaffRes */

$this->title = '新增';
$this->params['breadcrumbs'][] = ['label' => '员工成果列表', 'url' => ['index?staff_id='.$model->staff_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-res-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
