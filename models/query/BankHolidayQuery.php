<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\BankHoliday]].
 *
 * @see \app\models\BankHoliday
 */
class BankHolidayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\BankHoliday[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\BankHoliday|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return BankHolidayQuery
     */
    public function notDeleted()
    {
        return $this->andWhere(['deleted_at' => null]);
    }
}
