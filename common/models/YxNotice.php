<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_notice".
 *
 * @property int $notice_id
 * @property string $notice_title 公告标题
 * @property string $notice_content 公告内容
 * @property string $notice_state 公告状态：1上架，2下架
 */
class YxNotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_content'], 'string'],
            [['notice_title', 'notice_state'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_id' => 'Notice ID',
            'notice_title' => '公告标题',
            'notice_content' => '公告内容',
            'notice_state' => '公告状态',
        ];
    }


    public static function getStateName($models)
    {
        $types = self::getState();
        if (isset($types[$models])) {
            return $types[$models];
        }

        return '未知';
    }
    public static function getState()
    {
        return array(1 => '上架', 2 => '下架');
    }
    /**
     * @inheritdoc
     * @return YxNoticeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxNoticeQuery(get_called_class());
    }
}
