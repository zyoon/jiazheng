<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaffVerify */

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->staff_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工审核列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->staff_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-staff-verify-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model2'=>$model2,
    ]) ?>

</div>
