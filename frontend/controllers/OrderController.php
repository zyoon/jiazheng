<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii;


/**
* 下单的Controlller
*/
class OrderController extends Controller {

	public function actionIndex() {
		$request = Yii::$app->request;
		$code = $request->get('code');
		print_r($code);
		// $this->getView()->title = "商家下单";
		// return $this->render("index");
	}

	public function actionStaff() {
		$this->getView()->title = "服务者下单";
		return $this->render("staff");
	}
}
