<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxActivity;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '活动图');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        $sum = YxActivity::find()->count();
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

            // 'activity_id',
            // 'activity_pic',
            [
                'attribute'=>'activity_pic',
                'format' => ['image',['width'=>'200','height'=>'200',]],
                'value' => function($model){
                        return $model->activity_pic;
                }
            ],
            'activity_href',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
