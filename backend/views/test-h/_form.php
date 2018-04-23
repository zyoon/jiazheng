<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use zh\qiniu\QiniuFileInput;
/* @var $this yii\web\View */
/* @var $model common\models\TestH */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-h-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_url')->widget(QiniuFileInput::className(),[
        //'options' => [
        //   'class' => 'btn-danger'//按钮class
        //],
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
	      'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            //'size' => 204800,//每张图片大小
            //'btnName' => 'upload',//上传按钮名字
            'accept' => 'image/jpeg,image/png'//上传允许类型
        ],
        //'pluginEvents' => [
        //    'delete' => 'function(item){console.log(item)}',
        //    'success' => 'function(res){console.log(res)}'
        //]
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <button class="new-btn-login" style="text-align:center;" id="payBtn">付 款</button>
    <?php ActiveForm::end(); ?>

</div>
