<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/8/19
 * Time: 11:52 AM
 */

namespace app\behaviors;

use app\models\Holiday;
use DateTime;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @property  Holiday $owner
 */
class HolidayBehavior extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }


    public function beforeUpdate()
    {
        // Calculate days
        if (in_array($this->owner->scenario, [
            Holiday::SCENARIO_PERSONAL,
            Holiday::SCENARIO_BUSINESS,
            Holiday::SCENARIO_CUSTOM,
        ])) {
            $this->setWorkingDays();
            $this->calculateDays();
        }
    }

    public function beforeInsert()
    {
        // Calculate days
        $this->setWorkingDays();
        $this->calculateDays();
    }

    /**
     * Calculates duration of days
     * Excludes weekends and bank holidays between start and end date
     */
    private function calculateDays()
    {
        $start = strtotime($this->owner->start_date);
        $end = strtotime($this->owner->end_date);
        $dateDiff = $end - $start;
        $this->owner->days = round($dateDiff / (60 * 60 * 24));
    }

    private function setWorkingDays()
    {
        $this->owner->workingDays = [1, 2, 3, 4, 5];
    }

    private function isWeekDay($date)
    {
        $weekDay = date('w', strtotime($date));
        return (integer)in_array($weekDay, $this->owner->workingDays);
    }
}