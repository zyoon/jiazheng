<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxCmpRes */

$this->title = '新增';
$this->params['breadcrumbs'][] = ['label' => '公司成果列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-cmp-res-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
