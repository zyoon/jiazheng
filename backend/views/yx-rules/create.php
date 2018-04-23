<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxRules */

$this->title = Yii::t('app', '新增');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '规则'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-rules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
