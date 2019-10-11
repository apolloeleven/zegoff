<?php

use yii\db\Migration;

/**
 * Class m191007_091933_alter_user_table
 */
class m191007_091933_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'department_id', $this->integer()->after('id'));
        $this->addColumn('{{%user}}', 'position', $this->integer()->after('department_id'));
        $this->addColumn('{{%user}}', 'days_left', $this->decimal(3, 1)->after('position')->defaultValue(0));


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'department_id');
        $this->dropColumn('{{%user}}', 'position');
        $this->dropColumn('{{%user}}', 'days_left');
    }


}
