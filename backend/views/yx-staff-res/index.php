<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\YxStaffResSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '员工成果列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-res-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            $queryParams = Yii::$app->request->queryParams;
            $staff_id = $queryParams['staff_id'];
        ?>
        <?= Html::a('新增', ['create?staff_id=' . $staff_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'staff_res_id',
            // 'staff_id',
            [
                'attribute'=>'staff_res_img',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->staff_res_img;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
