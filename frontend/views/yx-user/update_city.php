<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxUser */

$this->title = '切换城市';
$this->params['breadcrumbs'][] = ['label' => 'Yx Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="yx-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
