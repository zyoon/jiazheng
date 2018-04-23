<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\YxServer;

/* @var $this yii\web\View */
/* @var $model common\models\YxCmpServer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-cmp-server-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $server_parent = YxServer::getAllLvServer(1);?>
   <?=$form->field($model, 'server_parent_id')->dropDownList($server_parent, [
        'onchange' => '$.post("/yx-cmp-server/serverlink?server_id='. '"+$(this).val(),function(data){
            $("select#yxcmpserver-server_id").html(data);
        });',
    ]);?>

    <?php
        foreach ($server_parent as $key => $value) {
            $model->server_parent_id=$key;
            break;
        }
    ?>
    
    <?php $server_child = YxServer::getLvServer(2,$model->server_parent_id);?>
    <?=$form->field($model, 'server_id')->dropDownList($server_child);?>

    <?= $form->field($model, 'server_least')->textInput(['value'=>0]) ?>

    <?= $form->field($model, 'server_price')->textInput(['value'=>0]) ?>





    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
