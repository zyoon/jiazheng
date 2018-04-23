<?php
	use yii\helpers\Html;
	use yii\bootstrap\Tabs;
	use common\models\YxStaff;
	use common\models\YxServer;
	use common\models\YxStaffServer;
	date_default_timezone_set('PRC');
?>
<?= Html::cssFile('/static/css/staff.css') ?>

<div class="staff-detail">
	<div class="detail-cart">
		<div class="img">
			<img src="/static/img/staff/staff1.jpg">
		</div>
		<div class="detail">
			<h3 id="staff_id" staff_id="<?= $YxStaff->staff_id;?>"><?= $YxStaff->staff_name;?></h3>
			<h5>ID： <span><?= $YxStaff->staff_number;?></span></h5>
			<div class="detail-header">
				<div class="detail-header-left">
					<div class="price">
						<p>价格：<span id="order_money" style="color: rgb(255, 90, 0);"><?= number_format($serverPrice/100,2);?></span>元/<?=$serverUnit;?></p>
					</div>
					<div class="fraction">
						<p>分数：<span style="color: rgb(255, 90, 0);"><?= number_format($YxStaff->staff_fraction,2);?></span>分</p>
					</div>
					<div class="service">
						<p>服务：<select class="server-price" id="order_server">
							<?php foreach ($dataProvider as $key => $value): ?>
								<option class="server-name" value="<?=$value['server_id']?>" price-data="<?=number_format($value['server_price']/100,2)?>"
									<?php if($serverId==$value['server_id']){
										echo 'selected';
									}?>><?= YxServer::getServerName($value['server_id'])?>
								</option>
							<?php endforeach; ?>
						</select></p>
					</div>
				</div>
				<div class="detail-header-right">
					<div class="IDcard">
						<p>身份证：<?= $YxStaff->staff_idcard;?></p>
					</div>
					<div class="row age-sex">
						<p class="col-md-6 col-lg-6">年龄：<?= date("Y")-date("Y",$YxStaff->staff_age);?>岁</p>
						<p class="col-md-6 col-lg-6">性别：
							<?php if($YxStaff->staff_sex==1) {
									echo '男';
							}else {
								 	echo '女';
							}?>
						</p>
					</div>
					<div class="addre">
						<p>籍贯：<?= $YxStaff->staff_address;?></p>
					</div>
				</div>
			</div>

			<!-- 附加服务内容 -->
			<?php echo $serverAdd;?>
			<!-- 时间表 -->
			<div style="margin: 5px;">
				<div class="date-hour">
					<div class="date-all">
						<i>上门时间：</i>
						<select id="order_day" style="height:25px;margin-right:10px;">
							<?php
								for ($i=0; $i < 7; $i++) {
									echo '<option data-sub="'.$i.'" value="'.strtotime(date('Y-m-d',strtotime("+$i day"))).'">'.date('Y-m-d',strtotime("+$i day")).' '.YxStaff::getChineseWeek(date("w",strtotime("+$i day"))).'</option>';
								}
							?>
						</select>
					</div>

					<div class="hour-no" style="margin-top: 10px;">
						<span>上门时间：</span>
						<select id="hour-time">

						</select>
					</div>
					<div class="hour-no" style="margin-top: 10px;">
						<span>服务：</span>
						<input type="number" id="hour-count" style="width:50px;" value="1" step="1" min="1" />
						<span><?=$serverUnit;?></span>
					</div>
					<div class="hour-is" style="margin-top: 10px;">
						<button class="btn btn-defaul">可选</button>
						<button class="btn btn-danger">已选</button>
						<div class="hour-all row" id="time_unit_list">
						</div>
					</div>

				</div>
			</div>
			<!-- 下单、预约 -->
			<div style="margin: 5px;">
				<button id="order_button" class="btn btn-danger" style="padding: 10px 40px;" onclick="makeOrderBefor()">立即下单</button>
				<?php if (YxServer::getReserve($serverId)==1) {
					echo '<button id="reserve" class="btn btn-warning" style="padding: 10px 40px;">预约</button>';
				}?>
			</div>

		</div>
	</div>
	<div class="detail-info">
		<div class="staff-info">
			<div style="text-align: center;">
				<h3 style="margin: 13px 0;">商家详情</h3>
			</div>
			<div>
				<p><b>简介：</b>本公司是一个拥有上千优秀的服务人员，一直本着服务的态度而立足于行业中。</p>
			</div>
			<div>
				<h4><b>原象推荐：</b></h4>
				<?php foreach ($YxStaffArr as $value): ?>
					<div class="other-staff">
						<img src="<?= $value['staff_img']?>" alg="yuanxiang"/>
						<div class="other-staff-info">
							<h5><a href="/staff/index?staff_id=<?= $value['staff_id'] ?>"><?= $value['staff_name']?></a></h5>
							<p title="<?= $value['staff_intro']?>"><?= $value['staff_intro']?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="staff-comment">
			<?php
				echo Tabs::widget([
				  'items' => [
				      	[
				           	'label' => '基本信息',
				          	'content' => $this->render('detail/basic-info',['YxStaff'=>$YxStaff]),
				          	'active' => true
				      	],
				      	[
				          	'label' => '成果显示',
				          	'content' => $this->render('detail/successful-show',['YxStaff'=>$YxStaff]),
				      	],
				      	[
				          	'label' => '评论',
				          	'content' => $this->render('detail/comment',['comment'=>$comment]),
				      	],
				  	],
			]);
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
	var yx_staff_id = <?= $YxStaff->staff_id;?>;
	var yx_company_id = <?= $YxStaff->company_id;?>;
	var server_unit = '<?= YxStaffServer::getServerUnit($serverId);?>';
	var order_type = 2;
	function makeOrderBefor(){
		var order_server = Number($("#order_server").val());
		var order_day = Number($("#order_day").val());
		var time_unit = [];
		if(isNaN(order_server) || order_server <=0){
			alert("请选择服务~");
			return;
		}
		if(isNaN(order_day) || order_day <=0){
			alert("请选择服务日期~");
			return;
		}
		if(server_unit == "小时") {
			if(!checkTimeSuccessive()){
				return;
			}
			var time_unit_arr = $("#time_unit_list .selected");
			for (var i = 0; i < time_unit_arr.length; i++) {
					time_unit.push(Number($(time_unit_arr[i]).attr("date-time")));
			}
			// 开始时间戳
			var start_time = order_day + time_unit_arr.length*3600;
			// 服务时间
			var amount = time_unit_arr.length;
		}else {
			var hourTime = Number($("#hour-time").find("option:selected").val());
			// 开始时间戳
			var start_time = order_day + hourTime*3600;
			// 服务时间
			var amount = Number($("#hour-count").val());
		}
		// 附加服务
		var extra_server = [];
		var addServer = $(".one-server");
		var server_num,server_seleced;
		for (var i = 0; i < addServer.length; i++) {
			server_seleced = $(addServer[i])[0].querySelector("input");
			server_num = $(addServer[i])[0].querySelector('.server_num input');
			if(server_seleced.checked){
				extra_server.push({
				    'id':server_num.getAttribute('serverid'),
				    'amount':server_num.value
				})
			}
		}
		console.log(order_server);
		console.log(yx_company_id);
		console.log(start_time);
		console.log(amount);
		console.log(extra_server);
		$.ajax({
				type  : "POST",
				url   : "/yx-order/create",
				dataType:"json",
				data:{
						"order_server":order_server,
						"yx_company_id":yx_company_id,
						"yx_staff_id":yx_staff_id,
						"start_time":start_time,
						"amount":amount,
						"extra_server":extra_server,
						"order_type":order_type
				},
				success:function(json) {
					if(json.code == -1){
						if(typeof json.msg == "string"){
							alert(json.msg);
						}else {
							for (var i = 0; i < json.msg.length; i++) {
								alert(json.msg[i]);
							}
						}
					}else {
							window.location.href = "/yx-order/payment?id=" + json.order_id;
					}
				}
		});
	}
	function checkTimeSuccessive(){
			var time_unit_arr = $("#time_unit_list .selected");
			if(time_unit_arr.length < 1){
				alert("请选择服务时长~");
				return false;
			}
			for (var i = 0; i < time_unit_arr.length; i++) {
				var new_time_unit = Number($(time_unit_arr[i]).attr("date-time"));
				if(i > 0){
					if(new_time_unit != last_time_unit + 1){
						alert("请选择连续的服务时长");
						return false;
					}
				}
				last_time_unit = new_time_unit
			}
			return true;
	}
	window.onload = function() {
		$(".server-price").change(function() {
			// 根据选择服务显示价格
			window.location.href = "/staff/index?staff_id="+$("#staff_id").attr('staff_id')+"&server_id="+$(".server-price option:selected").attr('value');
		});

		$("#reserve").click(function() {
			order_type = 3;
			makeOrderBefor();
		})

		// 显示发送当天的时间戳，得到当天的各个小时的状态
		function getHourAll(dayTime){
			if(server_unit == "小时") {
				var listDom = $("#time_unit_list");
				$('.hour-no').css("display","none");
				listDom.html("");
				$.ajax({
						type  : "POST",
						url   : "/staff/get_staff_times",
						dataType:"json",
						data:{"dayTime":dayTime},
						success:function(json) {
								var time_datas = json.time_datas;
								for(let i = 7,j = 0;i < 23;i++,j++) {
									if(time_datas[i] == 0) {
										listDom.append(
														'<div class="hour-one col-md-3 col-lg-3">'+
																'<button class="btn btn-danger disabled hour-one-button" date-time="'+i+'" disabled="disabled" onclick="changeTimeUnitBtn(this)">'+returnNum(i)+'点-'+returnNum(i+1)+'点</button>'+
														'</div>'
										)
									}else {
										listDom.append(
														'<div class="hour-one col-md-3 col-lg-3">'+
																'<button class="btn btn-default hour-one-button" date-time="'+i+'" data-choosed="0" onclick="changeTimeUnitBtn(this)">'+returnNum(i)+'点-'+returnNum(i+1)+'点</button>'+
														'</div>'
										)
									}
								}
						}
				});
			}else {
				$('.hour-is').css("display","none");
				// 找到当前的时间（小时）
				var myDate = new Date();
				var hour = myDate.getHours();
				// 具体时间（小时）select
				var hourTime = $("#hour-time");
				hourTime.html("");
				// 日期select
				var dataSub = $('#order_day').find("option:selected").attr('data-sub');
				if(dataSub == 0) {
					for (var i = 8; i < 22; i++) {
						if(i > hour) {
							hourTime.append('<option value="'+i+'">'+i+':00</option>')
						}
					}
				}else {
					for (var i = 8; i < 22; i++) {
						hourTime.append('<option value="'+i+'">'+i+':00</option>')
					}
				}
			}
		}
		getHourAll($("#order_day").val(),yx_staff_id);
		// 切换时间查看每天各个小时的状态
		$("#order_day").change(function(){
			var dayTime = $(this).val();
			getHourAll(dayTime,yx_staff_id);
		})
		// 选择时间
		// $(".hour-one-button").click(function(){
		// 	if (this.getAttribute('class') == 'btn btn-default hour-one-button') {
		// 		this.setAttribute('class', 'btn btn-danger selected hour-one-button');
		// 	}else {
		// 		this.setAttribute('class', 'btn btn-default hour-one-button');
		// 	}
		// })

	}
	function changeTimeUnitBtn(btnDom){
			console.log($(btnDom).attr('data-choosed'))
			if ($(btnDom).attr('data-choosed') == "0"){
					$(btnDom).attr('class', 'btn btn-danger selected hour-one-button');
					$(btnDom).attr('data-choosed', '1');
			}else {
					$(btnDom).attr('class', 'btn btn-default hour-one-button');
					$(btnDom).attr('data-choosed', '0');
					$(btnDom).blur()
			}
	}
	function returnNum(num){
			if(num >= 10) return num;
			return "0"+num;
	}
</script>
