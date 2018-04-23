<?php

use common\models\Region;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\YxCompany;
use common\models\YxStaff;
use common\models\YxCmpUser;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\YxCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '公司列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?=Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);?>
        <?=Html::a('删除', ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => '您确定删除此项吗?',
        'method' => 'post',
    ],
]);?>
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        [
            'attribute' => 'yxCmpUsers.username',
            'value' => function ($model) {
                $user_model=YxCmpUser::findOne($model->cmp_user_id);
                if($user_model){
                    return $user_model['username'];
                }
                return '未设置';
            },
        ],
        [
            'attribute' => 'yxCmpUsers.password_see',
            'value' => function ($model) {
                $user_model=YxCmpUser::findOne($model->cmp_user_id);
                if($user_model){
                    return $user_model['password_see'];
                }
                return '未设置';
            },
        ],
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
        [
            'attribute' => 'clinch',
            'value' => function ($model) {
                return common\models\YxCompany::getClinch($model->id);
            },
        ],
        [
            'attribute' => 'price',
            'value' => function ($model) {
                $price=common\models\YxCompany::getPrice($model->id);
                return $price/100;
            },
        ],
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
                $price=common\models\YxCompany::getPrePrice($model->id);
                return $price/100;
            },
        ],
        'banck_card',
        'alipay',
        'business_code',
    ],
]);?>
    <p>
        <?=Html::a('调整运营分', '#', [
            'id' => 'deny',
            'data-toggle' => 'modal',
            'data-target' => '#deny-modal',
            'class' => 'btn btn-danger',
        ]);?>
    </p>
</div>
<?php

Modal::begin([
    'id' => 'deny-modal',
    'header' => '<h4 class="modal-title">调整运营分</h4>',
]);
$verify=Yii::$app->request->csrfToken;
$id=$model->id;
$js = <<<JS
    var data='<form class="form-horizontal myform" action="/yx-company/adjustfraction?id={$id}" method="post" enctype="multipart/form-data"><input name="_csrf-backend" type="hidden" id="_csrf-backend" value="{$verify}"><div class="form-group"><div class="col-sm-12"><input class="form-control" name="ext_history_fraction" type="number" step="0.001" value="0"></input></div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-12"><button type="submit" class="btn btn-warning">提交</button></div></div></form>'
    $('.modal-body').html(data);
JS;
$this->registerJs($js);
Modal::end();


?>
