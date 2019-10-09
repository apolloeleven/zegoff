<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%working_day}}`.
 */
class m191009_105330_create_working_day_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%working_day}}', [
            'id' => $this->primaryKey(),
            'weekday' => $this->string(),
            'week_index' => $this->integer(),
            'is_working_day' => $this->boolean(),
            'start_at' => $this->time(),
            'end_at' => $this->time()
        ]);

        $this->insert('{{%working_day}}', [
            'weekday' => 'Sunday',
            'week_index' => 0,
            'is_working_day' => false,
            'start_at' => '09:00:00',
            'end_at' => '18:00:00'
        ]);

        $this->insert('{{%working_day}}', [
            'weekday' => 'Monday',
            'week_index' => 1,
            'is_working_day' => true,
            'start_at' => '09:00:00',
            'end_at' => '18:00:00'
        ]);

        $this->insert('{{%working_day}}', [
            'weekday' => 'Tuesday',
            'week_index' => 2,
            'is_working_day' => true,
            'start_at' => '09:00:00',
            'end_at' => '18:00:00'
        ]);

        $this->insert('{{%working_day}}', [
            'weekday' => 'Wednesday',
            'week_index' => 3,
            'is_working_day' => true,
            'start_at' => '09:00:00',
            'end_at' => '18:00:00'
        ]);

        $this->insert('{{%working_day}}', [
            'weekday' => 'Thursday',
            'week_index' => 4,
            'is_working_day' => true,
            'start_at' => '09:00:00',
            'end_at' => '18:00:00'
        ]);

        $this->insert('{{%working_day}}', [
            'weekday' => 'Friday',
            'week_index' => 5,
            'is_working_day' => true,
            'start_at' => '09:00:00',
            'end_at' => '18:00:00'
        ]);

        $this->insert('{{%working_day}}', [
            'weekday' => 'Saturday',
            'week_index' => 6,
            'is_working_day' => false,
            'start_at' => '09:00:00',
            'end_at' => '18:00:00'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%working_day}}');
    }
}
