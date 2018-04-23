<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '请填写注册信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true,'maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'repassword')->passwordInput() ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                <button type="button" id="signupform-getcode" class="btn btn-primary btn-lg active">获取验证码</button>
                <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'nickname') ?>

                <?php $model->sex = $model->getUserSex(); ?>
                <?= $form->field($model, 'sex')->dropDownList($model->sex) ?>

                <?= $form->field($model, 'age') ?>

                <div class="form-group">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    window.onload =function(){
      $("#signupform-getcode").click(function(){
        var phoneNum = $("#signupform-phone").val();
        if(phoneNum.length != 11){
          alert("请输入正确的11位手机号码");
          return;
        };
        var buttonDom = this;
        $.ajax({
            type  : "POST",
            url   : "/site/getsignupcode",
            dataType:"json",
            data:{"phone":phoneNum},
           success:function(json) {
                //alert("success");
                console.log(json);
                if(json.code == 0){
                    $(buttonDom).attr("disabled","disabled");
                }else {
                    $(".field-signupform-phone").attr("class","form-group field-signupform-phone required has-error");
                    $(".field-signupform-phone .help-block-error").html(json.msg);
                }
            }
        });

      })
    }
</script>
