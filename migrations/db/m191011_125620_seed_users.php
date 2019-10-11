<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m191011_125620_seed_users
 */
class m191011_125620_seed_users extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 2,
            'username' => 'hr',
            'email' => 'hr@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('hrmanager'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => User::STATUS_ACTIVE,
            'position' => User::POSITION_HR,
            'department_id' => 1,
            'days_left' => 24,
            'is_staff' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id' => 2,
            'locale' => Yii::$app->sourceLanguage,
            'firstname' => 'Jane',
            'lastname' => 'Doe'
        ]);

        $this->insert('{{%user}}', [
            'id' => 3,
            'username' => 'head',
            'email' => 'head@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('headofdepartment'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => User::STATUS_ACTIVE,
            'position' => User::POSITION_HEAD_OF_DEP,
            'department_id' => 2,
            'days_left' => 24,
            'is_staff' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id' => 3,
            'locale' => Yii::$app->sourceLanguage,
            'firstname' => 'John',
            'lastname' => 'Doe'
        ]);

        $this->insert('{{%user}}', [
            'id' => 4,
            'username' => 'employee',
            'email' => 'employee@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('employee'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => User::STATUS_ACTIVE,
            'position' => User::POSITION_EMPLOYEE,
            'department_id' => 2,
            'days_left' => 24,
            'is_staff' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 1,
            'updated_by' => 1
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id' => 4,
            'locale' => Yii::$app->sourceLanguage,
            'firstname' => 'Jack',
            'lastname' => 'Dawson'
        ]);


    }

    public function safeDown()
    {

        $this->delete('{{%user_profile}}', [
            '!=', 'user_id', 1
        ]);

        $this->delete('{{%user}}', [
            '!=', 'id', 1
        ]);
    }
}
