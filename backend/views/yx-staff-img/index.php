<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\YxStaffImgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Yx Staff Imgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-staff-img-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Yx Staff Img', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'staff_id',
            'type',
            'image',
            'verify_state',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
