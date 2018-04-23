<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxStaff;
use common\models\YxStaffVerify;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxStaffVerifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '员工审核列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-verify-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--     <p>
        <?= Html::a(Yii::t('app', '添加审核'), ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'staff_id',
            //'company_id',
            [
                'label' => '公司名称',
                'attribute' => 'company.name',
            ],
            'staff_name',
            [
                'attribute' => 'staff_sex',
                'filter' => YxStaff::getCmpSex(),
                'value' => function ($model) {
                    return YxStaff::getCmpSexName($model->staff_sex);
                },
            ],
            //'staff_age',
            //'staff_img',
            //'staff_idcard',
            //'staff_intro',
            //'staff_found',
            //'staff_state',
            //'staff_memo',
            //'staff_login_ip',
            //'staff_login_time',
            //'staff_main_server_id',
            //'staff_all_server_id',
            //'staff_query:ntext',
            [
                'attribute' => 'staff_verify_state',
                'filter' => YxStaffVerify::getVerifyState(),
                'value' => function ($model) {
                    return YxStaffVerify::getVerifyStateName($model->staff_verify_state);
                },
            ],
            //'staff_verify_memo:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作', 
                'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
