<?php
namespace app\modules\api\v1\models;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    /**
    * @var integer
    */
    const SECONDS_IN_A_MINUTE = 60;
    /**
     * @var integer
     */
    const SECONDS_IN_AN_HOUR = 3600;
    /**
     * @var integer
     */
    const SECONDS_IN_A_DAY = 86400;
    /**
     * @var integer
     */
    const SECONDS_IN_A_WEEK = 604800;
    /**
     * @var integer
     */
    const SECONDS_IN_A_MONTH = 2592000;
    /**
     * @var integer
     */
    const SECONDS_IN_A_YEAR = 31536000;



    public $identity;
    public $password;
    public $rememberMe = true;

    private $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['identity', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'identity'=>Yii::t('frontend', 'Username or email'),
            'password'=>Yii::t('frontend', 'Password'),
            'rememberMe'=>Yii::t('frontend', 'Remember Me'),
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('frontend', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->access_token = Yii::$app->getSecurity()->generateRandomString();
            $user->save();

            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? self::SECONDS_IN_A_MONTH : 0)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::find()
                ->active()
                ->andWhere(['or', ['username'=>$this->identity], ['email'=>$this->identity]])
                ->one();
        }

        return $this->user;
    }
}
