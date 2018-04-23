<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxCmpServerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-cmp-server-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'server_id') ?>

    <?= $form->field($model, 'server_least') ?>

    <?= $form->field($model, 'server_price') ?>

    <?= $form->field($model, 'server_parent_id') ?>

    <?php // echo $form->field($model, 'server_name') ?>

    <?php // echo $form->field($model, 'server_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
