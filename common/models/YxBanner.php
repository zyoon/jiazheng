<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_banner".
 *
 * @property int $banner_id
 * @property string $banner_pic 广告轮播图
 * @property string $banner_href 图片跳转链接
 */
class YxBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yx_banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['banner_id'], 'required'],
            [['banner_id'], 'integer'],
            [['banner_pic', 'banner_href'], 'string', 'max' => 255],
            [['banner_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'banner_id' => 'Banner ID',
            'banner_pic' => '广告轮播图',
            'banner_href' => '图片跳转链接',
        ];
    }

    /**
     * @inheritdoc
     * @return YxBannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YxBannerQuery(get_called_class());
    }
}
