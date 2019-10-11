<?php

namespace app\models\query;

use app\models\User;
use yii\db\ActiveQuery;

/**
 * Class UserQuery
 * @package app\models\query
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function notDeleted()
    {
        $this->andWhere(['!=', 'status', User::STATUS_DELETED]);
        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere([User::tableName() . '.id' => $id]);
    }

    public function staff()
    {
        return $this->andWhere([User::tableName() . '.is_staff' => 1]);
    }
}