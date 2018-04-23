<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_rules".
 *
 * @property int $rules_id
 * @property string $rules_title 规则标题
 * @property string $rules_content 规则内容
 */
class YxRules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_rules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rules_content'], 'string'],
            [['rules_type'], 'integer'],
            [['rules_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rules_id' => 'Rules ID',
            'rules_title' => '规则标题',
            'rules_content' => '规则内容',
            'rules_type' => '类型',
        ];
    }

    /**
     * @inheritdoc
     * @return YxRulesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxRulesQuery(get_called_class());
    }
    public static function getName($models,$ClassName,...$params)
    {
        $types = self::$ClassName(...$params);

        if (isset($types[$models])) {
            return $types[$models];
        }
        return '未知';
    }

    public static function getRulesTypeMap()
    {
        return array('1' => '规则', '2' => '信息攻略', '3' => '商家入驻', '4' => '联系客服','5'=>'关于我们');
    }
}
