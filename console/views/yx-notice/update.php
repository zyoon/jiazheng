<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxNotice */

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->notice_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '公告'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->notice_id, 'url' => ['view', 'id' => $model->notice_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-notice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
