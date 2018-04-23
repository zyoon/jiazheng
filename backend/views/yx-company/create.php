<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\yxCompany */

$this->title = '添加公司';
$this->params['breadcrumbs'][] = ['label' => '公司列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
