<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_cmp_res".
 *
 * @property int $cmp_res_id
 * @property int $company_id
 * @property string $cmp_res_img 公司成果图
 */
class YxCmpRes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yx_cmp_res';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['cmp_res_img'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => YxCompany::className(), 'targetAttribute' => ['company_id' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cmp_res_id' => 'ID',
            'company_id' => '公司ID',
            'cmp_res_img' => '成果图',
        ];
    }
    
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getCompany() 
   { 
       return $this->hasOne(YxCompany::className(), ['id' => 'company_id']); 
   }
    /**
     * {@inheritdoc}
     * @return YxCmpResQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxCmpResQuery(get_called_class());
    }
}
