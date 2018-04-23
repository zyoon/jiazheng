<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use zh\qiniu\QiniuFileInput;
use common\models\YxServer;
use common\models\YxStaff;
use common\models\Region;
/* @var $this yii\web\View */
/* @var $model common\models\YxStaff */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(
   '
    $(".yc-selected-staff_province").attr("disabled",true)
    $(".yc-selected-staff_city").attr("disabled",true)
    $(".yc-selected-staff_district").attr("disabled",true)
    function onProvinceChange(value){
        $("#yxstaff-staff_address").val(value);

        $("#yxstaffverify-staff_address").val(value);
    }
    function onCityChange(value){
        var address_value=$("#yxstaff-staff_address").val();
        $("#yxstaff-staff_address").val(address_value+value);

        var address_value=$("#yxstaffverify-staff_address").val();
        $("#yxstaffverify-staff_address").val(address_value+value);
    }

    function onDistrictChange(value){
        var address_value=$("#yxstaff-staff_address").val();
        $("#yxstaff-staff_address").val(address_value+value);

        var address_value=$("#yxstaffverify-staff_address").val();
        $("#yxstaffverify-staff_address").val(address_value+value);
    }

    $(".yc-selected-staff_province").change(function(){
        var province_ = $(this).find("option:selected").text();
        
        console.log("1"+province_);
        onProvinceChange(province_);
    })
    $(".yc-selected-staff_city").change(function(){
        var city_ = $(this).find("option:selected").text();
        console.log("2"+city_);
        onCityChange(city_);
    })
    $(".yc-selected-staff_district").change(function(){
        var district_ = $(this).find("option:selected").text();
        console.log("3"+district_);
        onDistrictChange(district_);
    })

    '
);

?>

<div class="yx-staff-form">

    <?php $form = ActiveForm::begin(); ?>

<!--     <?= $form->field($model, 'company_id')->textInput() ?> -->

    <?= $form->field($model, 'staff_name')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?php $model->staff_sex = YxStaff::getCmpSex(); ?>
    <?= $form->field($model, 'staff_sex')->dropDownList($model->staff_sex,['disabled'=>'disabled']) ?>

    <?= $form->field($model, 'staff_age')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'staff_img')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>102400,
        ],

    ]) ?>

    <?= $form->field($model, 'staff_idcard')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'staff_intro')->textInput(['maxlength' => true,'readonly'=>true]) ?>

<!--     <?= $form->field($model, 'staff_found')->textInput(['maxlength' => true]) ?> -->

    <?php $staff_state = YxStaff::getCmpState(); 
        unset($staff_state['0']);
    ?>
    <?= $form->field($model, 'staff_state')->dropDownList($staff_state) ?>

    <?= $form->field($model, 'staff_memo')->textInput(['maxlength' => true,'readonly'=>true]) ?>

<!--     <?= $form->field($model, 'staff_login_ip')->textInput(['maxlength' => true]) ?> -->

<!--     <?= $form->field($model, 'staff_login_time')->textInput(['maxlength' => true]) ?> -->

    <?php $server_id = YxStaff::getCmpServer(); ?>
    <?= $form->field($model, 'staff_main_server_id')->dropDownList($server_id) ?>

    <?php 
        $server2_id = YxStaff::getCmpServer(); 
        foreach ($server2_id as $key => $value) {
            if($key==$model->staff_main_server_id){
                unset($server2_id[$key]);
            }
        }
        $model->staff_all_server_id = explode(',', $model->staff_all_server_id);
    ?>
    <?= $form->field($model, 'staff_all_server_id')->checkboxList($server2_id);?>

    <?php $staff_manage_time = $model->getStaffTime(); ?>
   <?= $form->field($model, 'staff_manage_time')->dropDownList($staff_manage_time,['disabled'=>'disabled']) ;?>

   <?= $form->field($model, 'staff_idcard_front')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>102400,
        ],
    ]) ?>

   <?= $form->field($model, 'staff_idcard_back')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>102400,
        ],
    ]) ?>

    <?php $staff_educate = $model->getStaffEducate(); ?>
   <?= $form->field($model, 'staff_educate')->dropDownList($staff_educate,['disabled'=>'disabled']) ?>

   <?= $form->field($model, 'staff_skill')->textInput(['maxlength' => true,'value'=>'无','readonly'=>true]) ?>

   <?= $form->field($model, 'staff_crime_record')->textInput(['maxlength' => true,'value'=>'无','readonly'=>true]) ?>

   <?= $form->field($model, 'staff_sin_record')->textInput(['maxlength' => true,'value'=>'无','readonly'=>true]) ?>

    <?= $form->field($model, 'staff_province')->widget(\chenkby\region\Region::className(),[
        'model'=>$model,
        'url'=> \yii\helpers\Url::toRoute(['get-region']),
        'province'=>[
            'attribute'=>'staff_province',
            'items'=>Region::getRegion(),
            'options'=>['class'=>'form-control form-control-inline yc-selected-staff_province','prompt'=>'选择省份'],
            'disabled'=>'disabled'
        ],
        'city'=>[
            'attribute'=>'staff_city',
            'items'=>Region::getRegion($model['staff_province']),
            'options'=>['class'=>'form-control form-control-inline yc-selected-staff_city','prompt'=>'选择城市'],
            'disabled'=>'disabled'
        ],
        'district'=>[
            'attribute'=>'staff_district',
            'items'=>Region::getRegion($model['staff_city']),
            'options'=>['class'=>'form-control form-control-inline yc-selected-staff_district','prompt'=>'选择县/区'],
            'disabled'=>'disabled'
        ]
    ]);
    ?>

   <?= $form->field($model, 'staff_address')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'staff_health_img')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 1,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>102400,
        ],
    ]) ?>

   <?= $form->field($model2, 'image')->widget(QiniuFileInput::className(),[
        'uploadUrl' => 'https://upload-z2.qiniup.com/', //文件上传地址 不同地区的空间上传地址不一样 参见官方文档
        'qlConfig' => Yii::$app->params['qnConfig'],
        'clientOptions' => [
            'max' => 30,//最多允许上传图片个数  默认为3
            'accept' => 'image/jpeg,image/png',//上传允许类型
            'size'=>102400,
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script >
    $(".zh-cover").hide();
    $(".file-btn").hide();
</script>
