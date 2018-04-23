<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxUserAddress */

$this->title = 'Create Yx User Address';
$this->params['breadcrumbs'][] = ['label' => 'Yx User Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-user-address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
