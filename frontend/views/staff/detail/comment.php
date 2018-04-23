<?php
	use yii\helpers\Html;
	use common\models\YxUser;
	// print_r($comment[0]['yx_user_id']);
	// $username = YxUser::getUserName(yx_user_id);
?>

<div class="comment">
	<div class="">

	</div>
	<div class="content-all" style="padding: 1% 2%;">
		<?php foreach ($comment as $value): ?>
			<div class="content-one">
				<div class="content">
					<p><?= $value['content']?></p>
					<p class="text-right"><?= date("Y-m-d ", $value['created_at'])?>(<?= YxUser::getUserName($value['yx_user_id']);?>)</p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?= Html::style('
	.content-one {
		border-bottom: 1px solid #eee;
    margin-top: 10px;
    padding: 5px 10px 0 5px;
	}
') ?>
