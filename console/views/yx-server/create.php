<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxServer */

$this->title = Yii::t('app', '添加服务');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '服务列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-server-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
