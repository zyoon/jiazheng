<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxStaffServer;

/**
 * YxStaffServerSearch represents the model behind the search form of `common\models\YxStaffServer`.
 */
class YxStaffServerSearch extends YxStaffServer
{
    /**
     * @inheritdoc
     */
    public function attributes(){
        return array_merge(parent::attributes(),['server.server_name','server.server_unit','server.server_state']);
    }

    public function rules()
    {

        return [
            [['staff_id', 'server_id', 'server_least', 'server_price', 'server_parent_id'], 'integer'],
            [['server.server_name','server.server_unit','server.server_state','server_type'],'safe']
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
        $query = YxStaffServer::find();

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

        // grid filtering conditions
        $query->join('INNER JOIN','yx_server S','yx_staff_server.server_id=S.server_id');

        $query->andFilterWhere([
            'staff_id' => $this->staff_id,
            'server_id' => $this->server_id,
            'server_least' => $this->server_least,
            'server_price' => $this->server_price,
            'S.server_state'=>$this->getAttribute('server.server_state'),
            'server_parent_id' => $this->server_parent_id,
        ]);
        

        $query->andFilterWhere(['like', 'S.server_name', $this->getAttribute('server.server_name')]);
        $query->andFilterWhere(['like', 'S.server_unit', $this->getAttribute('server.server_unit')]);
        $query->andFilterWhere(['in', 'yx_staff_server.server_type', $this->server_type]);
        return $dataProvider;
    }
}
