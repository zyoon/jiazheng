<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxComment */

$this->title = $order->order_name;
$this->params['breadcrumbs'][] = ['label' => 'Yx Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-comment-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'order' => $order,
    ]) ?>

</div>
