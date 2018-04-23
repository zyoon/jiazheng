<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxStaffVerify]].
 *
 * @see YxStaffVerify
 */
class YxStaffVerifyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return YxStaffVerify[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return YxStaffVerify|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
