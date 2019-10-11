<?php

use yii\db\Migration;

/**
 * Class m191011_125535_seed_departments
 */
class m191011_125535_seed_departments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%department}}', [
            'id' => 1,
            'name' => 'Hr',
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1
        ]);

        $this->insert('{{%department}}', [
            'id' => 2,
            'name' => 'Sales',
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
        $this->delete('{{%department}}');

    }

}
