<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\WorkingDay]].
 *
 * @see \app\models\WorkingDay
 */
class WorkingDayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\WorkingDay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\WorkingDay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function workingDays()
    {
        return $this->andWhere(['is_working_day' => 1]);
    }
}
