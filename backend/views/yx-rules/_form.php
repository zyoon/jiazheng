<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use common\models\YxRules;
/* @var $this yii\web\View */
/* @var $model common\models\YxRules */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<div class="yx-rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rules_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rules_content')->widget(Redactor::className(), [ 
    'clientOptions' => [ 
        'lang' => 'zh_cn',
        'plugins' => ['fontcolor','table','fontsize'],
    ] 
]); ?>

    <?php $rules_type = $model->getRulesTypeMap(); ?>
    <?= $form->field($model, 'rules_type')->dropDownList($rules_type) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
