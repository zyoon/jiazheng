<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Region;
use common\models\YxCompanyVerify;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HmCompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '家政公司';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yx-company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="color: red;font-size: 30px">
    	<?php 
	        $user_info=Yii::$app->user->identity;
	        $id=$user_info['id'];
	        // $model=YxCompanyVerify::find()->where(['cmp_user_id'=>$id,'verify_sate'=>2])->one();
	        $model2=YxCompanyVerify::find()->where(['cmp_user_id'=>$id,'verify_sate'=>1])->one();
	        if(!$model2){
	        	echo Html::a('添加公司', ['create'], ['class' => 'btn btn-success']);
	        }else{
	        	echo '审核中';
	        }
    	 ?>
    </p>
</div>
