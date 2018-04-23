<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '重置密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请输入注册时填写的手机号.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('手机号') ?>
                <button type="button" id="passwordresetrequestform-getcode" class="btn btn-primary btn-lg active">获取验证码</button>
                <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    window.onload =function(){
      $("#passwordresetrequestform-getcode").click(function(){
        var phoneNum = $("#passwordresetrequestform-email").val();
        if(phoneNum.length != 11){
          alert("请输入正确的11位手机号码");
          return;
        };
        var buttonDom = this;
        $.ajax({
            type  : "POST",
            url   : "/site/getresetpwdcode",
            dataType:"json",
            data:{"email":phoneNum},
           success:function(json) {
                console.log(json);
                if(json.code == 0){
                    $(buttonDom).attr("disabled","disabled");
                }else {
                    $(".field-passwordresetrequestform-email").attr("class","form-group field-passwordresetrequestform-email required has-error");
                    $(".field-passwordresetrequestform-email .help-block-error").html(json.msg);
                }
            }
        });

      })
    }
</script>