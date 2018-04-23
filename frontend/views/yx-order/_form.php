<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_money')->textInput() ?>

    <?= $form->field($model, 'order_state')->textInput() ?>

    <?= $form->field($model, 'order_memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yx_user_id')->textInput() ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
