<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_recom_left".
 *
 * @property int $recom_left_id
 * @property string $recom_left_pic 左部推荐图片路径
 * @property string $recom_left_href 图片跳转链接
 */
class YxRecomLeft extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_recom_left';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recom_left_pic', 'recom_left_href'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recom_left_id' => 'Recom Left ID',
            'recom_left_pic' => '左部推荐图',
            'recom_left_href' => '图片跳转链接',
        ];
    }

    /**
     * @inheritdoc
     * @return YxQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxQuery(get_called_class());
    }
}
