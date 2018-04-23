<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\YxOrder */

$this->title = "支付中...";
?>
<script src="<?php echo Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp_ui.js" ?>" ></script>
<script src="<?php echo Yii::$app->params['webuploader']['fileDomain']."pingpp-js/dist/pingpp.js" ?>" ></script>
<div class="yx-order-view">

    <h2><?= '支付中，请稍后...' ?></h2>



</div>
<script>
  var ch =  eval('(' + '<?php echo $chargeJson ?>' + ')');
    function chackPay(){
      console.log(typeof pingpp);
      if(typeof pingpp != 'undefined'){
        pingpp.createPayment(ch, function(result, err){
           // 可按需使用 alert 方法弹出 log
            alert(result);
            alert(err.msg);
            alert(err.extra);
            if (result == "success") {
                // 只有微信公众号 (wx_pub)、QQ 公众号 (qpay_pub)支付成功的结果会在这里返回，其他的支付结果都会跳转到 extra 中对应的 URL
                window.location.href = "<?php echo Url::to('/yx-order/paysuccess?id='.$model->id)?>";
            } else if (result == "fail") {
                // Ping++ 对象不正确或者微信公众号 / QQ公众号支付失败时会在此处返回
                //window.location.href = "<?php echo Url::to('/yx-order/paysuccess?id='.$model->id)?>";
            } else if (result == "cancel") {
                // 微信公众号支付取消支付
                //window.location.href = "<?php echo Url::to('/yx-order/paysuccess?id='.$model->id)?>";
            }
        });
      }else {
        setTimeout(chackPay,1000);
      }

    }
    chackPay()
</script>
