<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxCmpRes;

/**
 * YxCmpResSearch represents the model behind the search form of `common\models\YxCmpRes`.
 */
class YxCmpResSearch extends YxCmpRes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cmp_res_id', 'company_id'], 'integer'],
            // [['cmp_res_img'], 'safe'],
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
        $query = YxCmpRes::find();

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
            'cmp_res_id' => $this->cmp_res_id,
            'company_id' => $this->company_id,
        ]);

        // $query->andFilterWhere(['like', 'cmp_res_img', $this->cmp_res_img]);

        return $dataProvider;
    }
}
