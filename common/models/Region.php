<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $level
 * @property string $type 地区编码
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'parent_id', 'level'], 'required'],
            [['id', 'parent_id', 'level'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'parent_id' => '上级ID',
            'level' => '等级',
            'type' => '地区编码',
        ];
    }

    /**
     * @inheritdoc
     * @return RegionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegionQuery(get_called_class());
    }

    public static function getRegion($parentId = 0)
    {
        $result = static::find()->where(['parent_id' => $parentId])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($result, 'id', 'name');
    }
    public static function getOneName($id = 0)
    {
        $result = static::findOne($id);
        if ($result) {
            return $result->name;
        }

    }
    public static function getOneType($id = 0)
    {
        $result = static::findOne($id);
        return $result->type;
    }
}
