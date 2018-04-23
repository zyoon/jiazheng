<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[YxStaffServer]].
 *
 * @see YxStaffServer
 */
class YxStaffServerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return YxStaffServer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return YxStaffServer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
