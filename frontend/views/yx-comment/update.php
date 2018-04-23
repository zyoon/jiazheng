<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxComment */

$this->title = 'Update Yx Comment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Yx Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="yx-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
