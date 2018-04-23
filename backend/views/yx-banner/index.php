<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxBanner;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxBannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '轮播图列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        $sum = YxBanner::find()->count();
        if($sum<4){
            echo Html::a(Yii::t('app', '新增轮播图'), ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'banner_id',
            [
                'attribute'=>'banner_pic',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->banner_pic;
                }
            ],
            'banner_href',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
