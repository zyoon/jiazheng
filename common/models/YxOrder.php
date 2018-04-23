<?php

namespace common\models;

use common\models\YxCompany;
use common\models\YxServer;
use common\models\YxStaff;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yx_order".
 *
 * @property int $id 订单id
 * @property string $order_name 订单名称
 * @property string $address 收货地址
 * @property string $phone 联系电话
 * @property int $order_money 订单总金额
 * @property int $order_state 订单状态：1待支付，2待接单，3申请退款，4执行中，5未支付，6未接单，7已退款，8已完成
 * @property string $order_memo 订单备注
 * @property int $yx_user_id 顾客id
 * @property string $user_name 顾客姓名
 * @property int $created_at 订单创建时间
 * @property int $updated_at 订单修改时间
    * @property int $yx_staff_id 服务人员
* @property int $yx_company_id
* @property string $order_no 商家编号
* @property string $ping_id ping++订单ID，用于退款
* @property int $order_type 下单类型：1商家下单，2服务者下单，3商家预约
 */
class YxOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
    public static function tableName()
    {
        return 'yx_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_name', 'order_money', 'order_state', 'yx_user_id', 'user_name', 'order_no'], 'required'],
            [['order_money', 'order_state', 'is_delete', 'yx_user_id', 'created_at', 'updated_at','order_type','time_start', 'time_end','yx_staff_id', 'yx_company_id'], 'integer'],
            [['order_name', 'user_name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 400],
            [['phone', 'order_no'], 'string', 'max' => 20],
            [['order_memo'], 'string', 'max' => 200],
            [['ping_id'], 'string', 'max' => 32],
            [['id','order_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '订单id',
            'order_no' => '订单编号',
            'order_name' => '订单名称',
            'address' => '收货地址',
            'phone' => '联系电话',
            'order_money' => '订单总金额(元)',
            'order_state' => '订单状态',
            'order_memo' => '订单备注',
            'yx_staff_id' => '服务人员',
            'yx_user_id' => '顾客id',
            'yx_company_id'=>'公司ID',
            'user_name' => '顾客姓名',
            'created_at' => '订单创建时间',
            'updated_at' => '订单修改时间',
            'is_delete' => '是否删除',
            'time_start' => '服务开始时间',
            'time_end' => '服务结束时间',
            'order_type'=>'下单类型'
        ];
    }

    public function getyx_order_server() {
        return $this->hasMany('common\models\YxOrderServer', ['yx_order_id'=>'id']);
    }

    /**
     * [getName 匹配名字]
     * @Author   Yoon
     * @DateTime 2018-04-05T18:23:53+0800
     * @param    [type]                     $models    [键]
     * @param    [type]                     $ClassName [方法名]
     * @param    [type]                     $params    [方法参数]
     * @return   [type]                                [名字]
     */
    public static function getName($models, $ClassName = "", ...$params)
    {
        $types = self::$ClassName(...$params);

        if (isset($types[$models])) {
            return $types[$models];
        }
        return '未知';
    }
    /**
     * @inheritdoc
     * @return \yii\db\ActiveQuery
     */
    public function getYxComments()
    {
        return $this->hasMany(YxComment::className(), ['yx_order_id' => 'id']);
    }
    /**
     * @inheritdoc
     * @return YxOrderQuery the active query used by this AR class.
     */
    public static function getStateName($models)
    {
        $types = self::getOrderStatus();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getUserState()
    {
        return array(0 => '全部', 1 => '未付款', 2 => '进行中', 3 => '已完成', 4 => '退单');
    }
    public static function find()
    {
        return new YxOrderQuery(get_called_class());
    }

    public static function getOrderState()
    {
        return array(1 => '待付款', 2 => '待接单', 3 => '申请退款', 4 => '执行中', 5 => '废单', 6 => '未接单', 7 => '已退款', 8 => '已完成', 9 => '拒绝退款  ', 10 => '已评论');
    }
    public static function getOrderStatus()
    {
        return array(1 => '待付款', 2 => '待接单', 3 => '退款中', 4 => '执行中', 5 => '废单', 6 => '未接单', 7 => '已退款', 8 => '已完成', 9 => '拒绝退款  ', 10 => '已评论');
    }
    public static function getOrderType()
    {
        return array(1 => '商家下单', 2 => '员工下单', 3 => '商家预约');
    }
/**
 * [generateOrderNumber 生成订单编号]
 * @Author   Yoon
 * @DateTime 2018-04-07T16:44:58+0800
 * @param    [type]                   $server_id  [服务ID]
 * @param    [type]                   $order_type [订单类型：1服务者下单，2商家下单]
 * @param    [type]                   $id         [公司ID/服务者ID]
 * @return   [type]                               [订单编号]
 */
    public static function generateOrderNumber($server_id, $order_type, $id)
    {
        $order_number = '';
        $server_model = YxServer::findOne($server_id);
        $order_number = $server_model->server_class;

        $order_number = $order_number . date('ymd');

        $start_date = strtotime(date('Ymd'));
        $end_date = strtotime(date('Ymd', strtotime('+1 day')));
        if ($order_type == 1) {
            $model = YxStaff::findOne($id);
            $server_count = self::find()
                ->where(['yx_staff_id' => $id])
                ->andFilterWhere(['between', 'created_at', $start_date, $end_date])
                ->count();
            $server_count++;
            $server_count = self::translate000($server_count);
            $order_number = $order_number . $model['staff_number'] . $server_count;
        } elseif ($order_type == 2) {
            $model = YxCompany::findOne($id);
            $server_count = self::find()
                ->where(['yx_company_id' => $id])
                ->andFilterWhere(['between', 'created_at', $start_date, $end_date])
                ->count();
            $server_count++;
            $server_count = self::translate000($server_count);
            $order_number = $order_number . $model->number . $server_count;
        }
        return $order_number;
    }

    public static function translate000($sum)
    {
        $number = '';
        $arr_0 = array('0', '00');
        if ($sum > 0 && $sum < 10) {
            $number = $arr_0['1'] . $sum;
        } elseif ($sum >= 10 && $sum < 100) {
            $number =  $arr_0['0'] . $sum;
        } elseif ($sum >= 100 && $sum < 1000) {
            $number = $sum;
        }
        $number = preg_replace('# #', '', $number);
        return $number;
    }
    /**
     * [setHistoryFraction 未接订单扣分]
     * @Author   Yoon
     * @DateTime 2018-04-10T18:14:26+0800
     */
    public static function setHistoryFraction()
    {
        $model = array();
        $Z = (-0.2) * 1000;
        if ($this->order_type!=1) {
            $model = YxCompany::findOne($this->yx_company_id);
            if ($model->models == 2) {
                $Z = (-0.1) * 1000;
            }
        }
        $compny_model->updateCounters(['total_fraction' => $Z]);
        $compny_model->updateCounters(['history_fraction' => $Z]);
    }
    
/**
 * [noPayOrder 未支付订单]
 * @Author   Yoon
 * @DateTime 2018-04-18T20:01:33+0800
 * @return   [type]                   [description]
 */
    public static function noPayOrder()
    {
        $time = strtotime(date('Y-m-d h:i:s')) - (30 * 60);
        $order_model = YxOrder::find()->where(['order_state' => 1])->andFilterWhere(['<=', 'created_at', $time])->all();
        foreach ($order_model as $key => $value) {
            $order_model[$key]['order_state'] = 5;
            $order_model[$key]->save();
        }

        return 'OK_PayOrder';
    }
    
    public static function returnStaffFreeTimeArr($yx_staff_id,$dayTime){
        $timeDatas = [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];
        $dayOrders = YxOrder::find()->where(['yx_staff_id'=>$yx_staff_id])->andFilterWhere(['between', 'time_start', $dayTime, $dayTime+86400])->asArray()->orderBy('time_start DESC')->all();
        foreach ($dayOrders as $orderItem) {
            $startHours = round(($orderItem['time_start'] % 86400)/3600) + 8;
            $endHours = round(($orderItem['time_end'] % 86400)/3600) + 8;
            if($startHours >= 24) $startHours-=24;
            if($endHours >= 24) $endHours-=24;
            for($i = $startHours; $i <= $endHours; $i++){
                $timeDatas[$i] = 0;
            }
        }
        return $timeDatas;
    }
    
    
    public static function finishOrder($pingId,$order_no){
        $orders = YxOrder::findOne(["order_no" => $order_no]);
        $orders->order_state = 2;
        $orders->ping_id = $pingId;
        return $orders->save();
    }
    public static function returnStaffOrderCountByTime($yx_staff_id,$startTime,$endTime){
        //echo YxOrder::returnStaffOrderCountByTime(38,1523768400,1523779200);
        //$dayTime = $startTime - ($startTime%86400) - 8 * 3600; //根据传入时间，获取该天服务人员的忙碌状态
        //$order_count = YxOrder::find()->andFilterWhere(['>=', 'time_start', $startTime])->andFilterWhere(['<=', 'time_end', $endTime])->count();
        $str1 = "time_start <= ".$startTime." and time_end > ".$startTime;
        $str2 = "time_start < ".$endTime." and time_end >= ".$endTime;
        $query = YxOrder::find()->where(['yx_staff_id'=>$yx_staff_id])->andWhere(['or',$str1,$str2]);
        $order_count = $query->count();
        // $commandQuery = clone $query;
        // print_r( $commandQuery->createCommand()->getRawSql());
        return $order_count;
    }
    public static function testSql($yx_staff_id,$order_server){
      $query = (new \yii\db\Query())
      ->select('*')
      ->from('yx_staff_server')
      ->leftJoin('yx_server','yx_staff_server.server_id =yx_server.server_id')
      ->where(["yx_staff_server.staff_id"=>$yx_staff_id,"yx_staff_server.server_id"=>$order_server]);
      $yx_staff_server = $query->one();
      $commandQuery = clone $query;
      print_r( $commandQuery->createCommand()->getRawSql());
      print_r("<br></br>");
      print_r($yx_staff_server);
      return $yx_staff_server;
    }

}
