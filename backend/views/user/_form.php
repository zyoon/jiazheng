<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model, 'username')->textInput(['autofocus' => true]);?>

	<?=$form->field($model, 'email');?>

    <?=$form->field($model, 'password_see')->passwordInput();?>

    <div class="form-group">
        <?=Html::submitButton('保存', ['class' => 'btn btn-success']);?>
    </div>

    <?php ActiveForm::end();?>

</div>
