<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxStaffImg */

$this->title = 'Create Yx Staff Img';
$this->params['breadcrumbs'][] = ['label' => 'Yx Staff Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-img-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
