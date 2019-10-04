<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%department}}`.
 */
class m191004_130033_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(55),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'deleted_by' => $this->integer(11),
        ]);

        $this->addForeignKey('FK_department_user_created_by_id',
            '{{%department}}',
            'created_by',
            '{{%user}}',
            'id'
        );
        $this->addForeignKey('FK_department_user_updated_by_id',
            '{{%department}}',
            'updated_by',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey('FK_department_user_deleted_by_id',
            '{{%department}}',
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
        $this->dropTable('{{%department}}');
    }
}
