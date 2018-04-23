<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaffServer */

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->server->server_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '已选服务列表'), 'url' => ['index?staff_id='.$model->staff_id]];
$this->params['breadcrumbs'][] = ['label' => $model->server->server_name, 'url' => ['view', 'staff_id' => $model->staff_id, 'server_id' => $model->server_id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-staff-server-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
