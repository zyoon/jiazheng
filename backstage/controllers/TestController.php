<?php

namespace backstage\controllers;

use Yii;
use yii\console\Controller;
use common\models\YxComment;
use common\models\YxOrder;
class TestController extends Controller
{
    public function actionIndex()
    {
        while (true) {
        	echo (YxComment::defaultComment().":".date('Y-m-d h:i:s')."\t");
        	echo (YxOrder::noPayOrder().":".date('Y-m-d h:i:s')."\n");
        	sleep(5*60);
        }
    }

}
