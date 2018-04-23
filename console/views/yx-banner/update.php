<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxBanner */

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->banner_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '轮播列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->banner_id, 'url' => ['view', 'id' => $model->banner_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-banner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
