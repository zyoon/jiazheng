<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxRules;

/**
 * YxRulesSearch represents the model behind the search form of `common\models\YxRules`.
 */
class YxRulesSearch extends YxRules
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rules_id','rules_type'], 'integer'],
            [['rules_title', 'rules_content'], 'safe'],
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
        $query = YxRules::find();

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
            'rules_id' => $this->rules_id,
            'rules_type' => $this->rules_type,
        ]);

        $query->andFilterWhere(['like', 'rules_title', $this->rules_title])
            ->andFilterWhere(['like', 'rules_content', $this->rules_content]);

        return $dataProvider;
    }
}
