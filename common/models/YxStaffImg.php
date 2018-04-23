<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_staff_img".
 *
 * @property int $id
 * @property int $staff_id 服务者ID
 * @property string $image 图片路径
 * @property int $verify_state 审核：1待审核，2已通过，3未通过
 *
 * @property YxStaff $staff
 */
class YxStaffImg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yx_staff_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'verify_state', 'staff_verify_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxStaff::className(), 'targetAttribute' => ['staff_id' => 'staff_id']],
            [['staff_verify_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxStaffVerify::className(), 'targetAttribute' => ['staff_verify_id' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => '服务者ID',
            'image' => '相关证书',
            'verify_state' => '审核：1待审核，2已通过，3未通过',
            'staff_verify_id' => 'Staff Verify ID', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(YxStaff::className(), ['staff_id' => 'staff_id']);
    }

    /**
     * {@inheritdoc}
     * @return YxStaffImgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxStaffImgQuery(get_called_class());
    }
}
