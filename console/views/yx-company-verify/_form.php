<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Region;
use common\models\YxCompany;
use common\models\YxCompanyVerify;
use zh\qiniu\QiniuFileInput;

$this->registerJsFile(Yii::$app->params['webuploader']['fromtEndDomain']."react/build/static/js/main.js");
$this->registerJs(
   '
    function onProvinceChange(value){
        PubSub.publish(\'city.onchange\', {name: value, level: \'province\'});
    }
    function onCityChange(value){
        PubSub.publish(\'city.onchange\', {name: value, level: \'city\'});
    }
    function onDistrictChange(value){
        PubSub.publish(\'city.onchange\', {name: value, level: \'district\'});
    }

    $(".yc-selected-province").change(function(){
        var province_ = $(this).find("option:selected").text();
        console.log(province_);
        onProvinceChange(province_);
    })
    $(".yc-selected-city").change(function(){
        var city_ = $(this).find("option:selected").text();
        console.log(city_);
        onCityChange(city_);
    })
    $(".yc-selected-district").change(function(){
        var district_ = $(this).find("option:selected").text();
        console.log(district_);
        onDistrictChange(district_);
    })

       PubSub.subscribe( \'positionPicker.ready\', function () {
            var longitude_ = Number($(\'#yxcompanyverify-longitude\').val());
            var latitude_ = Number($(\'#yxcompanyverify-latitude\').val());
           PubSub.publish( \'positionPicker.start\', {position:{N:longitude_,Q:latitude_, lng:longitude_ ,lat:latitude_}} );
             //position:{N:longitude_,Q:latitude_, lng:longitude_.toFixed(6) ,lat:latitude_.toFixed(6)}
       });
       PubSub.subscribe(\'positionPicker.result\', function (msg, result) {
          console.log(result);
          addressInput = $(\'#yxcompanyverify-address\');
          addressInput.val( result.regeocode.formattedAddress );
          $(\'#yxcompanyverify-latitude\').val(result.position.Q);
          $(\'#yxcompanyverify-longitude\').val(result.position.N);
        });
    '
);
$this->registerCssFile(Yii::$app->params['webuploader']['fromtEndDomain']."react/build/static/css/main.css");
$this->registerCss('
    .layout_row {
            display: flex;
        }

');
/* @var $this yii\web\View */
/* @var $model common\models\yxCompany */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-company-verify-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id')->textInput()->hiddenInput(['value'=>$model->id])->label(false); ?>
    <?= $form->field($model, 'company_id')->textInput()->hiddenInput(['value'=>$model->company_id])->label(false); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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
            'options'=>['class'=>'form-control form-control-inline yc-selected-district','prompt'=>'选择县/区']
        ]
    ]);
    ?>
    <div class="form-group field-yxcompanyverify-address" >
        <label class="control-label col-sm-1" for="orgnization-level">在地图上选择位置</label>
        <div id="react_root" class="col-sm-11"></div>
    </div>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charge_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charge_man')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operating_radius')->textInput() ?>

    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>

<!--     <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?> -->

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

<!--     <?php $status = yxCompany::getCmpStatus(); ?>
    <?= $form->field($model, 'status')->dropDownList($status) ?> -->

    <?= $form->field($model, 'business_licences')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>30720000,
        ],
    ]) ?>

    <?php $models = YxCompany::getCmpModels(); ?>
    <?= $form->field($model, 'models')->dropDownList($models) ?>

    <?= $form->field($model, 'introduction')->textarea(['rows' => 6]) ?>


   <?= $form->field($model, 'verify_memo')->textarea(['rows' => 6])->hiddenInput(['value'=>$model->verify_memo])->label(false); ?>

    
    <?php 
        $server_id = YxCompany::getCmpServer();
        $model->main_server_id = explode(',', $model->main_server_id);
    ?>
    <?= $form->field($model, 'main_server_id')->checkboxList($server_id);?>

    <?php 
        $server2_id = YxCompany::getCmpServer();
        if(!empty($arr_main_server_id)){
            foreach ($arr_main_server_id as $key => $value) {
                unset($server2_id[$key]);
            }  
        }
        $model->all_server_id = explode(',', $model->all_server_id);
    ?>
   <?= $form->field($model, 'all_server_id')->checkboxList($server2_id);?>

<!--    <?= $form->field($model, 'query')->textarea(['rows' => 6]) ?> -->
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
