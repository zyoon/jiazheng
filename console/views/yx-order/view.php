<?php

use common\models\YxCompany;
use common\models\YxOrder;
use common\models\YxServer;
use common\models\YxStaff;
use common\models\YxUser;
use common\models\YxOrderServer;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\YxOrder */

$this->title = $model->id;
$queryParams = Yii::$app->request->queryParams;
$index_url = 'index';
$update_url='update';
$delete_url='delete';
$uri='';
if (isset($queryParams['company_id'])) {
    $uri ='?company_id=' . $queryParams['company_id'];
}
if (isset($queryParams['user_id'])) {
    $uri ='?user_id=' . $queryParams['user_id'];
}
if (isset($queryParams['staff_id'])) {
    $uri ='?staff_id=' . $queryParams['staff_id'];
}
$index_url=$index_url.$uri;
$update_url=$update_url.$uri.'&id='.$model->id;
$delete_url=$delete_url.$uri.'&id='.$model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '订单列表'), 'url' => [$index_url]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-order-view">

    <h1><?=Html::encode($this->title);?></h1>

    <p>
        <?=Html::a(Yii::t('app', '删除'), [$delete_url], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => Yii::t('app', '您确定删除此项吗?'),
        'method' => 'post',
    ],
]);?>
    </p>

    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        // 'id',
        'order_no',
        'order_name',
        // 'yx_user_id',
        [
            'label' => '公司编号',
            'attribute' => 'cmp_number',
            'value' => function ($model) {
                return (YxCompany::findOne($model->yx_company_id))['number'];
            },
        ],
        [
            'label' => '公司名称',
            'attribute' => 'cmp_number',
            'value' => function ($model) {
                return (YxCompany::findOne($model->yx_company_id))['name'];
            },
        ],
        [
            'label' => '员工编号',
            'attribute' => 'staff_number',
            'value' => function ($model) {
                return (YxStaff::findOne($model->yx_staff_id))['staff_number'];
            },
        ],
        [
            'label' => '员工名称',
            'attribute' => 'staff_name',
            'value' => function ($model) {
                return (YxStaff::findOne($model->yx_staff_id))['staff_name'];
            },
        ],

        [
            'label' => '用户账号',
            'attribute' => 'user_phone',
            'value' => function ($model) {
                return (YxUser::findOne($model->yx_user_id))['phone'];
            },
        ],
        [
            'label' => '用户昵称',
            'attribute' => 'user_nickanme',
            'value' => function ($model) {
                return (YxUser::findOne($model->yx_user_id))['nickname'];
            },
        ],
        [
            'label' => '主要服务',
            'attribute' => 'order_server',
            'value' => function ($model) {
                $order_server_model=YxOrderServer::find()->where(['yx_order_id'=>$model->id,'is_main'=>1])->one();
                return $order_server_model['server_name']."(".($order_server_model['server_price']/100)."元)";
            },
        ],
        [
            'label' => '附加服务',
            'attribute' => 'add_order_server',
            'value' => function ($model) {
                $order_server_model=YxOrderServer::find()->where(['yx_order_id'=>$model->id,'is_main'=>0])->all();
                $server_name='';
                if($order_server_model){
                    foreach ($order_server_model as $key => $value) {
                        if($key==(count($order_server_model)-1)){
                            $server_name=$server_name.$value['server_name']."(".($value['server_price']/100)."元)".",";
                            continue;
                        }
                        $server_name=$server_name.$value['server_name'];
                    }  
                }
                return $server_name;

            },
        ],
        'user_name',
        'address',
        'phone',
        [
            'attribute' => 'order_money',
            'value' => function ($model) {
                $order_money = ($model->order_money) / 100;
                return $order_money;
            },
        ],
        [
            'attribute' => 'order_state',
            'value' => function ($model) {
                return YxOrder::getName($model->order_state, 'getOrderState');
            },
        ],
        [
            'attribute' => 'order_type',
            'value' => function ($model) {
                return YxOrder::getName($model->order_type, 'getOrderType');
            },
        ],
        'order_memo',

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
        // 'is_delete',
        [
            'attribute' => 'time_start',

            'value' => function ($model) {
                return date('Y-m-d H:i', $model->time_start);
            },
        ],
        [
            'attribute' => 'time_start',
            'value' => function ($model) {
                return date('Y-m-d H:i', $model->time_start);
            },
        ],
    ],
]);?>
    <p>
        <?php

$order_state = $model->order_state;
if ($order_state == 2) {
    echo Html::a(Yii::t('app', '确认接单'), ['acceptorder', 'id' => $model->id], [
        'class' => 'btn btn-success',
        'data' => [
            'confirm' => Yii::t('app', '您确定是否要接单?'),
            'method' => 'post',
        ],
    ]);

    echo Html::a(Yii::t('app', '拒绝接单'), ['notacceptorder', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', '您确定是否要拒绝此单?'),
            'method' => 'post',
        ],
    ]);
}
if ($order_state == 3 || $order_state == 4) {

    echo Html::a(Yii::t('app', '强制退款'), ['notoverorder', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', '您确定要强制退款?'),
            'method' => 'post',
        ],
    ]);
}

?>

    </p>
</div>
