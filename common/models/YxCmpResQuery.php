<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxCmpRes]].
 *
 * @see YxCmpRes
 */
class YxCmpResQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return YxCmpRes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return YxCmpRes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
