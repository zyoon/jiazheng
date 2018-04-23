<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_user_address".
 *
 * @property int $id
 * @property int $yx_user_id
 * @property int $province 省份
 * @property int $city 城市
 * @property int $district 区县
 * @property string $phone 联系电话
 * @property string $address 详细地址
 * @property string $consignee 收货人
 * @property int $is_delete 1:有效,2:删除
 * @property int $is_main 1:默认,2:其他
 */
class YxUserAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'yx_user_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province', 'city', 'district', 'phone', 'address', 'consignee'], 'required'],
            [['yx_user_id', 'province', 'city', 'district', 'is_delete', 'is_main'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['consignee'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'yx_user_id' => '用户ID',
            'yx_username'=>'用户账号',
            'yx_nickname'=>'用户昵称',
            'province' => '省份',
            'city' => '城市',
            'district' => '区县',
            'phone' => '联系电话',
            'address' => '详细地址',
            'consignee' => '收货人',
            'is_delete' => '1:有效,2:删除',
            'is_main' => '是否为默认地址',
        ];
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
    public static function getIsMain()
    {
        return array(1 => '是', 2 => '否');
    }

}
