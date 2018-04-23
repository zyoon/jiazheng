<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?php echo '/css/site.css' ?>">
<style>
.control-label{
  display: block;
  margin-bottom: 0px;
}
.form-group {
    margin-bottom: 0px;
    height: 48px;
    margin-top: 0px;
}
.help-block{
  margin-top:0px;
  margin-bottom: 0px;
}
.field-userloginform-rememberme{
  float: left;
  margin-left: 62px;
  margin-top: -10px;
}
</style>
<div class="max_login">
    <div class="min_login">
        <div class="login_T">
          <span>
                <h2>登录</h2>
          </span>
        </div>
        <div class="login_C">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <span style="position: relative;"><?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?></span>

                <span style="position: relative;"><?= $form->field($model, 'password')->passwordInput() ?></span>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('记住账号') ?>

                <div style="color:#999;margin:0px;float: right;margin-right: 64px;">
                    <?= Html::a('忘记密码', ['site/request-password-reset']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'loginSubmit', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
window.onload = function(){
  $(".field-userloginform-username").find(".control-label").html('<em><img src="http://p6htqszz4.bkt.clouddn.com/login_name.png"></em>')
  $(".field-userloginform-password").find(".control-label").html('<em><img src="http://p6htqszz4.bkt.clouddn.com/login_password.png"></em>')
}

</script>
