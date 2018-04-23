<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_recom_right".
 *
 * @property int $recom_right_id
 * @property string $recom_right_pic 右部推荐图片路径
 * @property string $recom_right_href 图片跳转链接
 */
class YxRecomRight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_recom_right';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recom_right_pic', 'recom_right_href'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recom_right_id' => 'Recom Right ID',
            'recom_right_pic' => '右部推荐图片',
            'recom_right_href' => '图片跳转链接',
        ];
    }

    /**
     * @inheritdoc
     * @return YxRecomRightQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxRecomRightQuery(get_called_class());
    }
}
