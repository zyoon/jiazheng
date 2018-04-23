<?php
	use yii\helpers\Html;
	use yii\widgets\LinkPager;
  use common\models\YxServer;
  use common\models\YxStaff;
	use common\models\YxStaffServer;
  use common\models\YxCmpServer;
	$sortText = '排序';
?>

<?= Html::cssFile('/static/css/store.css') ?>

<div class="store-detail">
	<div class="store-info">
		<div style="text-align: center;">
			<h3>商家详情</h3>
		</div>
		<div>
			<p><b>简介：</b>本公司是一个拥有上千优秀的服务人员，一直本着服务的态度而立足于行业中。</p>
		</div>
		<div>
			<h4><b>原象推荐：</b></h4>
			<?php foreach ($recommendArr as $value): ?>
				<div class="other-store">
					<img src="/static/img/staff/staff1.jpg" />
					<div class="other-store-info">
						<h5><a href="/company/staff?company=<?= $value['id'] ?>" title="<?= $value['name'] ?>"><?= $value['name'] ?></a></h5>
						<p title="<?= $value['introduction'] ?>"><?= $value['introduction'] ?></p>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
	<div class="store-pro">
		<div class="store-condition">
			<div class="condition-row">
				<div class="condition-inner">
					<div class="condition-left">
					</div>
					<div class="condition-right">
						<ul>
							<li class="active">
                <a href="#">商家详情</a>
              </li>
							<li>
                <?php
										echo '<a href="/company/staff?server_id='.$serverId.'&company_id='.$companyId.'&sort=fraction" class="header-title">服务者</a>';
								?>
							</li>
							</li>
							<li>
								<a href="#">信息攻略</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="select-server">
				<div class="selector-child">
					服务类型：
					<select class="server-type" style="width:100px;height:25px;">
						<?php foreach ($CompanyServerAll as $key => $value) {
							if ($serverId == $key) {
								echo '<option value="'.$key.'" title="'.$value.'" selected>'.$value.'</option>';
							}else {
								echo '<option value="'.$key.'" title="'.$value.'">'.$value.'</option>';
							}
						}?>
					</select>
				</div>
			</div>
		</div>


		<div class="company-info">
    	<div class="company-image-text">
    			<div class="img">
    				<?= Html::img('/static/img/store/store1.jpg', ['alt' => '商家']) ?>
    			</div>
    			<div class="company-detail">
    				<div class="name">
    					<p style="font-size: 30px;"><?= $YxCompany->name;?></p>
    				</div>
    				<div>
    					<p>ID：<?= $YxCompany->number;?></p>
    				</div>
    				<div class="company-detail-text">
    					<div class="first-child">
    						<div class="price">
    							<p>价格：<?= number_format(YxCmpServer::getCompanyPrice($companyId,$serverId)/100,2);?>元/<?=YxStaffServer::getServerUnit($serverId)?></p>
    						</div>
    						<div class="fraction">
    							<p>分数：<?= number_format($YxCompany->total_fraction,2);?>分</p>
    						</div>
    						<div class="server">
    							<p id="server-id" date-id="<?=$serverId?>">服务：<?=YxServer::getServerName($serverId)?></p>
    						</div>
    					</div>
    					<div class="second-child">
    						<div class="business">
    							<p title="主营业务：<?= $YxCompany->query;?>">主营业务：<?= $YxCompany->query;?></p>
    						</div>

    						<div class="address">
    							<p title="地址：<?= $YxCompany->address;?>">地址：<?= $YxCompany->address;?></p>
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
    										echo '<option value="'.strtotime(date('Y-m-d',strtotime("+$i day"))).'">'.date('Y-m-d',strtotime("+$i day")).' '.YxStaff::getChineseWeek(date("w",strtotime("+$i day"))).'</option>';
    									}
    								?>
    							</select>
    							<button class="btn btn-defaul">可选</button>
    							<button class="btn btn-danger">已选</button>
    						</div>
    						<div class="hour-all row" id="time_unit_list">
    						</div>
    					</div>
    				</div>
    				<!-- 下单、预约 -->
    				<div class="store-order">
    					<button id="order_button" class="btn btn-danger" style="padding: 10px 40px;" onclick="makeOrderBefor()">立即下单</a></button>
    					<?php if (YxServer::getReserve($serverId)==1) {
    						echo '<button id="reserve" class="btn btn-warning" style="padding: 10px 40px;">预约</button>';
    					}?>
    				</div>
    			</div>
    		</div>
		</div>
	</div>
</div>

<?= Html::style('
	.company-info {
		margin-top: 20px;
	}
  .hour-all.row {
    margin: 0px;
  }
  .hour-all.row .hour-one {
    margin-bottom: 10px;
    padding: 0;
  }
') ?>

<script type="text/javascript">
	var yx_company_id = <?= $companyId;?>;
	var order_server = <?= $serverId;?>;
	function makeOrderBefor(){
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
		if(!checkTimeSuccessive()){
			return;
		}
		var time_unit_arr = $("#time_unit_list .selected");
		for (var i = 0; i < time_unit_arr.length; i++) {
				time_unit.push(Number($(time_unit_arr[i]).attr("date-time")));
		}
		console.log(" 服务  order_server : "+order_server);
		console.log(" 服务日期  order_day : "+order_day);
		console.log(" 服务时长  time_unit : ");
		console.log(time_unit);
		$.ajax({
				type  : "POST",
				url   : "/yx-order/create",
				dataType:"json",
				data:{
						"order_server":order_server,
						"yx_company_id":yx_company_id,
						"dayTime":order_day,
						"time_unit":time_unit,
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
		// 切换服务
		var companyId = <?=$companyId?>;
		$(".server-type").change(function() {
			// 根据选择服务显示服务人员
			console.log("hell");
			window.location.href = "/company/index?server_id="+$(".server-type").val()+"&company_id="+companyId+"&sort=fraction";
		});

		$("#reservation").click(function() {
			alert("预约");
		})

		// 显示发送当天的时间戳，得到当天的各个小时的状态
		function getHourAll(dayTime){
			var listDom = $("#time_unit_list");
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
		}
		getHourAll($("#order_day").val());
		// 切换时间查看每天各个小时的状态
		$("#order_day").change(function(){
			var dayTime = $(this).val();
			getHourAll(dayTime);
		})

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
