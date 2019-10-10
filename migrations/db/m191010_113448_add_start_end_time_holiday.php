<?php

use yii\db\Migration;

/**
 * Class m191010_113448_add_start_end_time_holiday
 */
class m191010_113448_add_start_end_time_holiday extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%holiday}}', 'start_time', $this->integer(3));
        $this->addColumn('{{%holiday}}', 'end_time', $this->integer(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%holiday}}', 'start_time');
        $this->dropColumn('{{%holiday}}', 'end_time');
    }


}
