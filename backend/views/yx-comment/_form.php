<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'star')->textInput() ?>

    <?= $form->field($model, 'yx_company_id')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'yx_staff_id')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'yx_user_id')->textInput()->hiddenInput()->label(false) ?>

<!--     <?= $form->field($model, 'is_praise')->textInput() ?> -->

    <?= $form->field($model, 'yx_order_id')->textInput()->hiddenInput()->label(false)?>

<!--     <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
