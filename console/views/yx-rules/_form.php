<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxRules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rules_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rules_content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
