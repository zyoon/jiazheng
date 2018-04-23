<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxStaffRes;

/**
 * YxStaffResSearch represents the model behind the search form of `common\models\YxStaffRes`.
 */
class YxStaffResSearch extends YxStaffRes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_res_id', 'staff_id'], 'integer'],
            // [['staff_res_img'], 'safe'],
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
        $query = YxStaffRes::find();

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
            'staff_res_id' => $this->staff_res_id,
            'staff_id' => $this->staff_id,
        ]);

        // $query->andFilterWhere(['like', 'staff_res_img', $this->staff_res_img]);

        return $dataProvider;
    }
}
