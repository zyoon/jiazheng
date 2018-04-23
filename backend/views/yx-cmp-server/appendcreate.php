<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxCmpServer */
$queryParams = Yii::$app->request->queryParams;
$company_id = $queryParams['company_id'];
$server_id = $queryParams['server_id'];
$this->title = '新增服务';
$this->params['breadcrumbs'][] = ['label' => '服务列表', 'url' => ['index?company_id='.$company_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '附加服务列表'), 'url' => ['append?company_id='.$company_id. '&server_id=' . $server_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-cmp-server-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_appendform', [
        'model' => $model,
    ]) ?>

</div>
