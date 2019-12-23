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
     * @var array manages holiday color by type on the calendar scheduler.
     */
    public $calendarColor = [
        Holiday::TYPE_PERSONAL => '#63c598',
        Holiday::TYPE_BUSINESS => '#ea7569',
        Holiday::TYPE_CUSTOM => '#ecc262'
    ];

    public $customHolidayName = 'Custom';

    /**
     * @param $type
     * @return mixed
     */
    public function getColorByType($type)
    {
        return $this->calendarColor[$type];
    }
}