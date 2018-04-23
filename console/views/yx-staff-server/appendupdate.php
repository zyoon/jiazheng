<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxStaffServer */


$queryParams = Yii::$app->request->queryParams;
$staff_id = $queryParams['staff_id'];
$server_id = $queryParams['server_id'];

$this->title = Yii::t('app', '{nameAttribute}', [
    'nameAttribute' => $model->server->server_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '已选服务列表'), 'url' => ['index?staff_id='.$staff_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '附加服务列表'), 'url' => ['append?staff_id='.$staff_id. '&server_id=' . $model->server_parent_id]];

$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-staff-server-appendupdate">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_appendform', [
        'model' => $model,
    ]) ?>

</div>
