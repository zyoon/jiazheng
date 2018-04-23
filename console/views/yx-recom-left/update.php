<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxRecomLeft */

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->recom_left_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '推荐左图'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recom_left_id, 'url' => ['view', 'id' => $model->recom_left_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-recom-left-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
