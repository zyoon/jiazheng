<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxOrder */

$this->title = Yii::t('app', 'Create Yx Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Yx Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
