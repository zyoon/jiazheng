<?php

use common\models\Region;
use common\models\YxCompany;
use common\models\YxStaff;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\YxStaff */

$this->title = $model->staff_name;

$queryParams = Yii::$app->request->queryParams;
$index_url = 'index';
$update_url = 'update';
$delete_url = 'delete';
$uri = '?id=' . $model->staff_id;

if (isset($queryParams['company_id'])) {
    $uri = '?company_id=' . $queryParams['company_id'];
    $index_url = $index_url . $uri . '&id=' . $model->staff_id;
    $delete_url = $delete_url . $uri . '&id=' . $model->staff_id;
    $update_url = $update_url . $uri . '&id=' . $model->staff_id;
} else {
    $index_url = $index_url . $uri;
    $update_url = $update_url . $uri;
    $delete_url = $delete_url . $uri;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工列表'), 'url' => [$index_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?=Html::a(Yii::t('app', '修改'), [$update_url], ['class' => 'btn btn-primary']);?>
        <?=Html::a(Yii::t('app', '删除'), [$delete_url], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => Yii::t('app', '您确定要删除此项吗?'),
        'method' => 'post',
    ],
]);?>
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
        [
            'attribute' => 'staff_login_time',
            'value' => function ($model) {
                return date('Y-m-d H:i', $model->staff_login_time);
            },
        ],
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
                $pre_price = YxStaff::getPrePrice($model->staff_id);
                return $pre_price / 100;
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

        [
            'attribute' => 'staff_clinch',
            'value' => function ($model) {
                return YxStaff::getClinch($model->staff_id);
            },
        ],
        [
            'attribute' => 'staff_price',
            'value' => function ($model) {
                $pre_price = YxStaff::getPrice($model->staff_id);
                return $pre_price / 100;
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
        [
            'attribute' => 'staff_province',
            'value' => function ($model) {
                return Region::getOneName($model->staff_province);
            },
        ],
        [
            'attribute' => 'staff_city',
            'value' => function ($model) {
                return Region::getOneName($model->staff_city);
            },
        ],
        [
            'attribute' => 'staff_district',
            'value' => function ($model) {
                return Region::getOneName($model->staff_district);
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
    'showOnEmpty' => true,
    'layout' => "{items}",
    'columns' => [
        [
            'label' => '相关证书',
            'attribute' => 'image',
            'format' => ['image', ['width' => '200', 'height' => '200']],
            'value' => function ($model) {
                return $model->image;
            },

        ],
    ],
]);?>

</div>
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
$verify = Yii::$app->request->csrfToken;
$id = $model->staff_id;
$js = <<<JS
    var data='<form class="form-horizontal myform" action="/yx-staff/adjustfraction?id={$id}" method="post" enctype="multipart/form-data"><input name="_csrf-backend" type="hidden" id="_csrf-backend" value="{$verify}"><div class="form-group"><div class="col-sm-12"><input class="form-control" name="ext_history_fraction" type="number" step="0.001" value="0"></input></div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-12"><button type="submit" class="btn btn-warning">提交</button></div></div></form>'
    $('.modal-body').html(data);
JS;
$this->registerJs($js);
Modal::end();

?>