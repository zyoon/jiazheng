<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii;


/**
* 购物车的Controlller
*/
class CartController extends Controller {

	public function actionIndex() {
		$user = Yii::$app->user;
		$this->getView()->title = "购物车";
		$this->layout = "layout2";
		// print_r($user);
		return $this->render("index");
	}

	public function actionUser() {
		$request = Yii::$app->request;
		$js_code = $request->get('code');
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx39e60a93c77bd9e1&secret=f9a5fb792468a25e58d76a3a5c8db3e8&js_code='.$js_code.'&grant_type=authorization_code';
		$res = file_get_contents($url);
		return $res;
	}
}
