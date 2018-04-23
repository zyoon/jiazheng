<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxCmpServer;

/**
 * YxCmpServerSearch represents the model behind the search form of `common\models\YxCmpServer`.
 */
class YxCmpServerSearch extends YxCmpServer
{


    /**
     * {@inheritdoc}
     */
    public function attributes(){
        return array_merge(parent::attributes(),['server.server_name','server.server_unit','server.server_state']);
    }

    public function rules()
    {
        return [
            [['company_id', 'server_id', 'server_least', 'server_price', 'server_parent_id', 'server_type','server.server_state'], 'integer'],
            [['server_name','server.server_name','server.server_unit', 'server_type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = YxCmpServer::find();

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
        $query->join('INNER JOIN','yx_server S','yx_cmp_server.server_id=S.server_id');
        // grid filtering conditions
        $query->andFilterWhere([
            'company_id' => $this->company_id,
            'server_id' => $this->server_id,
            'server_least' => $this->server_least,
            'server_price' => $this->server_price,
            'server_parent_id' => $this->server_parent_id,
            'S.server_state'=>$this->getAttribute('server.server_state'),
        ]);

        $query->andFilterWhere(['like', 'S.server_name', $this->getAttribute('server.server_name')]);
        $query->andFilterWhere(['like', 'S.server_unit', $this->getAttribute('server.server_unit')]);
        $query->andFilterWhere(['in', 'yx_cmp_server.server_type', $this->server_type]);

        return $dataProvider;
    }
}
