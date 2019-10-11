<?php

use yii\db\Migration;

/**
 * Class m191007_074200_add_bank_holiday_table
 */
class m191007_074200_add_bank_holiday_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bank_holiday}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date(),
            'description' => $this->text(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'deleted_by' => $this->integer(11),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bank_holiday}}');
    }
}
