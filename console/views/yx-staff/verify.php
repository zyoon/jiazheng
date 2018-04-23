<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaff */

$this->title = Yii::t('app', '审核: {nameAttribute}', [
    'nameAttribute' => $model->staff_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->staff_name, 'url' => ['view', 'id' => $model->staff_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '审核');
?>
<div class="yx-staff-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
