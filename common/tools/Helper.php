<?php
namespace common\tools;

use Yii;
use \Pingpp\WxpubOAuth;

/**
 * 判断是否微信打开
 * @return boolean
 */
 class Helper{
   public static function isWechatBrowser()
   {
       if (strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
           return true;
       }

       return false;
   }


   /**
    * 获取微信code的重定向前的url
    * @return string
    */
   public static function GetWxCodeUrl($id,$channel)
   {
       $wx_app_id = Yii::$app->params['wechat']['wx_app_id'];
       $redirect_url = Yii::$app->params['wechat']['redirect_url'].'?yx_order_id='.$id.'&channel='.$channel;
       $code_url = WxpubOAuth::createOauthUrlForCode($wx_app_id, $redirect_url);  //WxpubOAth這個類在pingpp\lib\WxpubOAth.php裏面

       return $code_url;
   }
 }

?>
