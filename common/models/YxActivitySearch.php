<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxActivity;

/**
 * YxActivitySearch represents the model behind the search form of `common\models\YxActivity`.
 */
class YxActivitySearch extends YxActivity
{
    public function attributes(){
        $attributes=parent::attributes();
        foreach ($attributes as $key => $value) {
            if($value=='activity_pic'||$value=='activity_href'){
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
            [['activity_id'], 'integer'],
            // [['activity_pic', 'activity_href'], 'safe'],
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
        $query = YxActivity::find();

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
            'activity_id' => $this->activity_id,
        ]);

        // $query->andFilterWhere(['like', 'activity_pic', $this->activity_pic])
        //     ->andFilterWhere(['like', 'activity_href', $this->activity_href]);

        return $dataProvider;
    }
}
