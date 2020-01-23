<?php

namespace app\models\search;

use app\models\UserProfile;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BankHoliday;

/**
 * BankHolidaySearch represents the model behind the search form of `app\models\BankHoliday`.
 */
class BankHolidaySearch extends BankHoliday
{

    public $creator;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['date', 'description'], 'safe'],
            [['creator'], 'safe'],
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
        $query = BankHoliday::find()->joinWith('createdBy.userProfile')->notDeleted();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['creator'] = [
            'asc' => [UserProfile::tableName() . '.firstname' => SORT_ASC],
            'desc' => [UserProfile::tableName() . '.firstname' => SORT_DESC],
        ];


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BankHoliday::tableName() . '.id' => $this->id,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        if ($this->creator) {

            $query->andFilterWhere(['or',
                ['like', UserProfile::tableName() . '.lastname', $this->creator],
                ['like', UserProfile::tableName() . '.firstname', $this->creator]
            ]);

        }

        return $dataProvider;
    }
}
