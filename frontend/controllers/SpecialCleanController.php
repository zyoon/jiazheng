<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use common\models\YxCompany;
use common\models\YxStaff;
use common\models\YxServer;
use Yii;

/**
* 专项保洁主页的Controller
 */

class SpecialCleanController extends Controller {

	// 商家信息
	public function actionIndex() {
		$this->layout = "layout2";
		$request = Yii::$app->request;
		$server_parent = $request->get('server_parent');
		$YxServerAll = YxServer::getServerSecond($server_parent);
		$serverId = $request->get('server_id');
		if (!$serverId) {
			$serverId = $YxServerAll[0]['server_id'];
		}
		$serverName = YxServer::getServerName($serverId);
		$this->getView()->title = $serverName;
		$sort = $request->get('sort');
		// 获取地区
		$user_info = Yii::$app->user->identity;
		if($sort === 'fraction') {
			$YxCompany = YxCompany::find()->select(['*'])
								->innerjoin('yx_cmp_server', 'yx_cmp_server.company_id=yx_company.id')
									->where(['yx_company.status'=>2,'yx_cmp_server.server_id'=>$serverId,'yx_company.city'=>$user_info['city']])->orderBy('total_fraction desc');
		}else if($sort === 'price') {
			$YxCompany = YxCompany::find()->select(['*'])
								->innerjoin('yx_cmp_server', 'yx_cmp_server.company_id=yx_company.id')
									->where(['yx_company.status'=>2,'yx_cmp_server.server_id'=>$serverId,'yx_company.city'=>$user_info['city']])->orderBy('yx_cmp_server.server_price desc');
		}else {
			$sort = 'fraction';
			$YxCompany = YxCompany::find()->select(['*'])
								->innerjoin('yx_cmp_server', 'yx_cmp_server.company_id=yx_company.id')
									->where(['yx_company.status'=>2,'yx_cmp_server.server_id'=>$serverId,'yx_company.city'=>$user_info['city']])->orderBy('total_fraction desc');
		}
		$pages = new Pagination([
			'totalCount' => $YxCompany->count(),
			'pageSize' => 4,
			'pageSizeParam'=>false
		]);
		$models = $YxCompany->offset($pages->offset)
		    ->limit($pages->limit)
		    ->all();
		return $this->render('index', [
		    'models' => $models,
		    'pages' => $pages,
		    'sort' => $sort,
				'serverId' => $serverId,
				'serverParent' => $server_parent,
				'YxServerAll' => $YxServerAll
		]);
	}
	// 预约
	public function actionIndexReserve() {
		$request = Yii::$app->request;
		$name = $request->post('name');
		$time = $request->post('time');
		print_r(json_encode($name));
	}
}
