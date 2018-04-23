<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "yx_company_verify".
 *
 * @property int $company_id
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
 * @property int $verify_sate 审核状态:1待审核；2未通过；3已通过
 * @property string $verify_memo 审核建议 
 * @property int $id 
* @property string $main_server_id 主打服务
* @property string $all_server_id 副服务
* @property string $query 搜索关键词
* @property int $cmp_user_id 公司用户ID
* @property string $image 公司门户图片
* @property int $total_fraction 总分数
* @property int $base_fraction 公司基础分数
* @property int $history_fraction 公司历史运营分数
* @property int $clinch 公司总成交量
* @property int $price 公司总成交金额
* @property int $manage_time 经营时长
* @property string $banck_card 银行卡号
* @property string $alipay 支付宝账号
* @property string $business_code 营业执照编码

 */
class YxCompanyVerify extends \yii\db\ActiveRecord
{
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
        return 'yx_company_verify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'telephone', 'charge_phone', 'charge_man', 'wechat', 'image'], 'required'],
            [['company_id', 'province', 'city', 'district', 'created_at', 'updated_at', 'status', 'models', 'verify_sate', 'id', 'cmp_user_id', 'total_fraction', 'base_fraction', 'history_fraction', 'clinch', 'price', 'manage_time', 'banck_card','ext_fraction'], 'integer'],
            [['longitude', 'latitude', 'operating_radius'], 'number'],
            [['introduction', 'verify_memo', 'query'], 'string'],
            [['name', 'telephone', 'wechat', 'number'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 200],
            [['charge_phone'], 'string', 'max' => 30],
            [['charge_man'], 'string', 'max' => 10],
            [['id'], 'unique'],
            [['main_server_id', 'all_server_id', 'alipay', 'business_code'], 'string', 'max' => 255],
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
        $main_server_id=$this->main_server_id;

        $arr_all_server_id=explode(',', $all_server_id);
        $arr_main_server_id=explode(',', $main_server_id);

        if(!empty($arr_all_server_id)){
            foreach ($arr_main_server_id as $key => $value) {
                foreach ($arr_all_server_id as $key2 => $value2) {
                    if($value2==$value){
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

        if(substr_count($main_server_id,',')>2){
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
            'company_id' => '公司ID',
            'name' => '公司名',
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
            'introduction' => '公司简介',
            'verify_sate' => '审核状态',
            'provinceName'=>'省',
            'cityName'=>'市',
            'districtName'=>'区',
            'verify_memo' => '审核建议',
            'id' => 'ID',
            'main_server_id' => '主打服务', 
           'all_server_id' => '副服务', 
           'query' => '搜索关键词',
            'cmp_user_id' => '公司管理员ID',
           'image' => '公司门户图片',
           'total_fraction' => '总分数',
           'base_fraction' => '公司基础分数',
           'history_fraction' => '公司历史运营分数',
           'clinch' => '公司总成交量',
           'price' => '公司总成交金额',
           'manage_time' => '经营时长',
           'banck_card' => '银行卡号',
           'alipay' => '支付宝账号',
           'business_code' => '营业执照编码',
        ];
    }
    public static function getVerifyStateName($status)
    {
      $types = self::getVerifyState();
      if (isset($types[$status])) return $types[$status];
      return '未知';
    }
    public static function getVerifyState() {
        return array( 1=>'待审核', 2=>'未通过', 3=>'已通过');
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
    /**
     * @inheritdoc
     * @return YxCompanyVerifyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxCompanyVerifyQuery(get_called_class());
    }
}
