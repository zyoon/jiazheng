<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\YxComment */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.field-yxcomment-yx_company_id, .field-yxcomment-yx_staff_id, .field-yxcomment-yx_order_id, .field-yxcomment-yx_user_id {
    display: none;
}
.yx-comment-form label{
    font-size: 16px;
}
.yx-comment-form .form-group {
    margin: 25px auto;
}
.yx-comment-form .score{
  margin-top: -20px;
}
.radio-inline{
    line-height: 22px;
}
.score .glyphicon{
    height: 40px;
    width: 40px;
    font-size: 26px;
    color: #FF9C05;
}
</style>
<div class="yx-comment-form" style="margin-top:40px;">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        $model->is_praise = 1; //默认好评
        $model->star = 3;
        $model->yx_company_id = $order->yx_company_id;
        $model->yx_staff_id = $order->yx_staff_id;
        $model->yx_order_id = $order->id;
        $model->yx_user_id = $order->yx_user_id;

     ?>
    <?= $form->field($model, 'is_praise')->textInput()->radioList(['1' => '好评', '0' => '差评'], ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>

    <?= $form->field($model, 'star')->textInput(['value'=>5])->hiddenInput() ?>
    <ul class="score">
        <li data-rh-score="3">
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
        </li>
    </ul>
    <?= $form->field($model, 'content')->textarea(['maxlength' => true,'style'=>'width:600px;height:200px;resize: none;']) ?>

    <?= $form->field($model, 'yx_company_id')->textInput()->hiddenInput() ?>
    <?= $form->field($model, 'yx_staff_id')->textInput()->hiddenInput() ?>
    <?= $form->field($model, 'yx_order_id')->textInput()->hiddenInput() ?>
    <?= $form->field($model, 'yx_user_id')->textInput()->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton('提交评价', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
window.onload = function(){
    var tip=[1,2,3,4,5];
    $('.score').on('mousedown','.glyphicon',function(){
            var score = $(this).index();
            $(".glyphicon").removeClass('glyphicon-star').addClass('glyphicon-star-empty')
            $(this).parent().attr('data-rh-score' ,score);
            $(this).addClass('glyphicon-star').removeClass('glyphicon-star-empty').prevAll('.glyphicon').addClass('glyphicon-star').removeClass('glyphicon-star-empty');
            console.log(tip[score]);
            $("#yxcomment-star").val(tip[score]);
    });
}

</script>
