<?php
	use yii\helpers\Html;
?>
<?= Html::cssFile('/static/css/order.css') ?>

<div class="order-detail">
	<div class="address child">
		服务地址：<span>深圳市福田区招财路59号幸福小区5号楼502</span>
		<a href="#" style="margin-left: 20px;">修改</a>
	</div>
	<div class="detail child">
		<div>服务项目：<span>日常保洁</span></div>
		<div>服务公司：<span>好运来家政</span></div>
		<div>上门时间：<span>2018年5月22日（周日）14：00</span></div>
		<div>服务时长：<span>2小时</span></div>
		<div>服务明细：<span>日常保洁：32元×2小时=64元</span></div>
		<div>擦玻璃：<span>64</span>元</div>
	</div>
	<div class="instructions child">
		距服务开始超过4小时取消订单，不会扣除您的预付款。据服务开始超过2小时不足4小时取消订单，将扣除您预付款的20%。距服务开始不足2小时取消订单将扣除您预付款的50%。其余部分将原路返回到您的支付账户。
	</div>
	<div class="money-pay">
		<div class="money">合计：<span>64</span>元</div>
		<div class="pay">
			<button class="btn btn-primary" style="background-color: rgb(255, 90, 0);border-color: rgb(255, 90, 0);">支付</button>
		</div>
	</div>
</div>