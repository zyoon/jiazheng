<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxBanner;

/**
 * YxBannerSearch represents the model behind the search form of `common\models\YxBanner`.
 */
class YxBannerSearch extends YxBanner
{

    public function attributes(){
        $attributes=parent::attributes();
        foreach ($attributes as $key => $value) {
            if($value=='banner_pic'||$value=='banner_href'){
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
            [['banner_id'], 'integer'],
            // [['banner_pic', 'banner_href'], 'safe'],
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
        $query = YxBanner::find();

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
            'banner_id' => $this->banner_id,
        ]);

        // $query->andFilterWhere(['like', 'banner_pic', $this->banner_pic])
        //     ->andFilterWhere(['like', 'banner_href', $this->banner_href]);

        return $dataProvider;
    }
}
