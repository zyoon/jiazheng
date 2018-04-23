<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\YxOrder;
/* @var $this yii\web\View */
/* @var $model common\models\YxOrderSearch */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile("/css/order/index.css");
?>

<div class="yx-order-search">

    <?php echo Html::beginForm(['index'], 'post',['class' => 'order-heard-table']); ?>
    <?php echo Html::submitButton('全部',['class' => 'btn btn-link'.($model->order_state == 0 ? "choosed" : "")]); ?>
    <?php echo Html::endForm();; ?>

    <?php echo Html::beginForm(['index?order_state=1'], 'post',['class' => 'order-heard-table']); ?>
    <?php echo Html::submitButton('未付款',['class' => 'btn btn-link'.($model->order_state == 1 ? "choosed" : "")]); ?>
    <?php echo Html::endForm();; ?>

    <?php echo Html::beginForm(['index?order_state=2'], 'post',['class' => 'order-heard-table']); ?>
    <?php echo Html::submitButton('进行中',['class' => 'btn btn-link'.($model->order_state == 2 ? "choosed" : "")]); ?>
    <?php echo Html::endForm();; ?>

    <?php echo Html::beginForm(['index?order_state=3'], 'post',['class' => 'order-heard-table']); ?>
    <?php echo Html::submitButton('已完成',['class' => 'btn btn-link'.($model->order_state == 3 ? "choosed" : "")]); ?>
    <?php echo Html::endForm();; ?>

    <?php echo Html::beginForm(['index?order_state=4'], 'post',['class' => 'order-heard-table']); ?>
    <?php echo Html::submitButton('退单',['class' => 'btn btn-link'.($model->order_state == 4 ? "choosed" : "")]); ?>
    <?php echo Html::endForm();; ?>

</div>
