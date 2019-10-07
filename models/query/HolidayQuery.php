<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Holiday]].
 *
 * @see \app\models\Holiday
 */
class HolidayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Holiday[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Holiday|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return HolidayQuery
     */
    public function notDeleted()
    {
        return $this->andWhere(['deleted_at' => null]);
    }
}
