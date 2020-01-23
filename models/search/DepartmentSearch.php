<?php

namespace app\models\search;

use app\models\UserProfile;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Department;

/**
 * DepartmentSearch represents the model behind the search form of `app\models\Department`.
 */
class DepartmentSearch extends Department
{

    public $creator;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name','created_at'], 'safe'],
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
        $query = Department::find()->joinWith('creator.userProfile')->notDeleted();

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

        $dataProvider->sort->attributes['creator'] = [
            'asc' => [UserProfile::tableName() . '.firstname' => SORT_ASC],
            'desc' => [UserProfile::tableName() . '.firstname' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'department.id' => $this->id,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if ($this->created_at) {

            $query->andFilterWhere([
                'FROM_UNIXTIME(department.created_at, "%Y-%m-%d")' => $this->created_at
            ]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        if ($this->creator) {

            $query->andFilterWhere(['or',
                ['like', UserProfile::tableName() . '.lastname', $this->creator],
                ['like', UserProfile::tableName() . '.firstname', $this->creator]
            ]);

        }

        return $dataProvider;
    }
}
