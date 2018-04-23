<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxServer;

/**
 * YxServerSearch represents the model behind the search form of `common\models\YxServer`.
 */
class YxServerSearch extends YxServer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server_id', 'server_type', 'server_parent', 'server_state', 'server_sort', 'server_mans'], 'integer'],
            [['server_name', 'server_memo', 'server_unit', 'server_pic','server_class'], 'safe'],
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
        $query = YxServer::find();

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
        $query->andFilterWhere([
            'server_id' => $this->server_id,
            'server_type' => $this->server_type,
            'server_parent' => $this->server_parent,
            'server_state' => $this->server_state,
            'server_sort' => $this->server_sort,
            'server_mans' => $this->server_mans, 
        ]);

        $query->andFilterWhere(['like', 'server_name', $this->server_name])
            ->andFilterWhere(['like', 'server_memo', $this->server_memo])
            ->andFilterWhere(['like', 'server_unit', $this->server_unit])
            ->andFilterWhere(['like', 'server_pic', $this->server_pic])
            ->andFilterWhere(['like', 'server_class', $this->server_class]);

        return $dataProvider;
    }
}
