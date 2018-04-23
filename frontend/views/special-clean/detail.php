<?php
	use yii\helpers\Html;
	use yii\bootstrap\Tabs;

?>
<?= Html::cssFile('/static/css/detail.css') ?>

<div class="basic-detail">
	<div class="store-switch">
		<div class="store-title">
			<div class="name">
				<p><?= $YxCompany->name;?></p>
			</div>
			<div class="business">
				<p>主营业务：<?= $YxCompany->query;?></p>
			</div>
		</div>
		<div class="store-name">
			<ul>
				<li>
					<a class="active" href="#">商家详情</a>
				</li>
				<li>
					<a href="#">信息攻略</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="store-basic">
		<div class="store-info">
			<div class="img">
				<?= Html::img('/static/img/store/store1.jpg', ['alt' => '商家']) ?>
			</div>
			<div class="basic">
				<div class="name">
					<p style="font-size: 30px;"><?= $YxCompany->name;?></p>
				</div>
				<div>
					<p>ID：<?= $YxCompany->number;?></p>
				</div>
				<div style="width: 600px;height: 100px;background-color: #f5f5f5;display: flex;align-items: center;padding-left: 10px;padding-right: 10px;font-size: 18px;">
					<div style="width: 30%;">
						<div class="price">
							<p style="color: rgb(255, 90, 0);">保洁价：35元/小时</p>
						</div>
						<div class="fraction">
							<p style="color: rgb(255, 90, 0);">分数：<?= number_format($YxCompany->total_fraction/1000,1);?>分</p>
						</div>
					</div>
					<div style="width: 70%;">
						<div class="address">
							<p>地址：<?= $YxCompany->address;?></p>
						</div>

						<div class="business">
							<p>主营业务：<?= $YxCompany->query;?></p>
						</div>
					</div>
				</div>

				<div class="store-order">
					<button class="btn btn-warning"><a href="http://www.yuanxiangwu.com/order/index" style="color: #fff;">立即下单</a></button>
					<button id="reserve" class="btn btn-danger">预约服务</button>
				</div>
			</div>
		</div>

		<div class="basic-info">
			<div class="staff-other">
				<div style="text-align: center;">
					<h3>商家详情</h3>
				</div>
				<div>
					<p><b>简介：</b><?= $YxCompany->introduction;?></p>
				</div>
				<div>
					<h4><b>相似商家：</b></h4>
					<div class="other-staff">
						<img src="/static/img/staff/staff1.jpg" />
						<div>
							<h5><b>好运来家政</b></h5>
							<p title="服务、热心">服务、热心</p>
						</div>
					</div>
					<div class="other-staff">
						<img src="/static/img/staff/staff1.jpg" />
						<div>
							<h5><b>好运来家政</b></h5>
							<p title="服务、热心">服务、热心</p>
						</div>
					</div>
					<div class="other-staff">
						<img src="/static/img/staff/staff1.jpg" />
						<div>
							<h5><b>好运来家政</b></h5>
							<p title="服务、热心">服务、热心</p>
						</div>
					</div>
					<div class="other-staff">
						<img src="/static/img/staff/staff1.jpg" />
						<div>
							<h5><b>好运来家政</b></h5>
							<p title="服务、热心">服务、热心</p>
						</div>
					</div>
				</div>
			</div>

			<div class="staff-info">
				<?php
				echo Tabs::widget([
				  'items' => [
				      	[
				           	'label' => '基本信息',
				          	'content' => $this->render('detail/basic',['YxCompany'=>$YxCompany]),
				          	'active' => true
				      	],
				      	[
				          	'label' => '成果显示',
				          	'content' => $this->render('detail/comment',['YxCompany'=>$YxCompany]),
				          	// 'headerOptions' => [...],
				          	// 'options' => ['id' => 'myveryownID'],
				      	],
				      	[
				          	'label' => '评论',
				          	'content' => $this->render('detail/successful-show',['YxCompany'=>$YxCompany]),
				          	// 'url' => 'http://www.example.com',
				      	],
				  	],
				]);
				?>
			</div>
		</div>
	</div>
</div>
