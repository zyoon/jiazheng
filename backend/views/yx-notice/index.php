<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxNotice;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxNoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '公告');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-notice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'notice_id',
            'notice_title',
            'notice_content:ntext',
            [
                'attribute' => 'notice_state',
                'filter' => YxNotice::getState(),
                'value' => function ($model) {
                    return YxNotice::getStateName($model->notice_state);
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
