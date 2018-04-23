<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\YxComment;

/**
 * YxCommentSearch represents the model behind the search form of `common\models\YxComment`.
 */
class YxCommentSearch extends YxComment
{
    public function attributes(){
        return array_merge(parent::attributes(),['companyName','staffName','userName','orderName']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'star', 'yx_company_id', 'yx_staff_id', 'yx_user_id', 'is_praise', 'yx_order_id', 'created_at', 'updated_at'], 'integer'],
            [['content','companyName','staffName','userName','orderName'], 'safe'],
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
        $query = YxComment::find();

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
        $query->join('LEFT JOIN','yx_user YU','yx_comment.yx_user_id=YU.id');
        $query->join('LEFT JOIN','yx_company YC','yx_comment.yx_company_id=YC.id');
        $query->join('LEFT JOIN','yx_order YO','yx_comment.yx_order_id=YO.id');
        $query->join('LEFT JOIN','yx_staff YS','yx_comment.yx_staff_id=YS.staff_id');
        // grid filtering conditions
        $query->andFilterWhere([
            'yx_comment.id' => $this->id,
            'yx_comment.star' => $this->star,
            'yx_comment.yx_company_id' => $this->yx_company_id,
            'yx_comment.yx_staff_id' => $this->yx_staff_id,
            'yx_comment.yx_user_id' => $this->yx_user_id,
            'yx_comment.is_praise' => $this->is_praise,
            'yx_comment.yx_order_id' => $this->yx_order_id,
            'yx_comment.created_at' => $this->created_at,
            'yx_comment.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'yx_comment.content', $this->content])
            ->andFilterWhere(['like', 'YU.nickname', $this->userName])
            ->andFilterWhere(['like', 'YC.name', $this->companyName])
            ->andFilterWhere(['like', 'YS.staff_name', $this->staffName])
            ->andFilterWhere(['like', 'YO.order_name', $this->orderName]);

        return $dataProvider;
    }
}
