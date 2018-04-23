<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Region;
use zh\qiniu\QiniuFileInput;
use common\models\YxStaff;
$this->registerJsFile(Yii::$app->params['webuploader']['fileDomain']."react/build/static/js/main.js");
$this->registerJs(
   '
    function onProvinceChange(value){
        PubSub.publish(\'city.onchange\', {name: value, level: \'province\'});
    }
    function onCityChange(value){
        PubSub.publish(\'city.onchange\', {name: value, level: \'city\'});
    }
    function onDistrictChange(value){
        value="南山区";
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
            var longitude_ = Number($(\'#yxcompany-longitude\').val());
            var latitude_ = Number($(\'#yxcompany-latitude\').val());
           PubSub.publish( \'positionPicker.start\', {position:{N:longitude_,Q:latitude_, lng:longitude_ ,lat:latitude_}} );
             //position:{N:longitude_,Q:latitude_, lng:longitude_.toFixed(6) ,lat:latitude_.toFixed(6)}
       });
       PubSub.subscribe(\'positionPicker.result\', function (msg, result) {
          console.log(result);
          addressInput = $(\'#yxcompany-address\');
          addressInput.val( result.regeocode.formattedAddress );
          $(\'#yxcompany-latitude\').val(result.position.Q);
          $(\'#yxcompany-longitude\').val(result.position.N);
        });
    '
);
$this->registerCssFile(Yii::$app->params['webuploader']['fileDomain']."react/build/static/css/main.css");
$this->registerCss('
    .layout_row {
            display: flex;
        }

');
/* @var $this yii\web\View */
/* @var $model common\models\yxCompany */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yx-company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'image')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>30720000,
        ],
    ]) ?>
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
    <div class="form-group field-yxcompany-address" >
        <label class="control-label col-sm-1" for="orgnization-level">在地图上选择位置</label>
        <div id="react_root" class="col-sm-11"></div>
    </div>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charge_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'charge_man')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operating_radius')->textInput() ?>

    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
    <?php $model->status = $model->getCmpStatus(); ?>
    <?= $form->field($model, 'status')->dropDownList($model->status) ?>

    <?= $form->field($model, 'business_licences')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>30720000,
        ],
    ]) ?>

    <?= $form->field($model, 'introduction')->textarea(['rows' => 6]) ?>

    <?php $model->models = $model->getCmpModels(); ?>
    <?= $form->field($model, 'models')->dropDownList($model->models) ?>

    <?php 
        $server_id = $model->getCmpServer();
        $model->main_server_id = explode(',', $model->main_server_id);
    ?>
    <?= $form->field($model, 'main_server_id')->checkboxList($server_id);?>

    <?php 
        $server2_id = $model->getCmpServer();
        if(!empty($arr_main_server_id)){
            foreach ($arr_main_server_id as $key => $value) {
                unset($server2_id[$key]);
            }  
        }
        $model->all_server_id = explode(',', $model->all_server_id);
    ?>
   <?= $form->field($model, 'all_server_id')->checkboxList($server2_id);?>

   <?php $manage_time = YxStaff::getStaffTime(); ?>
   <?= $form->field($model, 'manage_time')->dropDownList($manage_time) ;?>

    <?= $form->field($model, 'banck_card')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'alipay')->textInput(['maxlength' => true]) ?>

 <?= $form->field($model, 'business_code')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script>
      window.changeImgUrl = changeImgUrl;
      function changeImgUrl(fileDom){
        console.log(fileDom)
      }
    </script>
</div>
