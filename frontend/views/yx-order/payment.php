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

<?php
  // if($isWechat && !isset($_COOKIE['wx_code'])){
  //   header('Location:getcode?id='.$model->id);
  //   die;
  // }
 $server_time_long = ($model->time_end - $model->time_start)/3600 + 1
?>
<?= Html::cssFile('/static/css/order.css') ?>
<script src="<?php echo Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp_ui.js" ?>" ></script>
<script src="<?php echo Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp.js" ?>" ></script>
<link rel="stylesheet" href="<?php echo '/css/pay.css' ?>">
<div class="yx-order-view">
    <h3><?= '您的订单已于'.date('Y-m-d H:i', $model->created_at).'提交成功，请您在半小时内付款' ?></h3>

    <div class="order-detail">
    	<div class="address child">
    		<p>服务地址：<span><?= $model->address ?></span></p>
        <p>联系人：<span><?= $model->user_name ?></span></p>
        <p>联系电话：<span><?= $model->phone ?></span></p>
    		<a href="/yx-user-address/index?yx_user_id=<?= Yii::$app->user->id ?>&order_id=<?= $model->id ?>" style="margin-left: 20px;">修改地址</a>
    	</div>
    	<div class="detail child">

        <div>订单编号：<span><?= $model->order_no ?></span></div>
        <div>服务公司：<span><?= $yxCompany->name ?></span></div>
        <?php
            if($model->yx_staff_id > 0){
                echo "<div>服务人员：<span>".$yxStaffName."</span></div>";
            }
        ?>
    		<div>上门时间：<span><?= date("Y-m-d H:i:s",$model->time_start+8*3600) ?></span></div>
    		<div>服务时长：<span><?= $server_time_long; ?> 小时</span></div>
        <?php
            foreach ($model->yx_order_server as $value) {
               if($value->is_main == 1){
                  echo '<div>服务项目：<span>'.$value->server_name.'</span></div>';
                  echo '<div>服务明细：<span>'.$value->server_name.'：'.number_format($value->server_price/100,2).'元×'.$value->server_amount.' '.$value->server_unit.'='.number_format($value->server_price * $value->server_amount/100,2).'元</span></div>';
               }
            }
        ?>
        <p>附加服务:</p>
        <?php
            foreach ($model->yx_order_server as $value) {
               if($value->is_main != 1){
                  echo '<div>'.$value->server_name.': <span>'.number_format($value->server_price/100,2).'元×'.$value->server_amount.' '.$value->server_unit.'='.number_format($value->server_price * $value->server_amount/100,2).'</span>元</div>';
               }
            }
        ?>
    	</div>
    	<div class="instructions child">
    		距服务开始超过4小时取消订单，不会扣除您的预付款。据服务开始超过2小时不足4小时取消订单，将扣除您预付款的20%。距服务开始不足2小时取消订单将扣除您预付款的50%。其余部分将原路返回到您的支付账户。
    	</div>
      <div class="child">
    		<div class="money">合计：<span>
          <?php
              $all_money=0;
              foreach ($model->yx_order_server as $value) {
                $all_money += $value->server_price * $value->server_amount;
              }
              echo number_format($all_money/100,2);
          ?>
        </span>元</div>
    	</div>

      <div class="money-memo child">
      		<textarea id="order_memo"></textarea>
    	</div>
    </div>

    <p>
        <!-- <?= Html::a('<sapn>支付宝支付</sapn>', ['pay','id'=>$model->id,'channel'=>'alipay_pc_direct'], ['class' => 'btn btn-primary']) ?> -->
        <!-- <input type="button" id="payBtn" class="btn btn-primary" value="支付宝支付"/> -->
    </p>
</div>
<div id="p_one_frame">
    <div class="p_one_window  p_one_default">
        <div class="p_one_html in">
            <div class="p_one_body">
                <div id="p_one_channelList" class="p_one_channel">

                    <?php
                          if($isWechat){
                              echo '<div p_one_channel="wx_pub" class="p_one_btn p_one_button_wx"><div class="p_one_icon_wechat">微信支付</div></div>';
                          }else {
                              echo '<div p_one_channel="alipay_pc_direct" class="p_one_btn p_one_button_alipay"><div class="p_one_icon_alipay">支付宝</div></div>';
                          }

                    ?>

                    <!-- <div p_one_channel="upacp_wap" class="p_one_btn"><div class="p_one_icon_unionpay">银联支付</div></div>
                    <div p_one_channel="yeepay_wap" class="p_one_btn"><div class="p_one_icon_yeepay">易宝支付</div></div>
                    <div p_one_channel="jdpay_wap" class="p_one_btn"><div class="p_one_icon_jdpay">京东支付</div></div>
                    <div p_one_channel="bfb_wap" class="p_one_btn"><div class="p_one_icon_baidu">百度钱包</div></div> -->
                </div>
            </div>
        </div>
    </div>
  </div>
<script>
    window.onload = function(){
        $(".p_one_btn").click(function(){
          var chanelStr = $(this).attr("p_one_channel")
          console.log(chanelStr)
          switch (chanelStr) {
            case "wx_pub":
              window.location.href = "getcode?id=<?php echo $model->id?>&channel="+chanelStr;
              break;
            default:
              window.location.href = "pay?id=<?php echo $model->id?>&channel="+chanelStr;
          }
        })

        $("#order_memo").change(function(){
          var order_memo = $(this).val();
          $.ajax({
      				type  : "POST",
      				url   : "/yx-order/update_memo",
      				dataType:"json",
      				data:{
      						"order_id":<?=  $model->id?>,
                  "order_memo":order_memo,
      				},
      				success:function(json) {
      		         console.log(json)
      				}
      		});
        })

        $("#order_memo").val("<?= $model->order_memo?>")
    }

</script>
