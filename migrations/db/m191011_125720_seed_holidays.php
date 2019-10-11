<?php

use app\models\Holiday;
use app\models\User;
use yii\db\Migration;

/**
 * Class m191011_125620_seed_users
 */
class m191011_125720_seed_holidays extends Migration
{
    public function safeUp()
    {
        $weekInTimeStamp = 604800;

        $holiday = new Holiday();
        $holiday->setScenario(Holiday::SCENARIO_PERSONAL);
        $holiday->title = 'Personal';
        $holiday->description = 'Vacation';
        $holiday->user_id = 4;
        $holiday->type = Holiday::TYPE_PERSONAL;
        $holiday->status = Holiday::STATUS_PENDING;
        $holiday->start_date = date("Y-m-d", time());
        $holiday->end_date = date("Y-m-d", time() + $weekInTimeStamp);
        $holiday->start_time = Holiday::TIME_MORNING;
        $holiday->end_time = Holiday::TIME_EVENING;
        $holiday->end_time = Holiday::TIME_EVENING;
        $holiday->created_at = time();
        $holiday->updated_at = time();
        $holiday->created_by = 4;
        $holiday->updated_by = 4;
        $holiday->save();

        $holiday->setScenario(Holiday::SCENARIO_CONFIRM);
        $holiday->status = Holiday::STATUS_ACCEPTED;
        $holiday->confirmed_by = 2;
        $holiday->confirmed_at = time();
        $holiday->validate();
        $holiday->save();


        $weekInTimeStamp = 604800;
        $holiday = new Holiday();
        $holiday->setScenario(Holiday::SCENARIO_CUSTOM);
        $holiday->title = 'Personal';
        $holiday->description = 'Vacation';
        $holiday->user_id = 4;
        $holiday->type = Holiday::TYPE_CUSTOM;
        $holiday->status = Holiday::STATUS_PENDING;
        $holiday->start_date = date("Y-m-d", time());
        $holiday->end_date = date("Y-m-d", time() + $weekInTimeStamp);
        $holiday->start_time = Holiday::TIME_MORNING;
        $holiday->end_time = Holiday::TIME_EVENING;
        $holiday->end_time = Holiday::TIME_EVENING;
        $holiday->created_at = time();
        $holiday->updated_at = time();
        $holiday->created_by = 4;
        $holiday->updated_by = 4;
        $holiday->save();

        $holiday->setScenario(Holiday::SCENARIO_CONFIRM);
        $holiday->status = Holiday::STATUS_REJECTED;
        $holiday->confirmed_by = 2;
        $holiday->confirmed_at = time();
        $holiday->validate();
        $holiday->save();

    }

    public function safeDown()
    {

    }
}
