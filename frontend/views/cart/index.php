<?php
	use yii\helpers\Html;
?>

<div class="cart-main">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">购物清单</h3>
		</div>
		<div class="panel-body">
			<table class="table">
		        <thead>
		        	<tr>
		        		<th><input type="checkbox" name=""></th>
		        		<th>服务名</th>
		        		<th>单价</th>
		        		<th>数量</th>
		        		<th>小计</th>
		        	</tr>
		        </thead>
		        <tbody>
		        	<tr>
		        		<td><input type="checkbox" name=""></td>
			        	<td>搽玻璃</td>
			        	<td>200</td>
			        	<td>1</td>
			        	<td>200</td>
			        </tr>
			        <tr>
			        	<td><input type="checkbox" name=""></td>
				        <td>月嫂</td>
				        <td>400</td>
				        <td>2</td>
			        	<td>200</td>
			        </tr>
		        </tbody>
		    </table>
		</div>
	</div>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">服务地址</h3>
		</div>
		<div class="panel-body">
			<ul>
				<li>
					<label for="dizhi-big" class="address">选择地址：</label>
					<select id="dizhi" class="addressinput" style="height: 22px;">
						<option>深圳市南山区</option>
						<option>深圳市宝安区</option>
						<option>深圳市罗湖区</option>
						<option>深圳市福田区</option>
						<option>深圳市龙华区</option>
					</select>
				</li>
				<li>
					<label for="dizhi-detailed" class="address">详细地址：</label>
					<input id="dizhi-detailed" class="addressinput" type="text" />
				</li>
				<li>
					<label for="client" class="address">客户：</label>
					<input id="client" class="addressinput" type="text" />
				</li>
				<li>
					<label for="phone" class="address">手机号码：</label>
					<input id="phone" class="addressinput" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />
				</li>
				<li style="color: #e9203d;">以上属于必填信息</li>
			</ul>
		</div>
	</div>

	<div class="panel panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">支付方式</h3>
		</div>
		<div class="panel-body">
			<input class="paytype" type="radio" name="paytype" id="zhifubao" checked><label for="zhifubao">支付宝</label><br/>
			<input class="paytype" type="radio" name="paytype" id="weixin"><label for="weixin">微信</label>
		</div>
	</div>

	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title">订单结算</h3>
		</div>
		<div class="panel-body">
			<div>
				<label for="total">总计：</label>
				<i id="total" style="color: #e9203d;font-size: 25px;">2000.00</i>
				<span>元</span>
			</div>
			<div style="float: right;margin-right: 10px;">
				<button class="btn btn-danger">提交订单</button>
			</div>
		</div>
	</div>

</div>
<?=
	Html::style('
		.cart-main {
			margin-top: 50px;
		}
		.cart-main .paytype {
			position: relative;
		    top: 3px;
		    margin-right: 4px;
		}
		.address {
			width: 80px;
		}
		.addressinput {
			width: 200px;
		}
	')
?>

