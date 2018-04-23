<?php
	use yii\helpers\Html;
	use common\models\YxStaff;
?>

<div class="tabs">
  <table class="table table-bordered">
		<tbody>
			<tr>
			  <td class="title-name">姓名</td>
			  <td><?= $YxStaff->staff_name;?></td>
			</tr>
			<tr>
			  <td class="title-name">性别</td>
			  <td><?php echo YxStaff::getCmpSexName($YxStaff->staff_sex); ?></td>
			</tr>
			<tr>
			  <td class="title-name">年龄</td>
			  <td><?= date("Y")-date("Y",$YxStaff->staff_age);?>岁</td>
			</tr>
			<tr>
			  <td class="title-name">从业时间</td>
			  <td><?php echo YxStaff::getStaffTimeName($YxStaff->staff_manage_time); ?></td>
			</tr>
			<tr>
			  <td class="title-name">业务范围</td>
			  <td><?php echo YxStaff::getServerName($YxStaff->staff_id); ?></td>
			</tr>
			<tr>
			  <td class="title-name">受教育水平</td>
			  <td><?php echo YxStaff::getStaffEducateName($YxStaff->staff_educate); ?></td>
			</tr>
			<tr>
			  <td class="title-name">服务总成交量</td>
			  <td>
					<?php if($YxStaff->staff_clinch==0) {
							echo 0;
					}else {
							echo $YxStaff->staff_clinch;
					}?>次
				</td>
			</tr>
			<tr class="title-name">
			  <td>上月服务</td>
			  <td>
					<?php if($YxStaff->staff_clinch==0) {
							echo 0;
					}else {
							echo $YxStaff->staff_clinch;
					}?>次
				</td>
			</tr>
			<tr>
			  <td class="title-name">入驻平台时间</td>
			  <td><?= $YxStaff->staff_found;?></td>
			</tr>
			<tr>
			  <td class="title-name">接受相关培训</td>
			  <td><?= $YxStaff->staff_train;?></td>
			</tr>
			<tr>
			  <td class="title-name">身份实名认证</td>
			  <td><?= $YxStaff->staff_idcard;?></td>
			</tr>
			<tr>
			  <td class="title-name">技能证书认证</td>
			  <td><?= $YxStaff->staff_skill;?></td>
			</tr>
			<tr>
			  <td class="title-name">犯罪记录</td>
			  <td><?= $YxStaff->staff_crime_record;?></td>
			</tr>
			<tr>
			  <td class="title-name">不良习惯记录</td>
			  <td><?= $YxStaff->staff_sin_record;?></td>
			</tr>
			<tr>
			  <td class="title-name">所属家政公司</td>
			  <td><?php echo YxStaff::getCompanyName($YxStaff->staff_id); ?></td>
			</tr>
			<tr>
			  <td class="title-name">服务者宣言</td>
			  <td><?= $YxStaff->staff_memo;?></td>
			</tr>
		</tbody>
	</table>
</div>

<?= Html::style('.title-name { width: 100px; }') ?>
