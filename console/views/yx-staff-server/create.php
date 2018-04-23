<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxStaffServer */

$this->title = Yii::t('app', '添加服务');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '已选服务列表'), 'url' => ['index?staff_id='.Yii::$app->request->queryParams['staff_id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-server-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
