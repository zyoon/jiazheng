<?php

namespace common\models;

use common\models\Region;
use common\models\YxServer;
use common\models\YxStaff;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yx_company".
 *
 * @property int $id
 * @property string $name 公司名
 * @property int $province 省
 * @property int $city 市
 * @property int $district 区
 * @property string $address 详细地址
 * @property string $telephone 固定电话
 * @property string $charge_phone 负责人电话
 * @property string $charge_man 负责人
 * @property double $longitude 经度
 * @property double $latitude 维度
 * @property double $operating_radius 服务半径/米
 * @property string $wechat 微信
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property string $number 商家编号
 * @property int $status 状态：1打烊，2营业，10停业整改
 * @property string $business_licences 营业执照
 * @property int $models 营业模式: 1公司制，2中介制
 * @property string $introduction 公司简介
 * @property string $main_server_id 主打服务
 * @property string $all_server_id 副服务
 * @property string $query 搜索关键词
 * @property int $cmp_user_id 公司用户ID
 * @property int $base_fraction 公司基础分数
 * @property int $history_fraction 公司历史运营分数
 * @property int $clinch 公司总成交量
 * @property int $price 公司总成交金额
 * @property int $manage_time 经营时长
 * @property string $banck_card 银行卡号
 * @property string $alipay 支付宝账号
 * @property string $business_code 营业执照编码
 *
 * @property YxCmpRes[] $yxCmpRes
 * @property YxCmpUser[] $yxCmpUsers
 * @property YxStaffVerify[] $yxStaffVerifies
 */
class YxCompany extends \yii\db\ActiveRecord
{
    #上月成交量
    public $pre_clinch;
    #上月成交金额
    public $pre_price;
    #省名
    public $provinceName;
    #市名
    public $cityName;
    #区名
    public $districtName;
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
        return 'yx_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'telephone', 'charge_phone', 'charge_man', 'wechat', 'image','main_server_id'], 'required'],
            [['total_fraction', 'province', 'city', 'district', 'created_at', 'updated_at', 'status', 'models', 'base_fraction', 'history_fraction', 'clinch', 'price', 'banck_card','ext_fraction','ext_history_fraction'], 'integer'],
            [['longitude', 'latitude', 'operating_radius'], 'number'],
            [['name', 'telephone', 'wechat', 'number'], 'string', 'max' => 20],
            [['address', 'query'], 'string', 'max' => 200],
            [['charge_phone', 'alipay'], 'string', 'max' => 30],
            [['charge_man'], 'string', 'max' => 10],
            [['all_server_id', 'main_server_id', 'alipay', 'business_code'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['all_server_id'], 'validateSASID'],
            [['main_server_id'], 'validateSMSID'],
            [['business_licences'],'safe']
        ];
    }
    /**
     * [validateSASID 验证服务重复]
     * @Author   Yoon
     * @DateTime 2018-03-13T15:56:32+0800
     * @param    [type]                   $attribute [当前验证的参数]
     * @param    [type]                   $params    [所有参数]
     * @return   [type]                              [description]
     */
    public function validateSASID($attribute, $params)
    {
        $all_server_id = $this->$attribute;
        $main_server_id = $this->main_server_id;

        $arr_all_server_id = explode(',', $all_server_id);
        $arr_main_server_id = explode(',', $main_server_id);

        if (!empty($arr_all_server_id)) {
            foreach ($arr_main_server_id as $key => $value) {
                foreach ($arr_all_server_id as $key2 => $value2) {
                    if ($value2 == $value) {
                        $this->addError($attribute, "主打服务与副服务不能相同");
                        return false;
                    }
                }

            }
        }
        return true;
    }
    /**
     * [validateSMSID 验证服务上限]
     * @Author   Yoon
     * @DateTime 2018-03-13T15:56:32+0800
     * @param    [type]                   $attribute [当前验证的参数]
     * @param    [type]                   $params    [所有参数]
     * @return   [type]                              [description]
     */
    public function validateSMSID($attribute, $params)
    {
        $main_server_id = $this->$attribute;
        //$all_server_id= $this->$all_server_id;

        if (substr_count($main_server_id, ',') > 2) {
            $this->addError($attribute, "最多选中三个服务");
            return false;
        }
        return true;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '公司名',
            'image' => "门户图片",
            'total_fraction' => "总分数",
            'province' => '省',
            'city' => '市',
            'district' => '区',
            'address' => '详细地址',
            'telephone' => '固定电话',
            'charge_phone' => '负责人电话',
            'charge_man' => '负责人',
            'longitude' => '经度',
            'latitude' => '维度',
            'operating_radius' => '服务半径/米',
            'wechat' => '微信',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'number' => '商家编号',
            'status' => '状态',
            'business_licences' => '营业执照',
            'models' => '营业模式',
            'introduction' => '公司介绍',
            'main_server_id' => '主打服务',
            'all_server_id' => '副服务',
            'query' => '搜索关键词',
            'cmp_user_id' => '公司用户ID',
            'base_fraction' => '公司基础分数',
            'history_fraction' => '公司历史运营分数',
            'manage_time' => '经营时长',
            'clinch' => '总成交量',
            'price' => '总成交金额',
            'pre_clinch' => '上月成交量',
            'pre_price' => '上月成交金额',
            'provinceName' => '省',
            'cityName' => '市',
            'districtName' => '区',
            'banck_card' => '银行卡号',
            'alipay' => '支付宝账号',
            'business_code' => '营业执照编码',
            'ext_fraction'=>'审核额外加分',
            'ext_history_fraction'=>'额外运营分数'
        ];
    }

    /**
     * @inheritdoc
     * @return YxCompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxCompanyQuery(get_called_class());
    }
    public static function getCmpStatusName($status)
    {
        $types = self::getCmpStatus();
        if (isset($types[$status])) {
            return $types[$status];
        }

        return '未知';
    }
    public static function getCmpStatus()
    {
        return array(1 => '已打烊', 2 => '营业中', 10 => '停业整改');
    }
    public static function getCmpModelsName($models)
    {
        $types = self::getCmpModels();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getCmpModels()
    {
        return array(1 => '公司制', 2 => '中介制');
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
    /**
     * [getAllServer 取所有一级服务]
     * @Author   Yoon
     * @DateTime 2018-04-21T16:01:56+0800
     * @param    [type]                   $all_server_id [description]
     * @return   [type]                                  [description]
     */
    public static function getAllServer($all_server_id)
    {
        $arr_server_id = explode(',', $all_server_id);
        $serverName = '';
        foreach ($arr_server_id as $key => $value) {
            $server = YxServer::find()->where(['server_id' => $value])->one();
            if ($key == 0) {
                $serverName = $server['server_name'];
            } else {
                $serverName = $serverName . ',' . $server['server_name'];
            }
        }
        return $serverName;
    }
/**
 * [getPreClinch 取订单完成量]
 * @Author   Yoon
 * @DateTime 2018-04-09T15:52:23+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public static function getClinch($id)
    {
        $clinch_count=YxOrder::find()->where(['yx_company_id'=>$id,'order_state'=>'2'])->count();
        if(empty($clinch_count)) $clinch_count=0;
        $model=self::findOne($id);
        $model->clinch=$clinch_count;
        $model->save();
        return $clinch_count;
    }
/**
 * [getPrePrice 取订单完成总金额]
 * @Author   Yoon
 * @DateTime 2018-04-09T15:53:22+0800
 * @param    [type]                   $id [description]
 * @return   [type]                       [description]
 */
    public static function getPrice($id)
    {
        $price_count=YxOrder::find()->where(['yx_company_id'=>$id,'order_state'=>'2'])->sum('order_money');
        if(empty($price_count)) $price_count=0;
        $model=self::findOne($id);
        $model->price=$price_count;
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
        $clinch_count=YxOrder::find()->where(['yx_company_id'=>$id,'order_state'=>'2']) ->andFilterWhere(['between', 'time_end', $pre_month,$now_month])->count();
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
        $price_count=YxOrder::find()->where(['yx_company_id'=>$id,'order_state'=>'2']) ->andFilterWhere(['between', 'time_end', $pre_month,$now_month])->sum('order_money');
        if(empty($price_count)) $price_count=0;
        return $price_count;
    }
/**
 * [setKeywords 设置关键词]
 * @Author   Yoon
 * @DateTime 2018-04-21T17:05:03+0800
 */
  public function setKeywords(){
    $keywords="";
    $cmpServer_model=YxCmpServer::find()->where(['company_id'=>$this->id])->all();
    $str_server_id=$this->main_server_id;
    if(!empty($this->all_server_id)||!isset($this->all_server_id)){
        $str_server_id=$this->main_server_id.",".$this->all_server_id;
    }
    $keywords=YxStaff::getAllServer($str_server_id);
    if(isset($cmpServer_model)&&!empty($cmpServer_model)){
        foreach ($cmpServer_model as $key => $value) {
            $keywords=$keywords.",".$value['server']['server_name'];
        }
    }

    $this->query=$keywords;
    $this->save();
  } 




    public static function getOneName($id = 0)
    {
        $result = static::findOne($id);
        return $result->name;
    }
    public function getYxCmpRes()
    {
        return $this->hasMany(YxCmpRes::className(), ['company_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYxCmpUsers()
    {
        return $this->hasMany(YxCmpUser::className(), ['company_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYxStaffVerifies()
    {
        return $this->hasMany(YxStaffVerify::className(), ['company_id' => 'id']);
    }

    public static function getCmpNumber($id)
    {
        $type = Region::getOneType($id);
        $sum = self::find()->where(['district' => $id])->count();
        $sum=$sum+1;
        $number = '';
        $arr_0=array('0','00');
        if($sum>0&&$sum<10){
            $number=$type.$arr_0['1'].$sum;
        }elseif($sum>=10&&$sum<100){
            $number=$type.$arr_0['0'].$sum;
        }elseif ($sum>=100&&$sum<1000) {
            $number=$type.$sum;
        }
        $number=preg_replace('# #','',$number);
        return $number;
    }


    // 根据商家id得到商家名（oyzx)
    public static function getCompanyName($companyId) {
      $YxCompany = YxCompany::find()->where(['id' => $companyId])->one();
      return $YxCompany['name'];
    }
}
