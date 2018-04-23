<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_activity".
 *
 * @property int $activity_id
 * @property string $activity_pic 活动图片
 * @property string $activity_href 图片跳转链接
 */
class YxActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_pic', 'activity_href'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'Activity ID',
            'activity_pic' => '活动图片',
            'activity_href' => '图片跳转链接',
        ];
    }

    /**
     * @inheritdoc
     * @return YxActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxActivityQuery(get_called_class());
    }
}
