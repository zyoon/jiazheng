<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\YxNotice;
/* @var $this yii\web\View */
/* @var $model common\models\YxNotice */

$this->title = $model->notice_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '公告'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-notice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->notice_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->notice_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '您确定要删除此项吗?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'notice_id',
            'notice_title',
            'notice_content:ntext',
            [
                'attribute' => 'notice_state',
                'value' => function ($model) {
                    return YxNotice::getStateName($model->notice_state);
                },
            ],
        ],
    ]) ?>

</div>
