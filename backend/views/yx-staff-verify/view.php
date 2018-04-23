<?php

use common\models\YxStaff;
use common\models\YxStaffVerify;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\Region;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaffVerify */

$this->title = $model->staff_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工审核列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-verify-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?=Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);?>
        <?=Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->id], [
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

    <p>
        <?php

if ($model->staff_verify_state == 1) {

    ?>
        <?=Html::a('通过审核', '#', [
            'id' => 'ext',
            'data-toggle' => 'modal',
            'data-target' => '#ext-modal',
            'class' => 'btn btn-success',
        ]);?>
        <?=Html::a('驳回审核', '#', [
        'id' => 'deny',
        'data-toggle' => 'modal',
        'data-target' => '#deny-modal',
        'class' => 'btn btn-danger',
    ]);?>
        <?php }?>
    </p>
</div>
<?php

Modal::begin([
    'id' => 'deny-modal',
    'header' => '<h4 class="modal-title">驳回建议</h4>',
    //'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">提交</a>',
]);
// $requestUrl = Url::toRoute('test');
// $js = <<<JS
//     $.get('{$requestUrl}', {},
//         function (data) {
//             $('.modal-body').html(data);
//             console.log(data);
//         }
//     );
// JS;
$verify = Yii::$app->request->csrfToken;
$js = <<<JS
    var data='<form class="form-horizontal myform" method="post" enctype="multipart/form-data"><input name="_csrf-backend" type="hidden" id="_csrf-backend" value="{$verify}"><div class="form-group"><div class="col-sm-12"><textarea class="form-control" name="staff_verify_memo" rows="12"></textarea></div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-12"><button type="submit" class="btn btn-warning">提交</button></div></div></form>'
    $('.modal-body').html(data);
JS;
$this->registerJs($js);
Modal::end();

Modal::begin([
    'id' => 'ext-modal',
    'header' => '<h4 class="modal-title">额外审核加分</h4>',
]);
$verify=Yii::$app->request->csrfToken;
$id=$model->id;
$js = <<<JS
    var data='<form class="form-horizontal myform" action="/yx-staff-verify/pass?id={$id}" method="post" enctype="multipart/form-data"><input name="_csrf-backend" type="hidden" id="_csrf-backend" value="{$verify}"><div class="form-group"><div class="col-sm-12"><input class="form-control" name="ext_fraction" type="number" min="0" max="3" step="0.001" value="{$ext_fraction}"></input></div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-12"><button type="submit" class="btn btn-warning">提交</button></div></div></form>'
    $('.modal-body').html(data);
JS;
$this->registerJs($js);
Modal::end();

?>
