<?php

namespace app\models\search;

use app\models\User;
use app\models\UserProfile;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 *
 * @inheritDoc
 * @property string $fullName
 *
 */
class UserSearch extends User
{
    public function attributes()
    {
        return ['id', 'fullName', 'username', 'email', 'status', 'created_at', 'updated_at', 'logged_at', 'position'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'position'], 'integer'],
            [['created_at', 'updated_at', 'logged_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['created_at', 'updated_at', 'logged_at'], 'default', 'value' => null],
            [['fullName', 'username', 'auth_key', 'password_hash', 'email'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()
            ->staff()
            ->innerJoin(UserProfile::tableName() . ' up', 'up.user_id = ' . User::tableName() . '.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['fullName'] = [
            'asc' => ["CONCAT(up.firstname, ' ', up.lastname)" => SORT_ASC],
            'desc' => ["CONCAT(up.firstname, ' ', up.lastname)" => SORT_DESC],
        ];

        if (!( $this->load($params) && $this->validate() )) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'position' => $this->position,
            'status' => $this->status,
        ]);

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }

        if ($this->logged_at !== null) {
            $query->andFilterWhere(['between', 'logged_at', $this->logged_at, $this->logged_at + 3600 * 24]);
        }
        if ($this->fullName) {
            $query
                ->andFilterWhere(['like', "CONCAT(up.firstname, ' ', up.lastname)", $this->fullName]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
