<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaffSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-staff-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'staff_id') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'staff_name') ?>

    <?= $form->field($model, 'staff_sex') ?>

    <?= $form->field($model, 'staff_age') ?>

    <?php // echo $form->field($model, 'staff_img') ?>

    <?php // echo $form->field($model, 'staff_idcard') ?>

    <?php // echo $form->field($model, 'staff_intro') ?>

    <?php // echo $form->field($model, 'staff_found') ?>

    <?php // echo $form->field($model, 'staff_main_server') ?>

    <?php // echo $form->field($model, 'staff_all_server') ?>

    <?php // echo $form->field($model, 'staff_state') ?>

    <?php // echo $form->field($model, 'staff_memo') ?>

    <?php // echo $form->field($model, 'staff_login_ip') ?>

    <?php // echo $form->field($model, 'staff_login_time') ?>

    <?php // echo $form->field($model, 'staff_account') ?>

    <?php // echo $form->field($model, 'staff_password') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
