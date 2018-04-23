<?php

use common\models\YxCompany;
use common\models\YxStaff;
use common\models\YxUser;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\YxComment */
$queryParams = Yii::$app->request->queryParams;
$index_url = 'index';
$update_url='update';
$delete_url='delete';
if (isset($queryParams['company_id'])) {
    $uri ='?company_id=' . $queryParams['company_id'];
}
if (isset($queryParams['order_id'])) {
    $uri ='?order_id=' . $queryParams['order_id'];
}
if (isset($queryParams['staff_id'])) {
    $uri ='?staff_id=' . $queryParams['staff_id'];
}
$index_url=$index_url.$uri;
$update_url=$update_url.$uri.'&id='.$model->id;
$delete_url=$delete_url.$uri.'&id='.$model->id;
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论列表', 'url' => [$index_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-comment-view">

    <h1><?=Html::encode($this->title);?></h1>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'content',
        'star',
        [
            'attribute' => 'yx_company_id',
            'value' => function ($model) {
                $models = YxCompany::findOne($model->yx_company_id);
                if ($models) {
                    return $models->name;
                }
                return '无';
            },
        ],
        [
            'attribute' => 'yx_staff_id',
            'value' => function ($model) {
                $models = YxStaff::findOne($model->yx_staff_id);
                if ($models) {
                    return $models->staff_name;
                }
                return '无';
            },
        ],
        [
            'attribute' => 'yx_user_id',
            'value' => function ($model) {
                $models = YxUser::findOne($model->yx_user_id);
                if ($models) {
                    return $models->nickname;
                }
                return '无';
            },
        ],
        // 'is_praise',
        'yx_order_id',

        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('Y-m-d H:i', $model->created_at);
            },
        ],
        [
            'attribute' => 'updated_at',
            'value' => function ($model) {
                return date('Y-m-d H:i', $model->updated_at);
            },
        ],
    ],
]);?>

</div>
