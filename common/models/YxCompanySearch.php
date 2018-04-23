<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxCompany;
use common\models\Region;
/**
 * YxCompanySearch represents the model behind the search form of `common\models\YxCompany`.
 */
class YxCompanySearch extends YxCompany
{
    /**
     * @inheritdoc
     */
    public function attributes(){
        return array_merge(parent::attributes(),['provinceName','cityName','districtName']);
    }
    public function rules()
    {
        return [
            [['id','total_fraction', 'created_at', 'updated_at', 'status', 'models', 'cmp_user_id', 'base_fraction', 'history_fraction', 'clinch', 'price', 'manage_time', 'banck_card'], 'integer'],
            [['name', 'image', 'address', 'telephone', 'charge_phone', 'charge_man', 'wechat', 'number', 'introduction','provinceName','cityName','districtName', 'all_server_id', 'query', 'main_server_id','alipay', 'business_code'], 'safe'],
            [['longitude', 'latitude', 'operating_radius'], 'number'],
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
        $query = YxCompany::find();

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
            'yx_company.id' => $this->id,
            'province' => $this->province,
            'city' => $this->city,
            'district' => $this->district,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'operating_radius' => $this->operating_radius,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'models' => $this->models,
            'manage_time' => $this->manage_time, 
            'banck_card' => $this->banck_card,
        ]);

        $query->andFilterWhere(['like', 'yx_company.name', $this->name])
            ->andFilterWhere(['like', 'yx_company.address', $this->address])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'charge_phone', $this->charge_phone])
            ->andFilterWhere(['like', 'charge_man', $this->charge_man])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'business_licences', $this->business_licences])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'all_server_id', $this->all_server_id])
            ->andFilterWhere(['like', 'main_server_id', $this->main_server_id]) 
            ->andFilterWhere(['like', 'query', $this->query])
            ->andFilterWhere(['like', 'alipay', $this->alipay])
            ->andFilterWhere(['like', 'business_code', $this->business_code]);

        $query->join('LEFT JOIN','region rA','yx_company.province=rA.id');
        $query->join('LEFT JOIN','region rB','yx_company.city=rB.id');
        $query->join('LEFT JOIN','region rC','yx_company.district=rC.id');

        $query->andFilterWhere(['like', 'rA.name', $this->provinceName])
            ->andFilterWhere(['like', 'rB.name', $this->cityName])
            ->andFilterWhere(['like', 'rC.name', $this->districtName]);

        return $dataProvider;
    }
}
