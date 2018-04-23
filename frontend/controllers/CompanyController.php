<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use common\models\YxCompany;
use common\models\YxCmpServer;
use common\models\YxServer;
use common\models\YxStaff;
use Yii;

/**
* 商家的Controller
 */

class CompanyController extends Controller {

	public function actionIndex() {
		$this->layout = 'layout2';
		$request = Yii::$app->request;
		$companyId = $request->get('company_id');
		// 得到商家名
		$companyName = YxCompany::getCompanyName($companyId);
		// server_id二级服务
		$CompanyServerAll = YxServer::getCompanyServerAll($companyId);
		$serverId = $request->get('server_id');
		// 附加服务
		$server_add = YxCmpServer::getAddServerCompany($companyId,$serverId);
		if (!$serverId) {
			foreach ($CompanyServerAll as $key => $value) {
				$serverId = $key;
				break;
			}
		}
		$serverName = YxServer::getServerName($serverId);
		$this->getView()->title = $companyName.'-'.$serverName;
		$YxCompany = YxCompany::find()->where(['id' => $companyId])->one();
		// 原象推荐
		$recommendArr = YxCompany::find()->orderby('total_fraction desc')->limit(5)->all();
        
		return $this->render('index', [
				'serverId' =>  $serverId,
				'companyId' => $companyId,
				'recommendArr' => $recommendArr,
				'CompanyServerAll' => $CompanyServerAll,
				'YxCompany' => $YxCompany,
				'serverAdd' => $server_add
		]);
	}

	// 所有服务者信息
	public function actionStaff() {
		$this->layout = 'layout2';
		$request = Yii::$app->request;
		$companyId = $request->get('company_id');
		// 得到商家名
		$companyName = YxCompany::getCompanyName($companyId);
		// server_id二级服务
		$CompanyServerAll = YxServer::getCompanyServerAll($companyId);
		$serverId = $request->get('server_id');
		$sort = $request->get('sort');
		if (!$serverId) {
			foreach ($CompanyServerAll as $key => $value) {
				$serverId = $key;
				break;
			}
		}
		$serverName = YxServer::getServerName($serverId);
		$this->getView()->title = $companyName.'-'.$serverName;
		if($sort === 'fraction') {
			$YxStaff = YxStaff::find()->select(['*'])
								->innerjoin('yx_staff_server', 'yx_staff_server.staff_id=yx_staff.staff_id')
									->where(['yx_staff.company_id'=>$companyId,'yx_staff_server.server_id'=>$serverId])->orderBy('staff_fraction');
		}else if($sort === 'price') {
			$YxStaff = YxStaff::find()->select(['*'])
								->innerjoin('yx_staff_server', 'yx_staff_server.staff_id=yx_staff.staff_id')
									->where(['yx_staff.company_id'=>$companyId,'yx_staff_server.server_id'=>$serverId])->orderBy('staff_fraction desc');
		}else {
			$sort = 'fraction';
			$YxStaff = YxStaff::find()->select(['*'])
								->innerjoin('yx_staff_server', 'yx_staff_server.staff_id=yx_staff.staff_id')
									->where(['yx_staff.company_id'=>$companyId,'yx_staff_server.server_id'=>$serverId])->orderBy('staff_fraction');
		}
		// 原象推荐
		//$recommendArr = YxCompany::find()->orderby('total_fraction desc')->limit(5)->all();
		$recommendArr = YxStaff::find()-> where (["company_id"=>$companyId])->orderby('staff_fraction desc')->limit(5)->all();
		$pages = new Pagination([
			'totalCount' => $YxStaff->count(),
			'pageSize' => 8,
			'pageSizeParam'=>false
		]);
		$models = $YxStaff->offset($pages->offset)
		    ->limit($pages->limit)
		    ->all();
		return $this->render('staff', [
		    'models' => $models,
		    'pages' => $pages,
		    'serverId' =>  $serverId,
				'companyId' => $companyId,
				'sort' => $sort,
				'recommendArr' => $recommendArr,
				'CompanyServerAll' => $CompanyServerAll
		]);
	}

	public function actionLicense() {
		$this->getView()->title = "商家执照";
		$this->layout = 'layout2';
		return $this->render('license');
	}
}
