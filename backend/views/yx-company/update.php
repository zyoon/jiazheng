<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HmCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '公司列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="yx-company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
