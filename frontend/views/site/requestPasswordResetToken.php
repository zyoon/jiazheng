<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '密码重置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请输入您的注册手机号码</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>
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
        var phoneNum = $("#passwordresetrequestform-phone").val();
        if(phoneNum.length != 11){
          alert("请输入正确的11位手机号码");
          return;
        };
        var buttonDom = this;
        $.ajax({
            type  : "POST",
            url   : "/site/getresetpwdcode",
            dataType:"json",
            data:{"phone":phoneNum},
           success:function(json) {
                //alert("success");
                console.log(json);
                if(json.code == 0){
                    $(buttonDom).attr("disabled","disabled");
                }else {
                    $(".field-passwordresetrequestform-phone").attr("class","form-group field-passwordresetrequestform-phone required has-error");
                    $(".field-passwordresetrequestform-phone .help-block-error").html(json.msg);
                }
            }
        });

      })
    }
</script>
