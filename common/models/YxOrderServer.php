<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yx_order_server".
 *
 * @property int $id
 * @property int $yx_order_id 订单id
 * @property string $server_name 服务名称
 * @property int $server_price 服务价格
 * @property string $server_unit 服务单位
 * @property int $server_amount 服务数量
 * @property int $is_main 是否订单主服务
 */
class YxOrderServer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yx_order_server';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yx_order_id'], 'required'],
            [['yx_order_id', 'server_price', 'server_amount', 'is_main', 'server_id'], 'integer'],
            [['server_name'], 'string', 'max' => 45],
            [['server_unit'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'yx_order_id' => '订单id',
            'server_name' => '服务名称',
            'server_price' => '服务价格',
            'server_unit' => '服务单位',
            'server_amount' => '服务数量',
            'is_main' => '是否订单主服务',
            'server_id' => '服务ID',
        ];
    }
    public function getyx_order() {
        return $this->hasOne('common\models\YxOrder', ['id'=>'yx_order_id']);
    }
}
