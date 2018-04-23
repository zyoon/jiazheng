<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use common\models\YxCompany;
use common\models\YxStaff;
use common\models\YxServer;
use Yii;

/**
* 其它服务(除专项保洁和基础保洁外)的Controller
 */

class OtherServicesController extends Controller {

	// 其它服务（默认是显示商家信息）
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
									->where(['yx_company.status'=>2,'yx_cmp_server.server_id'=>$serverId,'yx_company.city'=>$user_info['city']])->orderBy('yx_company.total_fraction desc');
		}else if($sort === 'price') {
			$YxCompany = YxCompany::find()->select(['*'])
								->innerjoin('yx_cmp_server', 'yx_cmp_server.company_id=yx_company.id')
									->where(['yx_company.status'=>2,'yx_cmp_server.server_id'=>$serverId,'yx_company.city'=>$user_info['city']])->orderBy('yx_cmp_server.server_price desc');
		}else {
			$sort = 'fraction';
			$YxCompany = YxCompany::find()->select(['*'])
								->innerjoin('yx_cmp_server', 'yx_cmp_server.company_id=yx_company.id')
									->where(['yx_company.status'=>2,'yx_cmp_server.server_id'=>$serverId,'yx_company.city'=>$user_info['city']])->orderBy('yx_company.total_fraction desc');
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

	// 服务者信息
	public function actionStaff() {
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
			$YxStaff = YxStaff::find()->select(['*'])
								->innerjoin('yx_staff_server', 'yx_staff_server.staff_id=yx_staff.staff_id')
									->where(['yx_staff.staff_state'=>1,'yx_staff_server.server_id'=>$serverId,'yx_staff.staff_city'=>$user_info['city']])->orderBy('yx_staff.staff_fraction desc');
		}else if($sort === 'price') {
			$YxStaff = YxStaff::find()->select(['*'])
								->innerjoin('yx_staff_server', 'yx_staff_server.staff_id=yx_staff.staff_id')
									->where(['yx_staff.staff_state'=>1,'yx_staff_server.server_id'=>$serverId,'yx_staff.staff_city'=>$user_info['city']])->orderBy('yx_staff_server.server_price desc');
		} else {
			$sort = 'fraction';
			$YxStaff = YxStaff::find()->select(['*'])
								->innerjoin('yx_staff_server', 'yx_staff_server.staff_id=yx_staff.staff_id')
									->where(['yx_staff.staff_state'=>1,'yx_staff_server.server_id'=>$serverId,'yx_staff.staff_city'=>$user_info['city']])->orderBy('yx_staff.staff_fraction desc');
		}
		$pages = new Pagination([
			'totalCount' => $YxStaff->count(),
			'pageSize' => 6,
			'pageSizeParam'=>false
		]);
		$models = $YxStaff->offset($pages->offset)
		    ->limit($pages->limit)
		    ->all();
		return $this->render('staff', [
		    'models' => $models,
		    'pages' => $pages,
		    'sort' => $sort,
				'serverId' => $serverId,
				'serverParent' => $server_parent,
				'YxServerAll' => $YxServerAll
			]);
	}

	// 商家详情
	public function actionDetail() {
		$this->getView()->title = "商家详情";
		$this->layout = "layout2";
		$request = Yii::$app->request;
		$companyId = $request->get('company');
		$YxCompany = YxCompany::find()->where(['id' => $companyId])->one();
		return $this->render("detail", [
			'YxCompany' => $YxCompany
		]);
	}


}
