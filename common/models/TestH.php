<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test_h".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $img_url 图片
 */
class TestH extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_h';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	    [['img_url'], 'required'],
            [['name'], 'string', 'max' => 45],
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
            'img_url' => '图片',
        ];
    }

    /**
     * @inheritdoc
     * @return TestHQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestHQuery(get_called_class());
    }
}
