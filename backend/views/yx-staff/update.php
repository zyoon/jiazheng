<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\YxStaff */

$this->title = Yii::t('app', '修改: {nameAttribute}', [
    'nameAttribute' => $model->staff_name,
]);

$queryParams = Yii::$app->request->queryParams;
$index_url = 'index';
$view_url = 'view';
$uri = '?id=' . $model->staff_id;

if (isset($queryParams['company_id'])) {
    $uri = '?company_id=' . $queryParams['company_id'];
    $index_url = $index_url . $uri . '&id=' . $model->staff_id;
    $view_url = $view_url . $uri . '&id=' . $model->staff_id;
} else {
    $index_url = $index_url . $uri;
    $view_url = $view_url . $uri;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工列表'), 'url' => [$index_url]];
$this->params['breadcrumbs'][] = ['label' => $model->staff_name, 'url' => [$view_url]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
?>
<div class="yx-staff-update">

    <h1><?=Html::encode($this->title);?></h1>

    <?=$this->render('_form', [
    'model' => $model,
    'model2' => $model2,
]);?>

</div>
