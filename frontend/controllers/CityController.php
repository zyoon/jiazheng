<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Region;
use Yii;

class CityController extends Controller {
  // 地区信息
	public function actionIndex() {
    // 查找所有地区
    $this->getView()->title = '修改地址';
    $provinceAll = Region::find()->where(['level' => 0])->all();
    // print_r($province[0]['id'].'--'.$province[0]['name']);
    // $request = Yii::$app->request;
    // $provinceId = $request->get('province_id');
    // if ($provinceId) {
    //   $cityAll = Region::find()->where(['parent_id' => $provinceId,'level' => 1])->all();
    // }else {
    $provinceId = $provinceAll[0]['id'];
    $cityAll = Region::find()->where(['parent_id' => $provinceId,'level' => 1])->all();
    // }
    return $this->render('index', [
      'provinceAll' => $provinceAll,
      'cityAll' => $cityAll,
      'provinceId' => $provinceId
    ]);
  }

  public function actionCity() {
    $request = Yii::$app->request;
    $provinceId = $request->post('province_id');
    $city = Region::find()->where(['parent_id' => $provinceId,'level' => 1])->all();
    $cityAll = [];
    foreach ($city as $key => $value) {
      $cityAll[$key]['id'] = $value['id'];
      $cityAll[$key]['name'] = $value['name'];
    }
    print_r(json_encode($cityAll));
  }

  public function actionName() {
    $request = Yii::$app->request;
    $cityName = $request->post('name');
    $userId = Yii::$app->user->identity['id'];
    $db = \Yii::$app->db;
    $db->createCommand()->update('yx_user',['id' => $userId])->execute();
  }

}

?>
