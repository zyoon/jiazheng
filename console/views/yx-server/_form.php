<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxServer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-server-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'server_name')->textInput(['maxlength' => true]) ?>

<!--     <?= $form->field($model, 'server_type')->textInput() ?> -->
    
    <?php $parent_list = $model->getCmpParent(); ?>
    <?= $form->field($model, 'server_parent')->dropDownList($parent_list) ?>
    
    <?php $state_list = $model->getCmpState(); ?>
    <?= $form->field($model, 'server_state')->dropDownList($state_list) ?>

    <?= $form->field($model, 'server_memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'server_unit')->textInput(['maxlength' => true]) ?> 
    
    <?= $form->field($model, 'server_sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
