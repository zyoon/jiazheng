<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxRecomLeft */

$this->title = Yii::t('app', '创建');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '推荐左图'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-recom-left-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
