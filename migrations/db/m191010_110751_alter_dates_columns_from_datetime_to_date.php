<?php

use yii\db\Migration;

/**
 * Class m191010_110751_alter_dates_columns_from_datetime_to_date
 */
class m191010_110751_alter_dates_columns_from_datetime_to_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%holiday}}', 'start_date', $this->date());
        $this->alterColumn('{{%holiday}}', 'end_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%holiday}}', 'start_date', $this->dateTime());
        $this->alterColumn('{{%holiday}}', 'end_date', $this->dateTime());
    }

}
