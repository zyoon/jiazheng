<?php

use common\models\YxStaff;
use common\models\YxStaffVerify;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\YxStaffVerify */

$this->title = $model->staff_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工审核列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-verify-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p style="color: red;font-size: 30px">
        <?php if($model->staff_verify_state==2){
            echo Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }else{
            echo YxStaffVerify::getVerifyStateName($model->staff_verify_state);
        } ?>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        // 'id',
        // 'staff_id',
        // 'company_id',
        [
            'label' => '公司名称',
            'attribute' => 'company.name',
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
            'attribute' => 'staff_verify_state',
            'value' => function ($model) {
                return YxStaffVerify::getVerifyStateName($model->staff_verify_state);
            },
        ],
        'staff_verify_memo:ntext',
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

