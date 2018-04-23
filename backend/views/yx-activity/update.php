<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxActivity */

$this->title = Yii::t('app', ' {nameAttribute}', [
    'nameAttribute' => $model->activity_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '活动图'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_id, 'url' => ['view', 'id' => $model->activity_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-activity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
