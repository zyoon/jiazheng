<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxStaff */

$this->title = Yii::t('app', '添加员工');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '员工列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model2'=>$model2,
    ]) ?>

</div>
