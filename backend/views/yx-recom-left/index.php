<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxRecomLeft;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxRecomLeftSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '推荐左图');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-recom-left-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        $sum = YxRecomLeft::find()->count();
        if($sum<4){
            echo Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'recom_left_id',
            [
                'attribute'=>'recom_left_pic',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->recom_left_pic;
                }
            ],
            'recom_left_href',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
