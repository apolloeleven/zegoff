<?php

use yii\db\Migration;

/**
 * Class m191008_073526_add_days_field_to_holiday
 */
class m191008_073526_add_days_field_to_holiday extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%holiday}}', 'days', $this->decimal(3, 1)->after('end_date'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%holiday}}', 'days');
    }


}
