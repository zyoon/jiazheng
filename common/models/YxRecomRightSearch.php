<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxRecomRight;

/**
 * YxRecomRightSearch represents the model behind the search form of `common\models\YxRecomRight`.
 */
class YxRecomRightSearch extends YxRecomRight
{
    public function attributes(){
        $attributes=parent::attributes();
        foreach ($attributes as $key => $value) {
            if($value=='recom_right_pic'||$value=='recom_right_href'){
                unset($attributes[$key]);
            }
        }
        return $attributes;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recom_right_id'], 'integer'],
            // [['recom_right_pic', 'recom_right_href'], 'safe'],
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
        $query = YxRecomRight::find();

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
            'recom_right_id' => $this->recom_right_id,
        ]);

        // $query->andFilterWhere(['like', 'recom_right_pic', $this->recom_right_pic])
        //     ->andFilterWhere(['like', 'recom_right_href', $this->recom_right_href]);

        return $dataProvider;
    }
}
