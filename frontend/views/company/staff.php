<?php
	use yii\helpers\Html;
	use yii\widgets\LinkPager;
	use common\models\YxStaff;
	use common\models\YxStaffServer;
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
					<img src="<?= $value['staff_img']?>" alg="yuanxiang"/>
					<div class="other-store-info">
							<h5><a href="/staff/index?staff_id=<?= $value['staff_id'] ?>"><?= $value['staff_name']?></a></h5>
							<p title="<?= $value['staff_intro']?>"><?= $value['staff_intro']?></p>
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
						<ul>
							<li class="<?php if($sort == 'fraction'){
								echo "active";
								}?>">
								<a href="?server_id=<?= $serverId?>&company_id=<?= $companyId?>&sort=fraction">分数<?php if($sort == 'fraction'){
										echo $sortText;
								}?></a>
							</li>
							<li class="<?php if($sort == 'price'){
								echo "active";
								}?>">
								<a href="?server_id=<?= $serverId?>&company_id=<?= $companyId?>&sort=price">价格<?php if($sort == 'price'){
										echo $sortText;
								}?></a>
							</li>
						</ul>
					</div>
					<div class="condition-right">
						<ul>
							<li>
								<?php
										echo '<a href="/company/index?server_id='.$serverId.'&company_id='.$companyId.'&sort=fraction" class="header-title">商家详情</a>';
								?>
							</li>
							<li class="active">
								<a href="#">服务者</a>
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


		<div class="content">
			<div class="row">
				<?php foreach ($models as $model): ?>
				<div class="staff col-xs-3 col-sm-3">
					<div class="staff-one">
						<div class="img">
							<img class="img-thumbnail" src="<?= $model->staff_img ?>" >
						</div>
						<h3 title="<?= $model->staff_name ?>"><?= $model->staff_name ?></h3>
						<p title="价格: <?= YxStaffServer::getStaffPrice($model->staff_id,$serverId) ?>">价格: <?= YxStaffServer::getStaffPrice($model->staff_id,$serverId) ?>元</p>
						<p title="分数: <?= $model->staff_fraction ?>">分数: <?= $model->staff_fraction ?></p>
						<p title="主营业务: <?= YxStaff::getServerName($model->staff_id) ?>" class="staff-servers">主营业务: <?= YxStaff::getServerName($model->staff_id) ?></p>
						<div class="staff-info">
							<a href="/staff/index?staff_id=<?= $model->staff_id ?>" target="_blank">查看详情</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="page">
			<?php echo LinkPager::widget([
				'pagination' => $pages,
				'nextPageLabel' => '下一页',
				'prevPageLabel' => '上一页',
				'firstPageLabel' => '首页',
		     'lastPageLabel' => '尾页'
			])?>
		</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var companyId = <?=$companyId?>;
	window.onload = function() {
		$(".server-type").change(function() {
			// 根据选择服务显示服务人员
			window.location.href = "/company/staff?server_id="+$(".server-type").val()+"&company_id="+companyId+"&sort=fraction";
		});
		// 鼠标移动到用户变色
		$(".staff-one").mouseenter(function(){
			$(this).addClass("active");
			$(this).find(".staff-info").addClass("block");
	  });
	  $(".staff-one").mouseleave(function(){
			$(this).removeClass("active");
			$(this).find(".staff-info").removeClass("block");
	  });
	}
</script>
