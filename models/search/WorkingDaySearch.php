<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WorkingDay;

/**
 * WorkingDaySearch represents the model behind the search form of `app\models\WorkingDay`.
 */
class WorkingDaySearch extends WorkingDay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'week_index', 'is_working_day'], 'integer'],
            [['weekday', 'start_at', 'end_at'], 'safe'],
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
        $query = WorkingDay::find();

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
            'id' => $this->id,
            'week_index' => $this->week_index,
            'is_working_day' => $this->is_working_day,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ]);

        $query->andFilterWhere(['like', 'weekday', $this->weekday]);

        return $dataProvider;
    }
}
