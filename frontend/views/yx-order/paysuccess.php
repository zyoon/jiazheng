<?php

use yii\helpers\Html;


$this->title = '订单支付';
?>
<script src="<?php echo Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp_ui.js" ?>" ></script>
<div class="yx-order-paysuccess">

</div>
<script>
//在成功页调用
  window.onload = function(){
    console.log(typeof pingpp_ui);
    pingpp_ui.success(function(res){
        if(!res.status){
            alert(res.msg);
        }
    },function(){
      window.location.href = "/yx-order/index";
    });
  }




</script>
