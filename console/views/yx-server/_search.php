<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxServerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-server-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'server_id') ?>

    <?= $form->field($model, 'server_name') ?>

    <?= $form->field($model, 'server_type') ?>

    <?= $form->field($model, 'server_parent') ?>

    <?= $form->field($model, 'server_state') ?>

    <?php // echo $form->field($model, 'server_memo') ?>

    <?php // echo $form->field($model, 'server_sort') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
