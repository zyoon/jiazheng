<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HmCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '审核';
?>
<div class="yx-company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
