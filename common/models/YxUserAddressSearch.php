<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxUserAddress;

/**
 * YxUserAddressSearch represents the model behind the search form of `common\models\YxUserAddress`.
 */
class YxUserAddressSearch extends YxUserAddress
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'yx_user_id', 'province', 'city', 'district', 'is_delete'], 'integer'],
            [['phone', 'address', 'consignee'], 'safe'],
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
        $query = YxUserAddress::find();

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
        $yx_user_id = isset($params['yx_user_id']) ? $params['yx_user_id'] : $this->yx_user_id;
        $query->andFilterWhere([
            'id' => $this->id,
            'yx_user_id' => $yx_user_id,
            'province' => $this->province,
            'city' => $this->city,
            'district' => $this->district,
            'is_delete' => 2,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'consignee', $this->consignee]);

        return $dataProvider;
    }
}
