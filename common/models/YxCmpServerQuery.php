<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxCmpServer]].
 *
 * @see YxCmpServer
 */
class YxCmpServerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return YxCmpServer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return YxCmpServer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
