<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxCmpServer */

$this->title = '修改: ' . $model->server_name;
$this->params['breadcrumbs'][] = ['label' => '服务列表', 'url' => ['index?company_id='.$model->company_id]];
$this->params['breadcrumbs'][] = ['label' => $model->server_name, 'url' => ['view', 'company_id' => $model->company_id, 'server_id' => $model->server_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="yx-cmp-server-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
