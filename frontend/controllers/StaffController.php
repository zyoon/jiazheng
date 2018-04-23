<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\YxStaff;
use common\models\YxStaffServer;
use common\tools\Helper;
use common\models\YxOrder;
use common\models\YxComment;
/**
* 服务人员的Controller
 */

class StaffController extends Controller {
	public function init(){
     $this->enableCsrfValidation = false;
	}

	public function actionIndex($staff_id) {
		$this->layout = 'layout1';
		$this->getView()->title = YxStaff::getStaffName($staff_id);
		$YxStaff = YxStaff::find()->where(['staff_id'=>$staff_id])->one();
		// 得到分数在前5位的服务人员
		// $YxStaffArr = YxStaff::find()->orderby('staff_fraction desc')->limit(5)->all();
		$company_id=$YxStaff->company_id;
		$YxStaffArr = YxStaff::find()->where(['company_id'=>$company_id])->orderby('staff_fraction desc')->limit(5)->all();
		$searchModel = new YxStaffServer();
		$request = Yii::$app->request;
		$staff_id = $request->get('staff_id');
		$server_id = $request->get('server_id');
		$dataProvider = $searchModel->getServerAll($staff_id);
		// 服务人员的评论
		$comment = YxComment::getStaffComent($staff_id);
		if(!$server_id) {
			$server_unit = YxStaffServer::getServerUnit($dataProvider[0]['server_id']);
			$server_price = YxStaffServer::getStaffPrice($staff_id,$dataProvider[0]['server_id']);
			$server_add = YxStaffServer::getAddServer($staff_id,$dataProvider[0]['server_id']);
		}else {
			$server_unit = YxStaffServer::getServerUnit($server_id);
			$server_price = YxStaffServer::getStaffPrice($staff_id,$server_id);
			$server_add = YxStaffServer::getAddServer($staff_id,$server_id);
		}
		return $this->render('index',
			[
				'YxStaff' => $YxStaff,
				'dataProvider'=> $dataProvider,
				'YxStaffArr' => $YxStaffArr,
				'serverId' => $server_id,
				'serverPrice' => $server_price,
				'serverUnit' => $server_unit,
				'serverAdd' => $server_add,
				'comment' => $comment
			]);
	}

	public function actionGet_staff_times(){
		$code = -1;
		$msg = "操作失败";
		$timeDatas = [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];
		Yii::$app->response->format = 'json';
		if(Yii::$app->request->isAjax) {
				$params = Yii::$app->request->post();
				if(!isset($params['dayTime']) || $params['dayTime'] < ( time() - 86400)){
						$msg = "缺少日期或日期不正确";
						return [ 'msg' => $msg, 'code' => $code, 'time_datas' => $timeDatas];
				}
				if(!isset($params['yx_staff_id']) || $params['yx_staff_id'] <= 0){
						$msg = "服务人员信息有误";
						return [ 'msg' => $msg, 'code' => $code, 'time_datas' => $timeDatas];
				}
				$dayTime = $params['dayTime'];
				$yx_staff_id = $params['yx_staff_id'];
				$code = 0;
				$msg = '查询成功';
				$timeDatas = YxOrder::returnStaffFreeTimeArr($yx_staff_id,$dayTime);
		}
		return [ 'msg' => $msg, 'code' => $code, 'time_datas' => $timeDatas];
	}
}
