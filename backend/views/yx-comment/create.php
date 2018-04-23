<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YxComment */
		$queryParams = Yii::$app->request->queryParams;
        $index_url='index';
        $uri='';
        if(isset($queryParams['company_id'])){
            $uri='?company_id='.$queryParams['company_id'];
        }
        if(isset($queryParams['order_id'])){
            $uri='?order_id='.$queryParams['order_id'];
        }
        if(isset($queryParams['staff_id'])){
            $uri='?staff_id='.$queryParams['staff_id'];
        }
        $index_url=$index_url.$uri;
$this->title = '新增';
$this->params['breadcrumbs'][] = ['label' => '评论列表', 'url' => [$index_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
