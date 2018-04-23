<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\YxOrder */
// $this->registerJsFile(Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp.js");
// $this->registerJsFile(Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp_ui.js");
// $this->registerCssFile(Yii::$app->params['webuploader']['fileDomain']."react/build/static/css/main.css");

$this->title = '订单支付';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Yx Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="<?php echo Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp_ui.js" ?>" ></script>
<script src="<?php echo Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp.js" ?>" ></script>
<link rel="stylesheet" href="<?php echo '/css/pay.css' ?>">
<div class="yx-order-view">

    <h3><?= '您的订单已于'.date('Y-m-d H:i', $model->created_at).'提交成功，请您在半小时内付款' ?></h3>

    <p>订单信息</p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'order_name',
            'address',
            'phone',
            [
        			'label' => '订单金额',
        			'value' => function ($model) {
        				return sprintf("%.2f",($model->order_money/100)).'元';
        			},
        		],
            //'order_money',
            'order_memo',
            'user_name',
        ],
    ]) ?>

    <p>
        <!-- <?= Html::a('<sapn>支付宝支付</sapn>', ['pay','id'=>$model->id,'channel'=>'alipay_pc_direct'], ['class' => 'btn btn-primary']) ?> -->
        <!-- <input type="button" id="payBtn" class="btn btn-primary" value="支付宝支付"/> -->
    </p>
</div>
<div id="p_one_frame">
    <div id="p_one_mask" class="p_one_mask"></div>
    <div class="p_one_window  p_one_default">
        <div class="p_one_html in">
            <div class="p_one_body">
                <div id="p_one_channelList" class="p_one_channel">
                    <div p_one_channel="alipay_pc_direct" class="p_one_btn"><div class="p_one_icon_alipay">支付宝</div></div>
                    <div p_one_channel="wx_wap" class="p_one_btn"><div class="p_one_icon_wechat">微信支付</div></div>
                    <div p_one_channel="upacp_wap" class="p_one_btn"><div class="p_one_icon_unionpay">银联支付</div></div>
                    <div p_one_channel="yeepay_wap" class="p_one_btn"><div class="p_one_icon_yeepay">易宝支付</div></div>
                    <div p_one_channel="jdpay_wap" class="p_one_btn"><div class="p_one_icon_jdpay">京东支付</div></div>
                    <div p_one_channel="bfb_wap" class="p_one_btn"><div class="p_one_icon_baidu">百度钱包</div></div>
                </div>
            </div>
        </div>
    </div></div>
<script>
  // pingpp_ui.init({
  //     // 页面上需要展示的渠道。数组，数组顺序即页面展示出的渠道的顺序
  //     channel:['alipay_wap','wx_pub','wx_wap','upacp_wap','yeepay_wap','jdpay_wap','bfb_wap']
  // },function(channel){
  //     // 用户选择的支付渠道
  //     console.log(channel);
  // });
  $(".p_one_btn").click(function(){
    var chanelStr = $(this).attr("p_one_channel")
    console.log(chanelStr)
    window.location.href = "pay?id=<?php echo $model->id?>&channel="+chanelStr;
  })
</script>
