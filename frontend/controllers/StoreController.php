<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\YxCompany;
use Yii;


/**
* 购物车的Controlller
*/
class StoreController extends Controller {

	public function actionIndex() {
		$this->layout = "layout2";
    $this->getView()->title = "商家搜索";
    $request = Yii::$app->request;
    $choosed = $request->get('company_all');
    $comma_separated = explode(",", $choosed);
    $ids = 'yx_company.id = ';
    foreach ($comma_separated as $key => $value) {
      if($key == 0) {
        $ids = $ids.$value;
      }else {
        $ids = $ids.' or yx_company.id = '.$value;
      }
    }
    $sql = 'select DISTINCT(yx_company.id),yx_company.name,yx_company.image,yx_company.introduction,yx_company.total_fraction'.
    ' from yx_company inner join yx_cmp_server where yx_cmp_server.company_id = yx_company.id and yx_company.status = 2 and ('.$ids.') order by total_fraction desc';
    $companyAll = Yii::$app->db->createCommand($sql)->queryAll();
		return $this->render("index",[
      'companyAll' => $companyAll,
      'serverId' => 30,
    ]);
	}
}
