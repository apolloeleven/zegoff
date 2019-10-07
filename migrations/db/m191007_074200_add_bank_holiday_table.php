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

        $this->addForeignKey('FK_bank_holiday_user_created_by_id',
            '{{%bank_holiday}}',
            'created_by',
            '{{%user}}',
            'id'
        );
        $this->addForeignKey('FK_bank_holiday_user_updated_by_id',
            '{{%bank_holiday}}',
            'updated_by',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey('FK_bank_holiday_user_deleted_by_id',
            '{{%bank_holiday}}',
            'deleted_by',
            '{{%user}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bank_holiday}}');
    }
}
