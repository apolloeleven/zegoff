<?php

namespace app\models\search;

use app\models\User;
use app\models\UserProfile;
use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Holiday;

/**
 * HolidaySearch represents the model behind the search form of `app\models\Holiday`.
 */
class HolidaySearch extends Holiday
{
    public $employee;
    public $department;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'status', 'created_at', 'updated_at', 'deleted_at', 'confirmed_at', 'created_by', 'updated_by', 'deleted_by', 'confirmed_by'], 'integer'],
            [['title', 'start_date', 'end_date', 'description', 'going_to', 'trip_reason', 'accommodation', 'client_entertainment', 'currency_code', 'date_require'], 'safe'],
            [['travel_coast', 'income', 'days'], 'number'],
            [['employee'], 'safe'],
            [['department'], 'safe'],
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
     * @param bool $excludeCurrentUser
     * @return ActiveDataProvider
     * @throws \Exception
     */
    public function search($params, $excludeCurrentUser = false)
    {
        $query = Holiday::find()
            ->joinWith('user.department')
            ->joinWith('user.userProfile');

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


        $dataProvider->sort->attributes['employee'] = [
            'asc' => [UserProfile::tableName() . '.firstname' => SORT_ASC],
            'desc' => [UserProfile::tableName() . '.firstname' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['department'] = [
            'asc' => [User::tableName() . '.department' => SORT_ASC],
            'desc' => [User::tableName() . '.department' => SORT_DESC],
        ];

        if ($this->start_date) {
            $start = new DateTime($this->start_date);
            $this->start_date = $start->format("Y-m-d");
        }

        if ($this->end_date) {
            $start = new DateTime($this->end_date);
            $this->end_date = $start->format("Y-m-d");
        }

        // grid filtering conditions
        $query->andFilterWhere([
            Holiday::tableName() . '.id' => $this->id,
            Holiday::tableName() . '.user_id' => $this->user_id,
            Holiday::tableName() . '.days' => $this->days,
            Holiday::tableName() . '.type' => $this->type,
            Holiday::tableName() . '.status' => $this->status,
            Holiday::tableName() . '.travel_coast' => $this->travel_coast,
            Holiday::tableName() . '.income' => $this->income,
            Holiday::tableName() . '.date_require' => $this->date_require,
            Holiday::tableName() . '.created_at' => $this->created_at,
            Holiday::tableName() . '.updated_at' => $this->updated_at,
            Holiday::tableName() . '.deleted_at' => $this->deleted_at,
            Holiday::tableName() . '.confirmed_at' => $this->confirmed_at,
            Holiday::tableName() . '.created_by' => $this->created_by,
            Holiday::tableName() . '.updated_by' => $this->updated_by,
            Holiday::tableName() . '.deleted_by' => $this->deleted_by,
            Holiday::tableName() . '.confirmed_by' => $this->confirmed_by,
        ]);

        $query->andFilterWhere(['like', Holiday::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', Holiday::tableName() . '.description', $this->description])
            ->andFilterWhere(['like', Holiday::tableName() . '.going_to', $this->going_to])
            ->andFilterWhere(['like', Holiday::tableName() . '.trip_reason', $this->trip_reason])
            ->andFilterWhere(['like', Holiday::tableName() . '.accommodation', $this->accommodation])
            ->andFilterWhere(['like', Holiday::tableName() . '.client_entertainment', $this->client_entertainment])
            ->andFilterWhere(['>=', Holiday::tableName() . '.start_date', $this->start_date])
            ->andFilterWhere(['<=', Holiday::tableName() . '.end_date', $this->end_date])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code]);

        //TODO IMPROVE SEARCH
        if ($this->employee) {
            $query->andFilterWhere(['or',
                ['like', UserProfile::tableName() . '.lastname', $this->employee],
                ['like', UserProfile::tableName() . '.firstname', $this->employee]
            ]);
        }

        if ($this->department) {
            $query->andFilterWhere([
                User::tableName() . '.department_id' => $this->department,
            ]);
        }

        if ($excludeCurrentUser) {
            $query->andFilterWhere(['!=', Holiday::tableName() . '.user_id', \Yii::$app->user->id]);
        }

        return $dataProvider;
    }
}
