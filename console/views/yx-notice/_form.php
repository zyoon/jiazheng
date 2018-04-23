<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxNotice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-notice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'notice_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notice_content')->textarea(['rows' => 6]) ?>

	<?php $notice_state = $model->getState(); ?>
    <?= $form->field($model, 'notice_state')->dropDownList($notice_state) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
