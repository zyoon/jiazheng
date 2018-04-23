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

    <p>
        <?php 
        $create_url='create';
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
        $create_url=$create_url.$uri;
         ?>
        <?= Html::a('新增', [$create_url], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'content',
            'star',
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
                    return $models->order_name;
                }
                return '无';
            },
        ],
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作', 
                'template' => '{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function($url,$model,$uri){
                        $queryParams=Yii::$app->request->queryParams;
                        if(isset($queryParams['company_id'])){
                            $uri='?company_id='.$queryParams['company_id'];
                        }
                        if(isset($queryParams['order_id'])){
                            $uri='?order_id='.$queryParams['order_id'];
                        }
                        if(isset($queryParams['staff_id'])){
                            $uri='?staff_id='.$queryParams['staff_id'];
                        }
                        $url="/yx-comment/view".$uri."&id=".$model->id;
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => '查看']);
                    },
                    'update'=>function($url,$model,$uri){
                        $queryParams=Yii::$app->request->queryParams;
                        if(isset($queryParams['company_id'])){
                            $uri='?company_id='.$queryParams['company_id'];
                        }
                        if(isset($queryParams['order_id'])){
                            $uri='?order_id='.$queryParams['order_id'];
                        }
                        if(isset($queryParams['staff_id'])){
                            $uri='?staff_id='.$queryParams['staff_id'];
                        }
                        $url="/yx-comment/update".$uri."&id=".$model->id;
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '更新']);
                    },
                    'delete'=>function($url,$model,$uri){
                        $queryParams=Yii::$app->request->queryParams;
                        if(isset($queryParams['company_id'])){
                            $uri='?company_id='.$queryParams['company_id'];
                        }
                        if(isset($queryParams['order_id'])){
                            $uri='?order_id='.$queryParams['order_id'];
                        }
                        if(isset($queryParams['staff_id'])){
                            $uri='?staff_id='.$queryParams['staff_id'];
                        }
                        $url="/yx-comment/delete".$uri."&id=".$model->id;

                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => '删除']);
                    },
                ]
            ],
        ],
    ]); ?>
</div>
