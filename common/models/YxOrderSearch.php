<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxOrder;

/**
 * YxOrderSearch represents the model behind the search form of `common\models\YxOrder`.
 */
class YxOrderSearch extends YxOrder
{
    public function attributes(){
        return array_merge(parent::attributes(),['staff_number','cmp_number','user_phone','order_server']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_money', 'order_state', 'yx_user_id','yx_staff_id','yx_company_id','created_at', 'updated_at'], 'integer'],
            [['order_name', 'address', 'phone', 'order_memo', 'user_name','order_no','staff_number','cmp_number','user_phone','order_server','order_type','time_start','time_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = YxOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $yx_user_id = isset($params['yx_user_id']) ? $params['yx_user_id'] : $this->yx_user_id;
        $time_start=empty($this->time_start) ? 0:strtotime($this->time_start);
        $time_end=empty($this->time_end) ? strtotime(date('Y-m-d H:i')):strtotime('+1 day',strtotime($this->time_end));
        // grid filtering conditions
        $query->andFilterWhere([
            'yx_order.id' => $this->id,
            'yx_order.order_money' => $this->order_money,
            'yx_order.order_state' => $this->order_state,
            'yx_order.yx_user_id' => $yx_user_id,
            'yx_order.created_at' => $this->created_at,
            'yx_order.updated_at' => $this->updated_at,
            'yx_order.order_type'=> $this->order_type,
            'yx_order.yx_company_id'=> $this->yx_company_id,
            'yx_order.yx_staff_id'=> $this->yx_staff_id,

        ]);
        $query->join('LEFT JOIN','yx_user YU','yx_order.yx_user_id=YU.id');
        $query->join('LEFT JOIN','yx_company YC','yx_order.yx_company_id=YC.id');
        $query->join('LEFT JOIN','yx_staff YS','yx_order.yx_staff_id=YS.staff_id');

        $query->andFilterWhere(['like', 'yx_order.order_name', $this->order_name])
            ->andFilterWhere(['like', 'yx_order.address', $this->address])
            ->andFilterWhere(['like', 'yx_order.phone', $this->phone])
            ->andFilterWhere(['like', 'yx_order.order_memo', $this->order_memo])
            ->andFilterWhere(['like', 'yx_order.user_name', $this->user_name])
            ->andFilterWhere(['like', 'yx_order.order_no', $this->order_no])
            ->andFilterWhere(['like', 'YS.staff_number', $this->staff_number])
            ->andFilterWhere(['like', 'YU.phone', $this->user_phone])
            ->andFilterWhere(['like', 'YC.number', $this->cmp_number])
            ->andFilterWhere(['>=', 'yx_order.time_start', $time_start])
            ->andFilterWhere(['<', 'yx_order.time_end', $time_end]);
        return $dataProvider;
    }
}
