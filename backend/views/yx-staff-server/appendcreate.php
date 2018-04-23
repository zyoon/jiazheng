<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxStaffServer */


$queryParams = Yii::$app->request->queryParams;
$staff_id = $queryParams['staff_id'];
$server_id = $queryParams['server_id'];

$this->title = Yii::t('app', '添加附加服务');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '已选服务列表'), 'url' => ['index?staff_id='.$staff_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '附加服务列表'), 'url' => ['append?staff_id='.$staff_id. '&server_id=' . $server_id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-server-appendcreate">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_appendform', [
        'model' => $model,
    ]) ?>

</div>
