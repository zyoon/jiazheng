<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_staff_res".
 *
 * @property int $staff_res_id
 * @property int $staff_id
 * @property string $staff_res_img 员工成果图
 */
class YxStaffRes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yx_staff_res';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id'], 'integer'],
            [['staff_res_img'], 'string', 'max' => 255],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxStaff::className(), 'targetAttribute' => ['staff_id' => 'staff_id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staff_res_id' => 'ID',
            'staff_id' => '员工ID',
            'staff_res_img' => '成果图',
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
     * @return YxStaffResQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxStaffResQuery(get_called_class());
    }
}
