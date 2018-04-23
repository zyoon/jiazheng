<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxNotice */

$this->title = Yii::t('app', '新增');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '公告'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-notice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
