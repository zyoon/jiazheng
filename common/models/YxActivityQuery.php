<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxActivity]].
 *
 * @see YxActivity
 */
class YxActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return YxActivity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return YxActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
