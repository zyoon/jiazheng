<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxRules */

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->rules_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '规则'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rules_id, 'url' => ['view', 'id' => $model->rules_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-rules-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
