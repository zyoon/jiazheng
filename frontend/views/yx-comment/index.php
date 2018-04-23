<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\YxCompany;
use common\models\YxStaff;
use common\models\YxUser;
use common\models\YxCommentSearch;
use common\models\YxOrder;
/* @var $this yii\web\View */
/* @var $searchModel common\models\YxCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$queryParams=Yii::$app->request->queryParams;
$this->title = '评论列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'showHeader' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'companyName',
            'value' => function ($model) {
                $models=YxCompany::findOne($model->yx_company_id);
                if($models){
                    return $models->name;
                }
                return '无';
            },
        ],
        [
            'attribute' => 'staffName',
            'value' => function ($model) {
                $models=YxStaff::findOne($model->yx_staff_id);
                if($models){
                    return $models->staff_name;
                }
                return '无';
            },
        ],
        [
            'attribute' => 'userName',
            'value' => function ($model) {
                $models=YxUser::findOne($model->yx_user_id);
                if($models){
                    return $models->nickname;
                }
                return '无';
            },
        ],
            //'is_praise',
        [
            'attribute' => 'orderName',
            'value' => function ($model) {
                $models=YxOrder::findOne($model->yx_order_id);
                if($models){
                    return $models->order_no;
                }
                return '无';
            },
        ],
            //'created_at',
            [
                'attribute' => 'updated_at',
                'label' => "评论时间",
                'value' => function ($model) {
                    return date('Y-m-d', $model->updated_at);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}',
                'buttons'=>[
                    'view'=>function($url,$model,$uri){
                        $url="/yx-comment/view?order_id=".$model->yx_order_id."&id=".$model->id;
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看']);
                    },
                ]
            ],
        ],
        'layout'=>'{items}<div class="text-right tooltip-demo">{pager}</div>',
        'pager'=>[
            //'options'=>['class'=>'hidden']//关闭分页
            'firstPageLabel'=>"首页",
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'lastPageLabel'=>'最后一页',
        ],
    ]); ?>
</div>
