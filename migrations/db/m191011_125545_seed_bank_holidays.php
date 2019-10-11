<?php

use yii\db\Migration;

/**
 * Class m191011_125545_seed_bank_holidays
 */
class m191011_125545_seed_bank_holidays extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%bank_holiday}}', [
            'id' => 1,
            'date' => date("Y") . "-01-01",
            'description' => 'New Year',
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1
        ]);

        $this->insert('{{%bank_holiday}}', [
            'id' => 2,
            'date' => date("Y") . "-12-25",
            'description' => 'Christmas',
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%bank_holiday}}', [
            'id' => [1, 2]
        ]);
    }

}
