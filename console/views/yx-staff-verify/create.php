<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxStaffVerify */

$this->title = Yii::t('app', 'Create Yx Staff Verify');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Yx Staff Verifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-verify-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
