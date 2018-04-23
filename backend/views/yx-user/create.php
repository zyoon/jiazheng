<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxUser */

$this->title = 'Create Yx User';
$this->params['breadcrumbs'][] = ['label' => 'Yx Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
