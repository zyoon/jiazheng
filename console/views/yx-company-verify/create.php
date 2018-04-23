<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxCompanyVerify */

$this->title = Yii::t('app', '添加公司审核');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '公司审核列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-verify-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
