<?php

namespace common\models;

use common\models\YxCompany;
use common\models\YxOrderServer;
use common\models\YxServer;
use common\models\YxStaff;
use common\models\YxOrder;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yx_comment".
 *
 * @property int $id
 * @property string $content 评论
 * @property int $star 星级
 * @property int $yx_company_id 公司
 * @property int $yx_staff_id 服务人员
 * @property int $yx_user_id 用户
 * @property int $is_praise 是否好评
 * @property int $yx_order_id 订单号
 * @property int $created_at
 * @property int $updated_at
 *
 */
class YxComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yx_comment';
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yx_company_id', 'yx_staff_id', 'yx_user_id', 'is_praise', 'yx_order_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
            ['star', 'integer', 'min' => 1, 'max' => 5],
            [['yx_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxCompany::className(), 'targetAttribute' => ['yx_company_id' => 'id']],
            [['yx_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxUser::className(), 'targetAttribute' => ['yx_user_id' => 'id']],
            [['yx_staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxStaff::className(), 'targetAttribute' => ['yx_staff_id' => 'staff_id']],
            [['yx_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxOrder::className(), 'targetAttribute' => ['yx_order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '评论',
            'star' => '星级',
            'yx_company_id' => '公司',
            'yx_staff_id' => '服务人员',
            'yx_user_id' => '用户',
            'is_praise' => '是否好评',
            'yx_order_id' => '订单号',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'companyName' => '公司名',
            'staffName' => '员工名',
            'userName' => '用户名',
            'orderName' => '订单编号',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYxCompany()
    {
        return $this->hasOne(YxCompany::className(), ['id' => 'yx_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYxUser()
    {
        return $this->hasOne(YxUser::className(), ['id' => 'yx_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYxStaff()
    {
        return $this->hasOne(YxStaff::className(), ['staff_id' => 'yx_staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYxOrder()
    {
        return $this->hasOne(YxOrder::className(), ['id' => 'yx_order_id']);
    }
    /**
     * {@inheritdoc}
     * @return YxCommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxCommentQuery(get_called_class());
    }

/**
 * [defaultComment 默认生成评论]
 * @Author   Yoon
 * @DateTime 2018-04-18T20:01:33+0800
 * @return   [type]                   [description]
 */
    public static function defaultComment(){
        
        $comment_model=self::find()->where(['not',['yx_order_id' => null]])->all();
        $order_id=array();
        if($comment_model){
            foreach ($comment_model as $key => $value) {
                $order_id[$key]=$value['yx_order_id'];
            } 
        }
        $time=strtotime(date('Y-m-d h:i:s'))-(1*24*60*60);
        $order_model=YxOrder::find()->where(['order_state'=>8])->andFilterWhere(['not in','id',$order_id])->andFilterWhere(['<=','time_end',$time])->all();
        foreach ($order_model as $key => $value) {
           $model=new YxComment();
           $model->content="服务质量总体来说中等，有值得点赞的地方，基本符合我的要求";
           $model->star=3;
           $model->yx_company_id=$value['yx_company_id'];
           if(isset($value['yx_staff_id'])&&empty($value['yx_staff_id'])){
                $model->yx_staff_id=$value['yx_staff_id'];
           }
           $model->yx_user_id=$value['yx_user_id'];
           $model->save();
           $model->setHistoryFraction();
        }
         
        return 'OK_Comment';
    }

    /**
     * [setHistoryFraction 评论计算运营分数]
     * @Author   Yoon
     * @DateTime 2018-04-10T18:03:00+0800
     */
    public function setHistoryFraction()
    {
        #分数参数
        #历史运用分
        $N = 0;
        $b = 0;
        $c = 0;
        $e = 0;
        $f = 0;
        #偏差系数
        $a = 1;
        #用户打分
        $S = $this->star;
        $R = 0;
        $W = 0;
        $Z = 0;

        #判断下单类型：1服务者下单，2商家下订单。

        $order_type = 1;
        if(empty($this->yx_staff_id)||!isset($this->yx_staff_id)){
            $order_type = 2;
        }

        #判断是否位主营业务：0否，1是。
        $is_main_server = 0;

        #判断公司类型：1公司制，2个人制。
        $company_type = 1;

        #取服务次数
        $server_count = 0;

        #判断是否存在订单
        $exist_order_id = isset($this->yx_order_id) && !empty($this->yx_order_id);
        $details_model = array();
        if ($exist_order_id) {
            $details_model = YxOrderServer::find()->where(['yx_order_id' => $this->yx_order_id,'is_main'=>1])->one();
        }
        $staff_model = array();
        $compny_model = array();
        if ($order_type == 1) {
            $staff_model = YxStaff::findOne($this->yx_staff_id);
            if (!empty($exist_order_id)) {
                if ($staff_model->staff_main_server_id == $details_model['server_id']) {
                    $is_main_server = 1;
                }
            } else {
                $is_main_server = 1;
            }

            $server_count = self::find()->where(['yx_staff_id' => $this->yx_staff_id])->count();

            $N = ($staff_model->staff_history_fraction) / 1000;

        } else {
            $compny_model = YxCompany::findOne($this->yx_company_id);
            if (!empty($exist_order_id)) {
                if (strpos($compny_model->staff_main_server_id, strval($details_model['server_id']))) {
                    $is_main_server = 1;
                }
            } else {
                $is_main_server = 1;
            }

            if ($compny_model->models == 2) {
                $company_type = 2;
            }

            $server_count = self::find()->where(['yx_company_id' => $this->yx_company_id, 'yx_staff_id' => null])->count();

            $N = ($compny_model->history_fraction) / 1000;

        }
        #判断服务类型：1BCD,2AEFGH
        $server_type = 1;
        if (!empty($exist_order_id)) {
            $server_model = YxServer::findOne($details_model['server_id']);
            $server_model = YxServer::findOne($server_model['server_parent']);
            if (strpos($server_model['server_class'], 'AEFGH')) {
                $server_type = 2;
            }
        }else{
          $server_type = 2;
        }

        if ($is_main_server == 1) {
            $b = 1;
        } else {
            $b = 0.2;
        }

        if ($server_type == 1) {
            $c = 3;
        } else {
            $c = 1;
        }

        if ($N < -5) {
            $R = 2.8;
            $e = 0.5;
        }
        if ($N >= -5 && $N < 0) {
            $R = 2.5;
            $e = 0.4;
        }
        if ($N >= 0 && $N < 5) {
            $R = 2.7;
            $e = 0.3;
        }
        if ($N >= 5 && $N < 10) {
            $R = 2.8;
            $e = 0.05;
        }
        if ($N >= 10 && $N < 17) {
            $R = 2.8;
            $e = 0.02;
        }
        if ($N >= 17) {
            $R = 4;
            $e = 0.01;
        }

        $P = $a * $S - $R;

        if ($P > 0) {
            $d = 1;
        } elseif ($P < 0) {
            if ($N < -5) {
                $d = 4;
            }
            if ($N >= -5 && $N < 0) {
                $d = 4;
            }
            if ($N >= 0 && $N < 5) {
                $d = 6;
            }
            if ($N >= 5 && $N < 10) {
                $d = 15;
            }
            if ($N >= 10 && $N < 17) {
                $d = 25;
            }
            if ($N >= 17) {
                $d = 1;
            }
        }

        if ($order_type == 1 || $company_type == 2) {
            $f = 1;
            if ($server_count <= 5) {
                $W = 0.6;
            }
        } elseif ($company_type == 1) {
            $f = 0.2;
        }

        $N2 = ($b * $c * $d * $e * $f * $P + $W) * 1000;
        return ($N2/1000)."="."$b * $c * $d * $e * $f * ($a*$S-$R) + $W";
        if ($order_type == 1) {
            $staff_model->updateCounters(['staff_fraction' => $N2]);
            $staff_model->updateCounters(['staff_history_fraction' => $N2]);
        } elseif ($order_type == 2) {
            $compny_model->updateCounters(['total_fraction' => $N2]);
            $compny_model->updateCounters(['history_fraction' => $N2]);
        }
    }

    // 根据staff_id查询相关的评论
    public static function getStaffComent($staff_id) {
      $staffComent = YxComment::find()->where(['yx_staff_id' => $staff_id])->all();
      return $staffComent;
    }
    // 根据company_id查询相关的评论
    public static function getCompanyComent($company_id) {
      $companyComent = YxComment::find()->where(['yx_company_id' => $company_id])->all();
      return $companyComent;
    }
}
