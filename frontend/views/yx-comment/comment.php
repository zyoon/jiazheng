<?php
	use yii\helpers\Html;
?>

<div class="comment">
	<div class="">

	</div>
	<div class="">
		<?= Html::beginForm(['order/save-comment', 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data']) ?>
			<?= Html::input('text', 'content', $model->content, ['class' => 'content']) ?>
		<?= Html::endForm() ?>
	</div>
</div>
