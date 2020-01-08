<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/10/19
 * Time: 6:23 PM
 */

namespace app\components;

use app\models\Holiday;
use yii\base\Component;

class HolidaySettings extends Component
{
    /**
     * @var string manages holiday color by type on the calendar scheduler.
     */
    public $textColor = '#000000d6';

    /**
     * @var array manages holiday color by type on the calendar scheduler.
     */
    public $calendarBackgroundColor = [
        Holiday::TYPE_PERSONAL => '#08bbbb4d',
        Holiday::TYPE_BUSINESS => '#ffd29b4d',
        Holiday::TYPE_CUSTOM => '#ea75694d'
    ];

    /**
     * @var array manages holiday color by type on the calendar scheduler.
     */
    public $calendarBorderColor = [
        Holiday::TYPE_PERSONAL => '#63c598',
        Holiday::TYPE_BUSINESS => '#ecc262',
        Holiday::TYPE_CUSTOM => '#ea7569'
    ];

    public $customHolidayName = 'Custom';

    /**
     * @param $type
     * @return mixed
     */
    public function getBackgroundColorByType($type)
    {
        return $this->calendarBackgroundColor[$type];
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getBorderColorByType($type)
    {
        return $this->calendarBorderColor[$type];
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getTextColor()
    {
        return $this->textColor;
    }
}