<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Region;
/* @var $this yii\web\View */
/* @var $model common\models\YxUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'province')->widget(\chenkby\region\Region::className(),[
        'model'=>$model,
        'url'=> \yii\helpers\Url::toRoute(['get-region']),
        'province'=>[
            'attribute'=>'province',
            'items'=>Region::getRegion(),
            'options'=>['class'=>'form-control form-control-inline yc-selected-province','prompt'=>'选择省份']
        ],
        'city'=>[
            'attribute'=>'city',
            'items'=>Region::getRegion($model['province']),
            'options'=>['class'=>'form-control form-control-inline yc-selected-city','prompt'=>'选择城市']
        ],
        'district'=>[
            'attribute'=>'district',
            'items'=>Region::getRegion($model['city']),
            'options'=>['class'=>'form-control form-control-inline yc-selected-district','prompt'=>'选择县/区','style'=>'display:none']
        ]
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
