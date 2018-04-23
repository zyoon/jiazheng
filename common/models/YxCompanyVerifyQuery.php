<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxCompanyVerify]].
 *
 * @see YxCompanyVerify
 */
class YxCompanyVerifyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return YxCompanyVerify[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return YxCompanyVerify|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
