<?php

use yii\db\Migration;

/**
 * Class m191002_140001_create_table_user
 */
class m191002_140001_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull()->unique(),
            'auth_key' => $this->string(32),
            'access_token' => $this->string(40),
            'password_hash' => $this->string(255)->notNull(),
            'oauth_client' => $this->string(255),
            'oauth_client_user_id' => $this->string(255),
            'email' => $this->string(255)->notNull()->unique(),
            'status' => $this->tinyInteger(6),
            'is_staff' => $this->boolean(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'logged_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);

        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'firstname' => $this->string(),
            'middlename' => $this->string(),
            'lastname' => $this->string(),
            'avatar_path' => $this->string(),
            'avatar_base_url' => $this->string(),
            'locale' => $this->string(32)->notNull(),
            'gender' => $this->smallInteger(1)
        ]);

        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');
    }
}
