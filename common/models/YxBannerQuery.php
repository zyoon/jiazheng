<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxBanner]].
 *
 * @see YxBanner
 */
class YxBannerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return YxBanner[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return YxBanner|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
