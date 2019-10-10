<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/8/19
 * Time: 11:52 AM
 */

namespace app\behaviors;

use app\models\BankHoliday;
use app\models\Holiday;
use app\models\WorkingDay;
use DateInterval;
use DatePeriod;
use DateTime;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * @property  Holiday $owner
 */
class HolidayBehavior extends Behavior
{
    private $workingDays;
    private $bankHolidays;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ];
    }

    /**
     * @throws Exception
     */
    public function afterUpdate()
    {
        if ($this->owner->scenario == Holiday::SCENARIO_CONFIRM && $this->owner->status == Holiday::STATUS_ACCEPTED) {
            $this->owner->decreaseUserDays();
        }
    }

    /**
     * @throws \Exception
     */
    public function afterValidate()
    {
        // Calculate days
        if (in_array($this->owner->scenario, [
            Holiday::SCENARIO_PERSONAL,
            Holiday::SCENARIO_BUSINESS,
            Holiday::SCENARIO_CUSTOM,
        ])) {
            $this->setWorkingDays();
            $this->setBankHolidays();
            $this->calculateDays();
            $this->checkAvailable();
        }
    }

    /**
     * Calculates duration of days
     * Excludes weekends and bank holidays between start and end date
     * @throws \Exception
     */
    private function calculateDays()
    {
        // If start_date is equal to end_date
        // Days should be 0, 0.5 or 1.
        // So calculate and stop code execution
        if ($this->owner->start_date == $this->owner->end_date) {
            return $this->calculateSameDateDays();
        }

        $days = 0;
        $start = new DateTime($this->owner->start_date);
        $end = new DateTime($this->owner->end_date);
        $endLoop = clone($end);
        $endLoop->add(new DateInterval('P1D'));
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $endLoop);

        foreach ($period as $dt) {
            $date = $dt->format('Y-m-d');
            // If not working day, continue
            if (!$this->isWorkingDay($date)) {
                continue;
            }

            // If bank holiday day, Continue
            if ($this->isBankHoliday($date)) {
                continue;
            }

            // If Current date is start date calculate based on start_time
            if ($start->format('Y-m-d') == $date) {
                $days += $this->owner->start_time == Holiday::TIME_MORNING ? 1 : 0.5;
                continue;
            }

            // If Current date is start date calculate based on start_time
            if ($end->format('Y-m-d') == $date) {
                $days += $this->owner->end_time == Holiday::TIME_EVENING ? 1 : 0.5;
                continue;
            }

            // Otherwise add 1
            $days += 1;
        }

        $this->owner->days = $days;
    }

    private function setWorkingDays()
    {
        $this->workingDays = ArrayHelper::getColumn(
            WorkingDay::find()->workingDays()->all(),
            'week_index'
        );
    }

    private function setBankHolidays()
    {
        $bankHolidays = BankHoliday::find()
            ->andWhere(['>=', 'date', $this->owner->start_date])
            ->all();

        $this->bankHolidays = ArrayHelper::getColumn($bankHolidays ?: [], 'date');
    }

    private function isWorkingDay($date)
    {
        $weekDay = date('w', strtotime($date));
        return in_array($weekDay, $this->workingDays);
    }

    private function checkAvailable()
    {
        if ($this->owner->user->days_left < $this->owner->days) {
            $this->owner->addError('Days', \Yii::t('app', "Employee doesn't have enough days | Please contact HR"));
        }

        if ($this->owner->days == 0) {
            $this->owner->addError('Days', \Yii::t('app', "Requested holidays days amount is 0"));
        }
    }

    private function isBankHoliday($date)
    {
        return in_array($date, $this->bankHolidays);
    }

    /**
     * @throws \Exception
     */
    private function calculateSameDateDays()
    {
        $start = new DateTime($this->owner->start_date);
        $this->owner->days = 0;

        $formattedDate = $start->format('Y-m-d');
        if ($this->isWorkingDay($formattedDate) && !$this->isBankHoliday($formattedDate)) {
            $this->owner->days += $this->owner->start_time == Holiday::TIME_MORNING ? 0.5 : 0;
            $this->owner->days += $this->owner->end_time == Holiday::TIME_EVENING ? 0.5 : 0;
        }
    }


}
