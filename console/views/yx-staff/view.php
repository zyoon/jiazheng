<?php

use common\models\YxCompany;
use common\models\YxStaff;
use common\models\YxStaffVerify;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\YxStaff */

$this->title = $model->staff_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?php 
           $verify_model=YxStaff::find()->where(['staff_id'=>$model->staff_id])->one();
           if($verify_model['staff_state']!=0){
            echo Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->staff_id], ['class' => 'btn btn-primary']);
           }
            $ycv_model=YxStaffVerify::find()->where(['staff_id'=>$model->staff_id,'staff_verify_state'=>1])->one();
            if($ycv_model){
                echo '审核中';
            }else{
               echo Html::a(Yii::t('app', '重新审核'), ['verify', 'id' => $model->staff_id], ['class' => 'btn btn-danger']);
            }
        ?>
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        'staff_number',
        'staff_id',
        [
            'attribute' => 'companyName',
            'value' => function ($model) {
                return YxCompany::getOneName($model->company_id);
            },
        ],
        'staff_name',
        [
            'attribute' => 'staff_sex',
            'value' => function ($model) {
                return YxStaff::getCmpSexName($model->staff_sex);
            },
        ],
        [
            'attribute' => 'staff_age',
            'value' => function ($model) {
                return date('Y-m-d', $model->staff_age);
            },
        ],
        [
            'attribute' => 'staff_img',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->staff_img;
            },
        ],
        'staff_idcard',
        'staff_intro',
        [
            'attribute' => 'staff_found',
            'value' => function ($model) {
                return date('Y-m-d H:i', $model->staff_found);
            },
        ],
        [
            'attribute' => 'staff_state',
            'value' => function ($model) {
                return YxStaff::getCmpStateName($model->staff_state);
            },
        ],
        'staff_memo',
        'staff_login_ip',
        'staff_login_time',
        [
            'attribute' => 'staff_main_server_id',
            'value' => function ($model) {
                return YxStaff::getCmpServerName($model->staff_main_server_id);
            },
        ],
        [
            'attribute' => 'staff_all_server_id',
            'value' => function ($model) {
                return YxStaff::getAllServer($model->staff_all_server_id);
            },
        ],
        'staff_query:ntext',
        [
            'attribute' => 'pre_clinch',
            'value' => function ($model) {
                return YxStaff::getPreClinch($model->staff_id);
            },
        ],
        [
            'attribute' => 'pre_price',
            'value' => function ($model) {
                return YxStaff::getPrePrice($model->staff_id);
            },
        ],
        [
            'attribute' => 'staff_fraction',
            'value' => function ($model) {
                $staff_fraction = $model->staff_fraction / 1000;
                return $staff_fraction;
            },
        ],
        [
            'attribute' => 'staff_base_fraction',
            'value' => function ($model) {
                $staff_base_fraction = $model->staff_base_fraction / 1000;
                return $staff_base_fraction;
            },
        ],
        [
            'attribute' => 'staff_history_fraction',
            'value' => function ($model) {
                $staff_history_fraction = $model->staff_history_fraction / 1000;
                return $staff_history_fraction;
            },
        ],
        'staff_clinch',
        [
            'attribute' => 'staff_price',
            'value' => function ($model) {
                $staff_price = $model->staff_price / 100;
                return $staff_price;
            },
        ],
        [
            'attribute' => 'staff_manage_time',
            'value' => function ($model) {
                return YxStaff::getStaffTimeName($model->staff_manage_time);
            },
        ],
        [
            'attribute' => 'staff_idcard_front',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->staff_idcard_front;
            },
        ],
        [
            'attribute' => 'staff_idcard_back',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->staff_idcard_back;
            },
        ],
        'staff_address',
        [
            'attribute' => 'staff_educate',
            'value' => function ($model) {
                return YxStaff::getStaffEducateName($model->staff_educate);
            },
        ],

        'staff_skill',
        'staff_crime_record',
        'staff_sin_record',
        'staff_train',
        [
            'attribute' => 'staff_health_img',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->staff_health_img;
            },
        ],
    ],
]);?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'showOnEmpty'=>true,
    'layout' => "{items}",
    'columns' => [
        [
            'label'=>'相关证书',
            'attribute'=>'image',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->image;
            },

        ],
    ],
]);?>

</div>
