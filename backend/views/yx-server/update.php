<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxServer */

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->server_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '服务列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->server_name, 'url' => ['view', 'id' => $model->server_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-server-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
