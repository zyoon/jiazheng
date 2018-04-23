<?php
	use yii\helpers\Html;

?>

<div class="tabs">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td class="title-name">商家名</td>
        <td><?= $YxCompany->name;?></td>
      </tr>
      <tr>
        <td class="title-name">ID</td>
        <td><?= $YxCompany->number;?></td>
      </tr>
      <tr>
        <td class="title-name">地址</td>
        <td><?= $YxCompany->address;?></td>
      </tr>
      <tr>
        <td class="title-name">业务范围</td>
        <td><?= $YxCompany->query;?></td>
      </tr>
      <tr>
        <td class="title-name">营业地域范围</td>
        <td><?= $YxCompany->name;?></td>
      </tr>
      <tr>
        <td class="title-name">营业时长</td>
        <td><?= $YxCompany->name;?>年</td>
      </tr>
      <tr>
        <td class="title-name">规模</td>
        <td><?= $YxCompany->name;?>名服务者</td>
      </tr>
      <tr>
        <td class="title-name">服务总量</td>
        <td><?= $YxCompany->name;?>次</td>
      </tr>
      <tr>
        <td class="title-name">服务总金额</td>
        <td><?= $YxCompany->name;?>元</td>
      </tr>
      <tr>
        <td class="title-name">入驻平台时间</td>
        <td><?= $YxCompany->created_at;?></td>
      </tr>
      <tr>
        <td class="title-name">联系商家</td>
        <td><?= $YxCompany->telephone;?></td>
      </tr>
      <tr>
        <td class="title-name">商家宣言</td>
        <td><?= $YxCompany->introduction;?></td>
      </tr>
    </tbody>
  </table>
</div>

<?= Html::style('.title-name { width: 100px; }') ?>
