<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TestH */

$this->title = Yii::t('app', 'Create Test H');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Hs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-h-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
