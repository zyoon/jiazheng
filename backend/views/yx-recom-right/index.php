<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxRecomRight;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxRecomRightSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '推荐右图');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-recom-right-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        $sum = YxRecomRight::find()->count();
        if($sum<1){
            echo Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'recom_right_id',
            [
                'attribute'=>'recom_right_pic',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->recom_right_pic;
                }
            ],
            'recom_right_href',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
