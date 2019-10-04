<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Account form
 */
class AccountForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app', 'This username has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->id]]);
                }
            ],
            ['username', 'string', 'min' => 1, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app', 'This email has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
                }
            ],
            ['password', 'string'],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'password_confirm' => Yii::t('app', 'Password Confirm')
        ];
    }
}
