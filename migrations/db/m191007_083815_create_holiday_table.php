<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%holiday}}`.
 */
class m191007_083815_create_holiday_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%holiday}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'type' => $this->tinyInteger(),
            'status' => $this->tinyInteger(),
            'title' => $this->string(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'description' => $this->text(),
            'going_to' => $this->string(),
            'trip_reason' => $this->text(),
            'travel_coast' => $this->decimal(20, 2),
            'income' => $this->decimal(20, 2),
            'accommodation' => $this->text(),
            'client_entertainment' => $this->text(),
            'currency_code' => $this->string(10),
            'date_require' => $this->date(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
            'confirmed_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'deleted_by' => $this->integer(11),
            'confirmed_by' => $this->integer(11),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%holiday}}');
    }
}
