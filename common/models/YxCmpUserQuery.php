<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxCmpUser]].
 *
 * @see YxCmpUser
 */
class YxCmpUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return YxCmpUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return YxCmpUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
