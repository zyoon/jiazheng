<?php

use common\models\Region;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\YxCompany;
use common\models\YxCompanyVerify;
use common\models\YxStaff;
/* @var $this yii\web\View */
/* @var $model common\models\YxCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?=Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);?>
        <?php 
            $id=YxCompanyVerify::find()->where(['company_id'=>$model->id])->max('id');
            $verify_model=YxCompanyVerify::findOne($id);
            if($verify_model->verify_sate==1){
                echo '审核中';
            }else{
                echo Html::a('重新审核', ['verify', 'id' => $model->id], ['class' => 'btn btn-danger']);
            }
        ?>
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        [
            'attribute' => 'image',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->image;
            },
        ],
        [
            'attribute' => 'total_fraction',
            'value' => function ($model) {
                $total_fraction=$model->total_fraction/1000;
                return $total_fraction;
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
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return common\models\YxCompany::getCmpStatusName($model->status);
            },
        ],

        [
            'attribute' => 'models',
            'value' => function ($model) {
                return common\models\YxCompany::getCmpModelsName($model->models);
            },
        ],
        'introduction:ntext',
        [
            'attribute' => 'business_licences',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->business_licences;
            },
        ],
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
        [
            'attribute' => 'base_fraction',
            'value' => function ($model) {
                $base_fraction=$model->base_fraction/1000;
                return $base_fraction;
            },
        ],
        [
            'attribute' => 'history_fraction',
            'value' => function ($model) {
                $history_fraction=$model->history_fraction/1000;
                return $history_fraction;
            },
        ],
        'clinch',
        'price',
        [
            'attribute' => 'manage_time',
            'value' => function ($model) {
                return YxStaff::getStaffTimeName($model->manage_time);
            },
        ],
        [
            'attribute' => 'pre_clinch',
            'value' => function ($model) {
                return common\models\YxCompany::getPreClinch($model->id);
            },
        ],
        [
            'attribute' => 'pre_price',
            'value' => function ($model) {
                return common\models\YxCompany::getPrePrice($model->id);
            },
        ],
        'banck_card',
        'alipay',
        'business_code',
    ],
]);?>

</div>
