<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\YxOrder;
use common\models\Region;
use common\models\YxCompany;
use common\models\YxStaffServer;

/**
 * This is the model class for table "yx_staff".
 *
 * @property int $staff_id 服务人员id
 * @property int $company_id 服务人员所属商家
 * @property string $staff_name 服务人员姓名
 * @property int $staff_sex 服务人员性别(1:男，2:女)
 * @property int $staff_age 服务人员年龄
 * @property string $staff_img 服务人员照片
 * @property string $staff_idcard 服务人员的身份证号码
 * @property string $staff_intro 服务人员简介
 * @property string $staff_found
 * @property string $staff_main_server 主打服务
 * @property string $staff_all_server 所有服务内容：,隔开
 * @property string $staff_state 服务人员的状态(1:空闲,2:工作中,3:休假,0:退出平台)
 * @property string $staff_memo 备注
 * @property string $staff_login_ip 服务人员登陆ip(记入最新的登陆ip,把上一次登录ip写入日志文件中)
 * @property string $staff_login_time 服务人员登陆时间(记入最新的登陆时间,把上一次登录时间写入日志文件中)
 * @property int $staff_main_server_id
        * @property string $staff_all_server_id
* @property string $staff_query 搜索关键词
* @property int $staff_fraction 分数
* @property int $staff_base_fraction 服务人员基础分数
* @property int $staff_history_fraction 员工历史运营分数
* @property int $staff_clinch 员工总成交量
* @property int $staff_price 员工总成交金额
* @property int $staff_manage_time 从业时长
* @property string $staff_idcard_front 身份证正面
* @property string $staff_idcard_back 身份证反面
* @property string $staff_address 籍贯
* @property int $staff_educate 教育水平：0无，1小学，2初中，3高中，4专科，5本科，6本科以上
* @property string $staff_skill 特长/技能
* @property string $staff_crime_record 犯罪记录
* @property string $staff_sin_record 不良习惯
* @property string $staff_health_img 健康证
    * @property int $staff_province 省
* @property int $staff_city 市
* @property int $staff_district 区
* @property YxStaffImg[] $yxStaffImgs
* @property YxStaffRes[] $yxStaffRes
 * @property YxStaffServer[] $yxStaffServers
 * @property YxServer[] $servers
 */
class YxStaff extends \yii\db\ActiveRecord
{
    #总成交量
    public $clinch;
    #总成交金额
    public $price;
    #上月成交量
    public $pre_clinch;
    #上月成交金额
    public $pre_price;
    #公司名
    public $companyName;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['staff_found'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    // public function attributes(){
    //     return
    // }
    public static function tableName()
    {
        return 'yx_staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_name', 'staff_sex', 'staff_age', 'staff_idcard', 'staff_state', 'staff_img', 'staff_idcard_front', 'staff_idcard_back','staff_address', 'staff_health_img','staff_number','staff_province', 'staff_city', 'staff_district'], 'required'],
            [['company_id', 'staff_sex', 'staff_found', 'staff_main_server_id','staff_fraction', 'staff_base_fraction', 'staff_history_fraction', 'staff_clinch', 'staff_price', 'staff_manage_time', 'staff_educate', 'staff_login_time','staff_province', 'staff_city', 'staff_district','ext_fraction','ext_history_fraction'], 'integer'],
            [['staff_name'], 'string', 'max' => 50],
            [['staff_idcard'], 'string','min'=>18,'max' => 18],
            [['staff_intro','staff_train','staff_memo','staff_query'], 'string', 'max' => 1000],
            [['staff_state'], 'string', 'max' => 1],
            [['staff_login_ip'], 'string', 'max' => 45],
            [['staff_skill', 'staff_crime_record', 'staff_sin_record'], 'string', 'max' => 255],
            [['staff_all_server_id'], 'validateSASID'],
        ];
    }


    /**
     * [validateSASID 验证服务上限]
     * @Author   Yoon
     * @DateTime 2018-03-13T15:56:32+0800
     * @param    [type]                   $attribute [当前验证的参数]
     * @param    [type]                   $params    [所有参数]
     * @return   [type]                              [description]
     */
    public function validateSASID($attribute, $params)
    {
        $staff_all_server_id = $this->$attribute;
        if(substr_count($staff_all_server_id,',')>3){
            $this->addError($attribute, "最多选中四个服务");
            return false;
        }
        $arr_server_id=explode(',', $staff_all_server_id);
        if(!empty($arr_server_id)){
            foreach ($arr_server_id as $key => $value) {
                if($this->staff_main_server_id==$value){
                    $this->addError($attribute, "主打服务与副服务不能相同");
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'ID',
            'company_id' => '所属商家ID',
            'staff_name' => '姓名',
            'staff_sex' => '性别',
            'staff_age' => '出生日期',
            'staff_img' => '照片',
            'staff_idcard' => '身份证号码',
            'staff_intro' => '简介',
            'staff_found' => '创建时间',
            'staff_state' => '状态',
            'staff_memo' => '备注',
            'staff_login_ip' => '登陆ip',
            'staff_login_time' => '登陆时间',
            'companyName' => '所属公司',
            'pre_clinch' => '上月成交量',
            'pre_price' => '上月成交金额',
            'staff_main_server_id' => '主打服务',
            'staff_all_server_id' => '副服务',
           'staff_query' => '搜索关键词',
            'staff_fraction' => '总分数',
           'staff_base_fraction' => '基础分数',
           'staff_history_fraction' => '历史运营分数',
           'staff_clinch' => '总成交量',
           'staff_price' => '总成交金额',
           'staff_manage_time' => '从业时长',
           'staff_idcard_front' => '身份证正面',
           'staff_idcard_back' => '身份证反面',
           'staff_address' => '籍贯',
           'staff_educate' => '教育水平',
           'staff_skill' => '特长/技能',
           'staff_crime_record' => '犯罪记录',
           'staff_sin_record' => '不良习惯',
           'staff_health_img' =>'健康证',
           'staff_train'=>'培训说明',
            'staff_province' => '省',
           'staff_city' => '市',
           'staff_district' => '区',
           'staff_number' => '员工编号',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
   public function getYxStaffImgs()
   {
       return $this->hasMany(YxStaffImg::className(), ['staff_id' => 'staff_id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getYxStaffRes()
   {
       return $this->hasMany(YxStaffRes::className(), ['staff_id' => 'staff_id']);
   }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYxStaffServers()
    {
        return $this->hasMany(YxStaffServer::className(), ['staff_id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServers()
    {
        return $this->hasMany(YxServer::className(), ['server_id' => 'server_id'])->viaTable('yx_staff_server', ['staff_id' => 'staff_id']);
    }

    /**
     * @inheritdoc
     * @return YxStaffQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxStaffQuery(get_called_class());
    }
    public static function getCmpSexName($models)
    {
        $types = self::getCmpSex();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getCmpSex()
    {
        return array(1 => '男', 2 => '女');
    }
    public static function getCmpStateName($models)
    {
        $types = self::getCmpState();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getCmpState()
    {
        return array(1 => '空闲', 2 => '工作中', 3 => '休假', 0 => '退出平台');
    }

    public static function getStaffEducateName($models)
    {
        $types = self::getStaffEducate();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getStaffEducate()
    {
        return array(0=>'无',1=>'小学',2=>'初中',3=>'高中',4=>'专科',5=>'本科',6=>'本科以上');
    }

    public static function getStaffTimeName($models)
    {
        $types = self::getStaffTime();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getStaffTime()
    {
        return array(0=>'一年以下',1=>'一年以上',3=>'三年以上',5=>'五年以上');
    }

    public static function getCmpServerName($models)
    {
        $types = self::getCmpServer();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getCmpServer()
    {
        $result = YxServer::find()->where(['server_type' => 1])->all();
        $arr_Parent = [];
        if (empty($result)) {
            return $arr_Parent;
        }

        foreach ($result as $key => $value) {
            $arr_Parent[$value['server_id']] = $value['server_name'];
        }
        return $arr_Parent;
    }

    public static function getAllServer($staff_all_server_id){
        $arr_server_id=explode(',', $staff_all_server_id);
        $serverName='';
        foreach ($arr_server_id as $key => $value) {
            $server=YxServer::find()->where(['server_id'=>$value])->one();
            if($key==0){
                $serverName=$server['server_name'];
            }else{
                $serverName=$serverName.','.$server['server_name'];
            }
        }
        return $serverName;
    }

    static public function getStaffNumber($region_id=0){
        $type = Region::getOneType($region_id);
        $sum = self::find()->where(['staff_district' => $region_id])->count();
        $sum=$sum+1;
        $number = '';
        $arr_0=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $floor_int=$sum;
        $count_26='';
        do{

            $mod_int=$floor_int%26;
            $floor_int=$floor_int/26;
            if($mod_int==0){
                $mod_int=26;
            }
            $count_26=$arr_0[$mod_int-1].$count_26;
            if($floor_int<26&&$floor_int>0&&$mod_int==26){
                $count_26=$arr_0[$floor_int-1].$count_26;
            }
            if($floor_int<26&&$floor_int>0&&$mod_int!=26){
                $count_26=$arr_0[$floor_int].$count_26;
            }
        }while ( $floor_int>26);

        $count_26_len=strlen($count_26);

        if($count_26_len==1){
            $number=$type.'aa'.$count_26;
        }elseif ($count_26_len==2) {
            $number=$type.'a'.$count_26;
        }elseif ($count_26_len==3) {
            $number=$type.$count_26;
        }
        $number=preg_replace('# #','',$number);
        return $number;
    }



/**
 * [getClinch 取订单完成量]
 * @Author   Yoon
 * @DateTime 2018-04-09T15:52:23+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public static function getClinch($id)
    {
        $clinch_count=YxOrder::find()->where(['yx_staff_id'=>$id,'order_state'=>'2'])->count();
        if(empty($clinch_count)) $clinch_count=0;
        $model=self::findOne($id);
        $model->staff_clinch=$clinch_count;
        $model->save();
        return $clinch_count;
    }
/**
 * [getPrice 取订单完成总金额]
 * @Author   Yoon
 * @DateTime 2018-04-09T15:53:22+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public static function getPrice($id)
    {
        $price_count=YxOrder::find()->where(['yx_staff_id'=>$id,'order_state'=>'2'])->sum('order_money');
        if(empty($price_count)) $price_count=0;
        $model=self::findOne($id);
        $model->staff_price=$price_count;
        $model->save();
        return $price_count;
    }
/**
 * [getPreClinch 取上月订单完成量]
 * @Author   Yoon
 * @DateTime 2018-04-09T15:52:23+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public static function getPreClinch($id)
    {
        $date=date('Y-m');
        $pre_month=strtotime($date);
        $now_month=strtotime("$date +1 month");
        $clinch_count=YxOrder::find()->where(['yx_staff_id'=>$id,'order_state'=>'2']) ->andFilterWhere(['between', 'time_end', $pre_month,$now_month])->count();
        if(empty($clinch_count)) $clinch_count=0;
        return $clinch_count;
    }
/**
 * [getPrePrice 取上月完成总金额]
 * @Author   Yoon
 * @DateTime 2018-04-09T15:53:22+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public static function getPrePrice($id)
    {
        $date=date('Y-m');
        $pre_month=strtotime($date);
        $now_month=strtotime("$date +1 month");
        $price_count=YxOrder::find()->where(['yx_staff_id'=>$id,'order_state'=>'2']) ->andFilterWhere(['between', 'time_end', $pre_month,$now_month])->sum('order_money');
        if(empty($price_count)) $price_count=0;
        return $price_count;
    }


    // 得到服务人员名字(oyzx)
    public static function getStaffName($staff_id) {
      $staff = YxStaff::find()->where(['staff_id'=>$staff_id])->one();
      return $staff['staff_name'];
    }
    // 得到服务人员所在公司名(oyzx)
    public static function getCompanyName($staff_id) {
      $YxStaff = YxStaff::find()->where(['staff_id'=>$staff_id])->one();
      $company_name = YxCompany::find()->where(['id'=>$YxStaff['company_id']])->one();
      return $company_name['name'];
    }
    // 得到服务人员的所有服务类型(字符串形式)(oyzx)
    public static function getServerName($staff_id) {
      $YxStaffServer = YxStaffServer::getServerAll($staff_id);
      $serverName = "";
      foreach ($YxStaffServer as $key => $value) {
        if($key == 0) {
          $serverName = $serverName.$value['server_name'];
          continue;
        }
        $serverName = $serverName."、".$value['server_name'];
      }
      return $serverName;
    }

    // 在线英文星期转中文星期
    public static function getChineseWeek($week) {
      switch( $week ){
        case 1 : return "星期一";
        case 2 : return "星期二";
        case 3 : return "星期三";
        case 4 : return "星期四";
        case 5 : return "星期五";
        case 6 : return "星期六";
        case 0 : return "星期日";
        default : return "你输入有误！";
      };
    }
}
