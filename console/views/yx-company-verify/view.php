<?php

use common\models\Region;
use common\models\YxCompanyVerify;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\YxCompany;
/* @var $this yii\web\View */
/* @var $model common\models\YxCompanyVerify */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '公司审核列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-verify-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
    <p style="color: red;font-size: 30px">
        <?php 
        $id=YxCompanyVerify::find()->max('id');

        if($model->verify_sate==2&&$model->id==$id){
            echo Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }else{
            echo YxCompanyVerify::getVerifyStateName($model->verify_sate);
        } ?>
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        'company_id',
        'name',
        [
            'attribute' => 'image',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->image;
            },
        ],
        [
            'attribute' => 'province',
            'value' => function ($model) {
                return Region::getOneName($model->province);
            },
        ],
        [
            'attribute' => 'city',
            'value' => function ($model) {
                return Region::getOneName($model->city);
            },
        ],
        [
            'attribute' => 'district',
            'value' => function ($model) {
                return Region::getOneName($model->district);
            },
        ],
        'address',
        'telephone',
        'charge_phone',
        'charge_man',
        'longitude',
        'latitude',
        'operating_radius',
        'wechat',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('Y-m-d H:i', $model->created_at);
            },
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return date('Y-m-d H:i', $model->updated_at);
            },
        ],
        'number',
        // [
        //     'attribute' => 'status',
        //     'value' => function ($model) {
        //         return common\models\YxCompany::getCmpStatusName($model->status);
        //     },
        // ],

        [
            'attribute' => 'models',
            'value' => function ($model) {
                return common\models\YxCompany::getCmpModelsName($model->models);
            },
        ],
        [
            'attribute' => 'business_licences',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->business_licences;
            },
        ],
        'introduction:ntext',
        [
            'attribute' => 'verify_sate',
            'value' => function ($model) {
                return common\models\YxCompanyVerify::getVerifyStateName($model->verify_sate);
            },
        ],
        'verify_memo:ntext',
        //'id',
        [
            'attribute' => 'main_server_id',
            'value' => function ($model) {
                return YxCompany::getAllServer($model->main_server_id);
            },
        ],
        [
            'attribute' => 'all_server_id',
            'value' => function ($model) {
                return YxCompany::getAllServer($model->all_server_id);
            },
        ],
       'query:ntext',
        'manage_time',
        'banck_card',
        'alipay',
        'business_code',
    ],
]);?>