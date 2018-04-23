<?php
namespace common\tools;

use Yii;
use yii\web\Controller;

class CheckController extends Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->isGuest){
            //return $this->goHome()->send();//这边需要家send(),不然无法跳转，Yii 2.0.7
            Yii::$app->response->redirect(['/site/login', 'ref'=>'/admin/index/index']);
            Yii::$app->end();
        }

        return true;
    }
}
