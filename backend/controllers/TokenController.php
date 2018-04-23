<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\tools\WechatCallbackapiTest;
use common\models\YxOrder;
/**
 * YxStaffController implements the CRUD actions for YxStaff model.
 */
class TokenController extends Controller
{

  public function init(){
     $this->enableCsrfValidation = false;
  }
  public function actionToken()
  {
    /**
      * wechat php test
      */
      //define your token
      define("TOKEN", "wudiphp");
      $wechatObj = new WechatCallbackapiTest();
      $wechatObj->valid();
  }

  public function actionFinish_order()
 {
   $event = json_decode(file_get_contents("php://input"));
   // 对异步通知做处理
   if (!isset($event->type)) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
     exit("fail");
   }
   switch ($event->type) {
     case "charge.succeeded":
         // 开发者在此处加入对支付异步通知的处理代码
         if(YxOrder::finishOrder($event->data->object->id,$event->data->object->order_no)){
           header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
         }
         break;
     case "refund.succeeded":
         // 开发者在此处加入对退款异步通知的处理代码
         header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
         break;
     default:
         header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
         break;
   }
   return;
 }
}
?>
