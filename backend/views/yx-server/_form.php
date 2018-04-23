<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use zh\qiniu\QiniuFileInput;
/* @var $this yii\web\View */
/* @var $model common\models\YxServer */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="yx-server-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'server_name')->textInput(['maxlength' => true]) ?>

    <?php $server_type = $model->getCmpType(); ?>
    <?= $form->field($model, 'server_type')->dropDownList($server_type, [
        'onchange' => 'serverType()',
    ])->label('分类级别');?> 
    
    <?php $parent_list = $model->getLvServer(1,0); ?>
    <?= $form->field($model, 'one_server')->dropDownList($parent_list, [
        'onchange' => '$.post("/yx-server/serverlink?server_id='. '"+$(this).val(),function(data){
            $("select#yxserver-server_parent").html(data);
        });',
    ]);?>

    <?php
        $parent_list = $model->getLvServer(2,$model->one_server); 
    ?>
    <?= $form->field($model, 'server_parent')->dropDownList($parent_list)->label('二级分类') ?>
    
    <?php $state_list = $model->getCmpState(); ?>
    <?= $form->field($model, 'server_state')->dropDownList($state_list) ?>

    <?= $form->field($model, 'server_memo')->textInput(['maxlength' => true]) ?>
    <?= Html::label('是否为时间单位',['class' => 'label is_time']) ?>
</br>
    <?= Html::radio('is_time', true, ['label' => '是','value'=>1]); ?>
    <?= Html::radio('is_time', false, ['label' => '否','value'=>0]); ?>
    <?= $form->field($model, 'server_unit')->textInput(['maxlength' => true,'value'=>'小时','readonly'=>true]) ?> 
    
    <?= $form->field($model, 'server_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'server_pic')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>10240000,
        ],
    ]) ?>
 
    <?php $mans = $model->getMans(); ?>
   <?= $form->field($model, 'server_mans')->dropDownList($mans) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script >
    
    
    var serverType = function(){
            var server_type=$("#yxserver-server_type").val();
            if(server_type==1){
                $(".field-yxserver-one_server").hide();
                $(".field-yxserver-server_parent").hide();
            }
            if(server_type==2){
                $(".field-yxserver-one_server").show();
                $(".field-yxserver-server_parent").hide();
            }
            if(server_type==3){
                $(".field-yxserver-one_server").show();
                $(".field-yxserver-server_parent").show();
            }
    }
    $("input[name='is_time']").change(function() { 
        if($(this).val()==1){
            $("#yxserver-server_unit").attr('readonly',true)
            $("#yxserver-server_unit").val('小时')
        }else{
            $("#yxserver-server_unit").attr('readonly',false)
        }
});
    window.onload=serverType();
</script>