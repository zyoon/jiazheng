<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Region;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxCompanyVerifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '公司审核列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-verify-index">

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

            // 'company_id',
            'name',
            // 'province',
            // 'city',
            // 'district',
            [
                'attribute'=>'provinceName',
                'value' => function($model) {
                    return Region::getOneName($model->province);
                }
            ],
            [
                'attribute'=>'cityName',
                'value' => function($model) {
                    return Region::getOneName($model->city);
                }
            ],
            [
                'attribute'=>'districtName',
                'value' => function($model) {
                    return Region::getOneName($model->district);
                }
            ],
            //'address',
            //'telephone',
            //'charge_phone',
            //'charge_man',
            //'longitude',
            //'latitude',
            //'operating_radius',
            //'wechat',
            //'created_at',
            //'updated_at',
            //'number',
            // [
            //   'attribute'=>'status',
            //   'filter'=>common\models\YxCompany::getCmpStatus(),
            //   'value' => function($model) {
            //       return common\models\YxCompany::getCmpStatusName($model->status);
            //   }
            // ],
            //'business_licences',
            //'models',
            //'introduction:ntext',
            [
              'attribute'=>'verify_sate',
              'filter'=>common\models\YxCompanyVerify::getVerifyState(),
              'value' => function($model) {
                  return common\models\YxCompanyVerify::getVerifyStateName($model->verify_sate);
              }
            ],
           //'verify_memo:ntext',
           //'id',
            //'main_server_id',
           //'all_server_id',
           //'query:ntext',
           //'cmp_user_id',
           //'image',
           //'total_fraction',
           //'base_fraction',
           //'history_fraction',
           //'clinch',
           //'price',
           //'manage_time:datetime',
           //'banck_card',
           //'alipay',
           //'business_code',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
