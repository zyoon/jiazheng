<?php
use yii\helpers\Html;

$user_info = Yii::$app->user->identity;
?>

<div class="area">
  <h1>当前选择地区：<?= $user_info['city'];?></h1>
  <div class="city-select">
    <h3>
      切换地区：省：
      <select class="province">
        <?php foreach ($provinceAll as $value): ?>
          <option value="<?= $value['id']?>"
            <?php if ($value['id'] == $provinceId) {
            echo 'selected';
            }?>
          >
            <?= $value['name']?>
          </option>
  			<?php endforeach; ?>
      </select>
      ——市：
      <select class="city">
        <?php foreach ($cityAll as $value): ?>
          <option value="<?= $value['id']?>"
            <?php if ($value['id'] == $provinceId) {
            echo 'selected';
            }?>
          >
            <?= $value['name']?>
          </option>
        <?php endforeach; ?>
      </select>
    </h3>
    <button id="update" class="btn btn-success">修改</button>
  </div>
</div>

<script type="text/javascript">
  window.onload = function() {
    // 提交信息，搜索
    $('.province').change(function(event) {
      let provinceId = $('.province').val();
      $.ajax({
          type: "POST",
          url: "/city/city",
          datatype: 'json',
          data:{"province_id":provinceId},
          success:function(json) {
            var str = eval('(' + json + ')');
            city(str);
          }
      });
    });
    function city(str) {
      let city = '';
      for (var i = 0; i < str.length; i++) {
        city = city + '<option value='+str[i].id+'>'+str[i].name+'</option>'
      }
      $('.city').html(city);
    }
    // 修改城市
    $('#update').click(function() {
      var city = document.querySelector('.city');
      var cityName;
      for(let i = 0;i < city.children.length;i++) {
        if(city.value == city.children[i].value) {
          cityName = city.children[i];
        }
      }
      $.ajax({
          type: "POST",
          url: "/city/name",
          datatype: 'json',
          data:{"name": cityName},
          success:function(json) {
            // window.location.href = document.referrer;
          }
      });
    })
  }
</script>
