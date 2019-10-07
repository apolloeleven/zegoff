<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Holiday;

/**
 * HolidaySearch represents the model behind the search form of `app\models\Holiday`.
 */
class HolidaySearch extends Holiday
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'status', 'created_at', 'updated_at', 'deleted_at', 'confirmed_at', 'created_by', 'updated_by', 'deleted_by', 'confirmed_by'], 'integer'],
            [['title', 'start_date', 'end_date', 'description', 'going_to', 'trip_reason', 'accommodation', 'client_entertainment', 'currency_code', 'date_require'], 'safe'],
            [['travel_coast', 'spink_income'], 'number'],
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
        $query = Holiday::find();

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
        $this->start_date = null;
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'travel_coast' => $this->travel_coast,
            'spink_income' => $this->spink_income,
            'date_require' => $this->date_require,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'confirmed_at' => $this->confirmed_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'confirmed_by' => $this->confirmed_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'going_to', $this->going_to])
            ->andFilterWhere(['like', 'trip_reason', $this->trip_reason])
            ->andFilterWhere(['like', 'accommodation', $this->accommodation])
            ->andFilterWhere(['like', 'client_entertainment', $this->client_entertainment])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code]);

        return $dataProvider;
    }
}
