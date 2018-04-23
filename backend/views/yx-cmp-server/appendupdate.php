<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxCmpServer */
$queryParams = Yii::$app->request->queryParams;
$company_id = $queryParams['company_id'];
$server_id = $queryParams['server_id'];
$this->title = '修改: ' . $model->server->server_name;
$this->params['breadcrumbs'][] = ['label' => '已选服务列表', 'url' => ['index?company_id='.$model->company_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '附加服务列表'), 'url' => ['append?company_id='.$company_id. '&server_id=' . $model->server_parent_id]];
$this->params['breadcrumbs'][] = ['label' => $model->server->server_name, 'url' => ['appendview', 'company_id' => $model->company_id, 'server_id' => $model->server_id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="yx-cmp-server-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_appendform', [
        'model' => $model,
    ]) ?>

</div>
