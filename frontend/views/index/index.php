<?php
	use yii\helpers\Html;
	use yii\bootstrap\Carousel;
	use yii\bootstrap\Tabs;
?>
<!-- 二级菜单、轮播、登陆 -->
<?= Html::cssFile('/static/css/index.css') ?>
<div class="container_header">
	<div class="header_left">
		<nav>
			<ul>
				<li>
					<a href="/other-services/index?server_parent=71&server_id=72&sort=fraction" target="_blank" title="保姆">保姆</a> / <a href="/basic-clean/index?server_parent=65&server_id=74&sort=fraction" target="_blank" title="擦玻璃">擦玻璃</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=69&server_id=82&sort=fraction"  target="_blank" title="月嫂">月嫂</a> / <a href="/basic-clean/index?server_parent=65&server_id=73&sort=fraction"  target="_blank" title="长期钟点工">长期钟点工</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=70&server_id=83&sort=fraction"  target="_blank" title="育儿嫂">育儿嫂</a> / <a href="/other-services/index?server_parent=66&server_id=81&sort=fraction"  target="_blank" title="卫生间保养">卫生间保养</a>
				</li>
				<li>
					<a href="/basic-clean/index?server_parent=65&server_id=20&sort=fraction" target="_blank" title="基础保洁">基础保洁</a> / <a href="/special-clean/index?server_parent=66&server_id=34&sort=fraction"  target="_blank" title="厨房保养">厨房保养</a>
				</li>
				<li>
					<a href="/special-clean/index?server_parent=66&server_id=78&sort=fraction"  target="_blank" title="深度保洁">深度保洁</a> / <a href="/special-clean/index?server_parent=66&server_id=87&sort=fraction"  target="_blank" title="开荒保洁">开荒保洁</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=68&server_id=75&sort=fraction"  target="_blank" title="沙发保养">沙发保养</a> / <a href="/other-services/index?server_parent=14&server_id=39&sort=fraction"  target="_blank" title="地板打蜡">地板打蜡</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=67&server_id=29&sort=fraction"  target="_blank" title="空调清洗">空调清洗</a> / <a href="/other-services/index?server_parent=90&server_id=47&sort=fraction"  target="_blank" title="空调维修">空调维修</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=67&server_id=28&sort=fraction"  target="_blank" title="冰箱清洗">冰箱清洗</a> / <a href="/other-services/index?server_parent=90&server_id=50&sort=fraction"  target="_blank" title="冰箱维修">冰箱维修</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=90&server_id=48&sort=fraction"  target="_blank" title="马桶维修">马桶维修</a> / <a href="/other-services/index?server_parent=90&server_id=45&sort=fraction"  target="_blank" title="管道疏通">管道疏通</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=67&server_id=22&sort=fraction"  target="_blank" title="灶台清洗">灶台清洗</a> / <a href="/other-services/index?server_parent=90&server_id=56&sort=fraction"  target="_blank" title="电路维修">电路维修</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=91&server_id=57&sort=fraction"  target="_blank" title="普通门开锁">普通门开锁</a> / <a href="/other-services/index?server_parent=67&server_id=23&sort=fraction"  target="_blank" title="热水器清洗">热水器清洗</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=91&server_id=58&sort=fraction"  target="_blank" title="普通门换锁">普通门换锁</a> / <a href="/other-services/index?server_parent=90&server_id=52&sort=fraction"  target="_blank" title="热水器维修">热水器维修</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=67&server_id=21&sort=fraction"  target="_blank" title="油烟机清洗">油烟机清洗</a> / <a href="/other-services/index?server_parent=90&server_id=51&sort=fraction"  target="_blank" title="油烟机维修">油烟机维修</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=67&server_id=27&sort=fraction"  target="_blank" title="洗衣机清洗">洗衣机清洗</a> / <a href="/other-services/index?server_parent=90&server_id=53&sort=fraction"  target="_blank" title="洗衣机维修">洗衣机维修</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=67&server_id=25&sort=fraction"  target="_blank" title="微波炉清洗">微波炉清洗</a> / <a href="/other-services/index?server_parent=90&server_id=54&sort=fraction"  target="_blank" title="微波炉维修">微波炉维修</a>
				</li>
				<li>
					<a href="/other-services/index?server_parent=67&server_id=30&sort=fraction"  target="_blank" title="饮水机清洗">饮水机清洗</a> / <a href="/other-services/index?server_parent=90&server_id=55&sort=fraction"  target="_blank" title="电视机维修">电视机维修</a>
				</li>
			</ul>
		</nav>
	</div>
	<div class="header_center1">
		<div class="header_center1_top">
			<?php echo Carousel::widget([
			    'items' => [
			        [
			        	'content' => '<a href="#"><img src="'.$YxBanner[0]->banner_pic.'" /></a>',
			        	'caption' => '',
			        ],
			        [
			        	'content' => '<a href="#"><img src="'.$YxBanner[1]->banner_pic.'" /></a>',
			        	'caption' => '',
			        ],
			        [
			            'content' => '<a href="#"><a href="#"><img src="'.$YxBanner[2]->banner_pic.'" /></a>',
			            'caption' => '',
			            //'options' => ['style:height:600px,width:1200px'],       //配置对应的样式
			        ],
			        [
			            'content' => '<a href="#"><img src="'.$YxBanner[3]->banner_pic.'" /></a>',
			            'caption' => '',
			        ],
			    ]
			]);
		    ?>
		</div>
		<div class="header_center1_bottom">
			<div class="banner_text">
				<span>原象屋精选</span>
			</div>
			<div class="banner_img">
				<a href="/other-services/index?server_parent=71&sort=fraction" target="_blank"><img src="<?= $YxRecomLeft[0]->recom_left_pic; ?>"></a>
				<a href="/basic-clean/index?server_parent=65&sort=fraction" target="_blank"><img src="<?= $YxRecomLeft[1]->recom_left_pic; ?>"></a>
				<a href="/other-services/index?server_parent=69&sort=fraction" target="_blank"><img src="<?= $YxRecomLeft[2]->recom_left_pic; ?>"></a>
				<a href="/other-services/index?server_parent=70&sort=fraction" target="_blank"><img src="<?= $YxRecomLeft[3]->recom_left_pic; ?>"></a>
			</div>
		</div>
	</div>
	<div class="header_center2">
		<div class="banner1">
			<a href="/other-services/index?server_parent=71&sort=fraction" target="_blank"><img src="<?= $YxActivity->activity_pic; ?>" /></a>
		</div>
		<div class="banner_text">
			<span>今日推荐</span>
		</div>
		<div class="banner2">
			<a href="/other-services/index?server_parent=68&sort=fraction" target="_blank"><img src="<?= $YxRecomRight->recom_right_pic; ?>" /></a>
		</div>
	</div>
	<div class="header_right">
			<?php
				if (Yii::$app->user->isGuest) {
					echo '<div class="login">
						    	<div>
						    		<img src="/static/img/yks.jpg" style="width:80px;height:80px;border-radius: 50%;" />
						    	</div>
						    	<div class="buttons">
					            <button class="btn btn-info" style="padding: 1.5px 30px;"><a href="/site/signup" class="header-title" style="color:#fff;font-size:14px;">注册</a></button>
						    			<button class="btn btn-info" style="padding: 1.5px 22.5px;"><a href="/site/login" class="header-title" style="color:#fff;font-size:14px;">登录</a></button>
						    			<button class="btn btn-warning" style="padding: 1.5px 22.5px;">入驻</button>
						    	</div>
						    </div>';
				}else {
					echo '<div class="login">
						    	<div>
						    		<img src="/static/img/yks.jpg" style="width:80px;height:80px;border-radius: 50%;" />
						    	</div>
						    	<div class="buttons">

						    	</div>
						    </div>';
				}
			?>

	    <div class="switch">
	    	<?php
				echo Tabs::widget([
				  'items' => [
				      	[
				           	'label' => '规则',
				          	'content' => '<div class="tabs" style="height: 88px;border-bottom: 1px solid #eee;display: flex;flex-direction: column;align-items: center;justify-content: center;">
				          			<div>
				          				<a href="#" style="color:rgb(255, 90, 0);text-decoration:none;">《原象屋平台服务协议》</a>
				         				<a href="#"style="color:rgb(255, 90, 0);text-decoration:none;">《常见问题》</a>
				          			</div>
				         			<div style="margin-top:5px;margin-bottom:5px;">
				         				<a href="#" style="color:#3C3C3C;text-decoration:none;">《第三方家庭服务协议》</a>
				         				<a href="#" style="color:#3C3C3C;text-decoration:none;">《服务协议》</a>
				         			</div>
				         			<div>
				         				<a href="#" style="color:#3C3C3C;text-decoration:none;">《法律声明及隐私权政策》</a>
				         				<a href="#" style="color:#3C3C3C;text-decoration:none;">《退款条约》</a>
				         			</div>
				         		</div>',
				          	'active' => true
				      	],
				      	[
				          	'label' => '公告',
				          	'content' => '<div class="tabs" style="height: 88px;border-bottom: 1px solid #eee;">

				         			</div>',
				      	],
				      	[
				          	'label' => '安全',
				          	'content' => '<div class="tabs" style="height: 88px;border-bottom: 1px solid #eee;">

				         			</div>',
				      	]
				  	],
			]);
			?>
		</div>
		<div class="server-icon">
			<div class="server-one">
				<img src="/static/img/icon/1.png">
				<a href="/basic-clean/index?server_parent=65&sort=fraction" target="_blank" title="日常保洁">日常保洁</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/2.png">
				<a href="/other-services/index?server_parent=69&sort=fraction" target="_blank" title="月嫂">月嫂</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/3.png">
				<a href="/other-services/index?server_parent=70&sort=fraction" target="_blank" title="育儿嫂">育儿嫂</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/4.png">
				<a href="/basic-clean/index?server_parent=66&server_id=36&sort=fraction" target="_blank" title="擦玻璃">擦玻璃</a>
			</div>

			<div class="server-one">
				<img src="/static/img/icon/5.png">
				<a href="/other-services/index?server_parent=71&sort=fraction" target="_blank" title="保姆">保姆</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/6.png">
				<a href="/other-services/index?server_parent=90&server_id=45&sort=fraction" target="_blank" title="管道疏通">管道疏通</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/7.png">
				<a href="/other-services/index?server_parent=90&server_id=88&sort=fraction" target="_blank" title="家电维修">家电维修</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/8.png">
				<a href="/special-clean/index?server_parent=66&sort=fraction" target="_blank" title="专项保洁">专项保洁</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/9.png">
				<a href="/special-clean/index?server_parent=66&server_id=89&sort=fraction" target="_blank" title="沙发护理">沙发护理</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/10.png">
				<a href="/other-services/index?server_parent=91&server_id=58&sort=fraction" target="_blank" title="普通门换锁">普通门换锁</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/11.png">
				<a href="/other-services/index?server_parent=90&sort=fraction" target="_blank" title="维修">维修</a>
			</div>
			<div class="server-one">
				<img src="/static/img/icon/12.png">
				<a href="/other-services/index?server_parent=14&server_id=39&sort=fraction" target="_blank" title="地板打蜡">地板打蜡</a>
			</div>
		</div>
	</div>
</div>
<!-- 精选服务 -->
<div class="popular_server">
	<div class="featured">
		<h3>精选服务</h3>
		<!-- <h5>
			<a href="#" style="color: rgb(255, 90, 0);">更多</a>
		</h5> -->
	</div>
	<!-- 服务人员 -->
	<div class="rows">
		<?php foreach ($YxStaff as $item): ?>
			<div class="store">
				<div class="store_one">
					<div class="img" style="text-align: center;">
						<img src="<?= $item->staff_img?>" class="img-thumbnail" alt="Yuanxiang"/>
					</div>
					<div class="name">
						<h4 title="<?= $item->staff_name ?>"><?= $item->staff_name ?></h4>
						<h4 title="分数：<?= $item->staff_fraction ?>">分数：<?= $item->staff_fraction ?></h4>
						<p title="简介：<?= $item->staff_intro?>">简介：<?= $item->staff_intro?></p>
					</div>
					<div class="detail">
						<div class="pop-ups">
							<a href="/staff/index?staff_id=<?= $item->staff_id?>" target="_blank">查看详情</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<!-- 精选商家 -->
<div class="popular_server">
	<div class="featured">
		<h3>精选商家</h3>
		<!-- <h5>
		     <a href="#" style="color: rgb(255, 90, 0);">更多</a>
		</h5> -->
	</div>
	<!-- 商家 -->
	<div class="rows">
		<?php foreach ($YxCompany as $item): ?>
			<div class="store">
				<div class="store_one">
					<div class="img">
						<img src="<?= $item->business_licences?>" class="img-thumbnail" alt='Yuanxiang' />
					</div>
					<div class="name">
						<h4 title="<?= $item->name ?>"><?= $item->name ?></h4>
						<h4 title="分数：<?= $item->total_fraction ?>">分数：<?= $item->total_fraction ?></h4>
						<p title="简介：<?= $item->introduction?>">简介：<?= $item->introduction?></p>
					</div>
					<div class="detail">
						<div class="pop-ups">
							<a href="/company/staff?company_id=<?= $item->id?>" target="_blank">查看详情</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<script type="text/javascript">
	window.onload = function() {
		$(".store").mouseenter(function(){
	  	this.querySelector(".detail").style.display = "block";
	  });
	  $(".store").mouseleave(function(){
	  	this.querySelector(".detail").style.display = "none";
	  });
	}
</script>
