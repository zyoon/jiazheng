<?php
namespace common\tools;
require_once "../../aliyun-dysms-php-sdk-lite/SignatureHelper.php";
use Aliyun\DySDKLite\SignatureHelper;
use yii;

 class Message{
   public static function SendSignUpCodeMessage($phone)
   {
      return self::SendCodeMessage($phone,"SMS_130775174");
   }
   public static function SendResetPwdCodeMessage($phone)
   {
      return self::SendCodeMessage($phone,"SMS_130765171");
   }

   public static function SendCodeMessage($phone,$templateCode)
   {
     $params = array ();

     // *** 需用户填写部分 ***
     // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
     $accessKeyId = "LTAIYAT7oAnGFr0m";
     $accessKeySecret = "FYJ2wAETGHJYGWJk3nXBsfSMm98ovE";

     // fixme 必填: 短信接收号码
     $params["PhoneNumbers"] = $phone;

     // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
     $params["SignName"] = "原象屋";

     // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
     $params["TemplateCode"] = $templateCode;
     $redis = Yii::$app->redis;

     $signCode = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);
     $redis->set($phone,$signCode);
      // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
      $params['TemplateParam'] = Array (
          "code" => $signCode,
      );

     // fixme 可选: 设置发送短信流水号
     //$params['OutId'] = "12345";

     // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
     //$params['SmsUpExtendCode'] = "1234567";


     // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
     if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
     }

     // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
     $helper = new SignatureHelper();

     // 此处可能会抛出异常，注意catch
     $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
        // fixme 选填: 启用https
        // ,true
     );
     if($content->Code != "OK"){
       return false;
     }
     return true;
   }

 }

?>
