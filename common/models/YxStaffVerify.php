<?php

namespace common\models;

use common\models\YxStaff;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yx_staff_verify".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $company_id 服务人员所属商家
 * @property string $staff_name 服务人员姓名
 * @property int $staff_sex 服务人员性别(1:男，2:女)
 * @property int $staff_age 服务人员年龄
 * @property string $staff_img 服务人员照片
 * @property string $staff_idcard 服务人员的身份证号码
 * @property string $staff_intro 服务人员简介
 * @property string $staff_found 服务人员创建时间
 * @property string $staff_state 服务人员的状态(1:空闲,2:工作中,3:休假,0:退出平台)
 * @property string $staff_memo 备注
 * @property string $staff_login_ip 服务人员登陆ip(记入最新的登陆ip,把上一次登录ip写入日志文件中)
 * @property string $staff_login_time 服务人员登陆时间(记入最新的登陆时间,把上一次登录时间写入日志文件中)
 * @property int $staff_main_server_id
 * @property string $staff_all_server_id
 * @property string $staff_query 搜索关键词
 * @property int $staff_verify_state 审核状态：1待审核，2未通过，3已通过
 * @property string $staff_verify_memo 驳回意见
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
 */
class YxStaffVerify extends \yii\db\ActiveRecord
{
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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_staff_verify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'staff_name', 'staff_sex', 'staff_age', 'staff_idcard', 'staff_img', 'staff_state', 'staff_idcard', 'staff_idcard_front', 'staff_idcard_back', 'staff_health_img','staff_address','staff_province', 'staff_city', 'staff_district'], 'required'],
            [['id', 'staff_id', 'company_id', 'staff_sex', 'staff_found', 'staff_main_server_id', 'staff_verify_state','staff_fraction', 'staff_base_fraction', 'staff_history_fraction', 'staff_clinch', 'staff_price', 'staff_manage_time', 'staff_educate', 'staff_province', 'staff_city', 'staff_district'], 'integer'],
            [['staff_query', 'staff_verify_memo'], 'string'],
            [['staff_name'], 'string', 'max' => 50],
            [['staff_idcard'], 'string','min'=>18,'max' => 18],
            [['staff_intro', 'staff_memo'], 'string', 'max' => 1000],
            [['staff_state'], 'string', 'max' => 1],
            [['staff_login_ip','staff_train', 'staff_login_time'], 'string', 'max' => 45],
            [['id','staff_number'], 'unique'],
            [['staff_all_server_id'], 'validateSASID'],
            [['staff_skill', 'staff_crime_record', 'staff_sin_record'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxCompany::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['staff_idcard'], 'validateUnique'],
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
        if (substr_count($staff_all_server_id, ',') > 3) {
            $this->addError($attribute, "最多选中四个服务");
            return false;
        }
        $arr_server_id = explode(',', $staff_all_server_id);
        if (!empty($arr_server_id)) {
            foreach ($arr_server_id as $key => $value) {
                if ($this->staff_main_server_id == $value) {
                    $this->addError($attribute, "主打服务与副服务不能相同");
                    return false;
                }
            }
        }

        return true;
    }
    /**
     * [validateUnique 验证服务者是否被录入]
     * @Author   Yoon
     * @DateTime 2018-03-13T15:56:32+0800
     * @param    [type]                   $attribute [当前验证的参数]
     * @param    [type]                   $params    [所有参数]
     * @return   [type]                              [description]
     */
    public function validateUnique($attribute, $params)
    {
        $staff_idcard = $this->$attribute;
        $company_id = $this->company_id;
        $staff_id = $this->staff_id;
        if (empty($staff_id)) {
            $res = YxStaff::find()->where(['company_id' => $company_id, 'staff_idcard' => $staff_idcard])->one();
            if ($res) {
                $this->addError($attribute, "此身份证号已被录入");
                return false;
            }
            if($this->staff_verify_state==1){
                $res2 = self::find()->where(['company_id' => $company_id, 'staff_idcard' => $staff_idcard, 'staff_verify_state' => 1])->one();
                if ($res2) {
                    $this->addError($attribute, "此员工正在审核中");
                    return false;
                }
            }
        } else {
            $res = YxStaff::find()->where(['company_id' => $company_id, 'staff_idcard' => $staff_idcard])->one();
            if ($res && $staff_id != $res->staff_id) {
                $this->addError($attribute, "此身份证号已被录入");
                return false;
            }
            if($this->staff_verify_state==1){
                $res2 = self::find()->where(['company_id' => $company_id, 'staff_id' => $staff_id, 'staff_verify_state' => 1])->one();
                if ($res2) {
                    $this->addError($attribute, "此员工正在审核中");
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
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'company_id' => '所属商家',
            'staff_name' => '姓名',
            'staff_sex' => '性别',
            'staff_age' => '出生日期',
            'staff_img' => '照片',
            'staff_idcard' => '身份证号码',
            'staff_intro' => '简介',
            'staff_found' => '创建时间',
            'staff_state' => '状态',
            'staff_memo' => '备注',
            'staff_login_ip' => '最近登陆ip',
            'staff_login_time' => '最近登陆时间',
            'staff_main_server_id' => '主打服务',
            'staff_all_server_id' => '副服务',
            'staff_query' => '搜索关键词',
            'staff_verify_state' => '审核状态',
            'staff_verify_memo' => '驳回意见',
            'staff_fraction' => '总分数', 
           'staff_base_fraction' => '基础分数', 
           'staff_history_fraction' => '运营分数', 
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
           'staff_health_img' => '健康证', 
           'staff_train'=>'培训说明',
            'staff_province' => '省',
           'staff_city' => '市',
           'staff_district' => '区',
        ];
    }
    public function getCompany()
    {
        return $this->hasOne(YxCompany::className(), ['id' => 'company_id']);
    }

    public static function getVerifyStateName($status)
    {
        $types = self::getVerifyState();
        if (isset($types[$status])) {
            return $types[$status];
        }

        return '未知';
    }
    public static function getVerifyState()
    {
        return array(1 => '待审核', 2 => '未通过', 3 => '已通过');
    }
    /**
     * @inheritdoc
     * @return YxStaffVerifyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxStaffVerifyQuery(get_called_class());
    }
}
