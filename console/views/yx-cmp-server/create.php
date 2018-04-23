<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxCmpServer */
$queryParams = Yii::$app->request->queryParams;
$company_id = $queryParams['company_id'];
$this->title = '新增服务';
$this->params['breadcrumbs'][] = ['label' => '服务列表', 'url' => ['index?company_id='.$company_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-cmp-server-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
