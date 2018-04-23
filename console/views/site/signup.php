<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\models\YxRules;

?>
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
.field-cmploginform-rememberme{
  float: left;
  margin-left: 62px;
  margin-top: -10px;
}
</style>

<div class="max_sgin">
    <div class="min_sgin">
        <div class="sgin_T">
            <span>
            <em>原象屋商家注册</em>
            </span>
        </div>
        <div class="sgin_C">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']);?>

                <span style="position: relative;"><?=$form->field($model, 'username')->textInput(['autofocus' => true]);?></span>

                <span style="position: relative;"><?=$form->field($model, 'email');?></span>

                <span style="position: relative;"><?=$form->field($model, 'password')->passwordInput();?></span>
                  <?= Html::checkbox('agree', false, ['label' => '同意','style'=>"margin-left:80px"]);?>
                  <?=Html::a('入驻协议', '#', [
                      'id' => 'deny',
                      'data-toggle' => 'modal',
                      'data-target' => '#deny-modal',
                  ]);?>
                <div class="form-group">
                    <?=Html::Button('注册', ['class' => 'btn btn-primary sginSubmit', 'name' => 'signup-button']);?>
                </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
<script>
$(".field-signupform-username ").find(".control-label").html('<em><img src="http://p6htqszz4.bkt.clouddn.com/login_name.png"></em>')
$(".field-signupform-email ").find(".control-label").html('<em><img src="http://p6htqszz4.bkt.clouddn.com/login_phone.png"></em>')
$(".field-signupform-password").find(".control-label").html('<em><img src="http://p6htqszz4.bkt.clouddn.com/login_password.png"></em>')
$("button[name='signup-button']").click(function(){
    $("input[name='agree']").prop('checked')
    if(!$("input[name='agree']").prop('checked')){
      alert('请先阅读并同意入驻协议');
      return;
    }
    $("#form-signup").submit();
})
</script>
<?php

Modal::begin([
    'id' => 'deny-modal',
    'header' => '<h4 class="modal-title">入驻协议</h4>',
]);
$verify=Yii::$app->request->csrfToken;
$content=(YxRules::find()->where(['rules_title'=>'原象屋平台商家入驻协议'])->one())['rules_content'];
// $content=str_replace(" ","",$content);
$js = <<<JS
    var data='{$content}';
    $('.modal-body').html(data);
JS;
$this->registerJs($js);
Modal::end();
?>
