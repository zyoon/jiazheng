<?php
	use yii\helpers\Html;
	use common\models\YxCmpServer;
?>

<div class="row">
  <?php foreach ($companyAll as $company): ?>
    <div class="col-md-3 col-lg-3" style="margin-bottom: 20px;padding:0;">
      <div class="company-detail" style="width: 90%;padding: 10px 0;text-align: center;border: 1px solid #eeee;">
        <div class="img">
          <img src="<?= $company['image'];?>" alg="yuanxiang" style="width: 250px;height: 160px;border: 0;"/>
        </div>
        <h3 title="<?= $company['name'];?>" style="width: 100%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?= $company['name']?></h3>
        <p title="价格: <?=YxCmpServer::getCompanyPrice($company['id'],$serverId)?>元"  style="width: 100%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">价格: <?=YxCmpServer::getCompanyPrice($company['id'],$serverId)?>元</p>
        <p title="分数：<?= number_format($company['total_fraction']/1000,1)?>"  style="width: 100%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">分数：<?= number_format($company['total_fraction']/1000,1)?></p>
        <p title="主营简介：<?= $company['introduction'];?>" style="width: 100%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">主营简介：<?= $company['introduction'];?></p>
        <div class="staff-info">
          <a href="/company/index?server_id=<?= $serverId;?>&company_id=<?= $company['id'];?>&sort=fraction">查看详情</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
