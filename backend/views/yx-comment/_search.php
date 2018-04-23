<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'star') ?>

    <?= $form->field($model, 'yx_company_id') ?>

    <?= $form->field($model, 'yx_staff_id') ?>

    <?php // echo $form->field($model, 'yx_user_id') ?>

    <?php // echo $form->field($model, 'is_praise') ?>

    <?php // echo $form->field($model, 'yx_order_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
