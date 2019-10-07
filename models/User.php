<?php

namespace app\models;

use app\models\query\UserQuery;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property string $publicIdentity
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 * @property float $days_left
 * @property integer $department_id
 * @property integer $position
 *
 * @property \app\models\UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMINISTRATOR = 'administrator';

    // User Type
    const POSITION_EMPLOYEE = 1;
    const POSITION_HR = 2;
    const POSITION_HEAD_OF_DEP = 3;
    const POSITION_CEO = 4;

    // Events
    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'auth_key' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'access_token' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                }
            ]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'oauth_create' => [
                    'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status'
                ]
            ]
        );
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            [['department_id'], 'integer'],
            [['days_left'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['position', 'default', 'value' => self::POSITION_EMPLOYEE],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            ['position', 'in', 'range' => array_keys(self::positions())],
            [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-mail'),
            'status' => Yii::t('app', 'Status'),
            'access_token' => Yii::t('app', 'API access token'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'logged_at' => Yii::t('app', 'Last login'),
            'position' => Yii::t('app', 'Position'),
            'department_id' => Yii::t('app', 'Department'),
            'days_left' => Yii::t('app', 'Days Left'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->active()
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->active()
            ->andWhere(['access_token' => $token, 'status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->active()
            ->andWhere(['username' => $username, 'status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return self
     */
    public static function findByLogin($login)
    {
        return static::find()
            ->active()
            ->andWhere([
                'and',
                ['or', ['username' => $login], ['email' => $login]],
                'status' => self::STATUS_ACTIVE
            ])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('app', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted')
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function positions()
    {
        return [
            self::POSITION_EMPLOYEE => Yii::t('app', 'Employee'),
            self::POSITION_HR => Yii::t('app', 'HR'),
            self::POSITION_HEAD_OF_DEP => Yii::t('app', 'Head Of Department'),
            self::POSITION_CEO => Yii::t('app', 'CEO')
        ];
    }

    /**
     * @param array $profileData
     * @throws \Exception
     */
    public function afterSignup(array $profileData = [])
    {
        $this->refresh();
        $profile = new UserProfile();
        $profile->locale = Yii::$app->language;
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
    }

    /**
     * @return string
     */
    public function getPublicIdentity()
    {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }
        if ($this->username) {
            return $this->username;
        }
        return $this->email;
    }

    public function getData()
    {
        $userProfile = $this->userProfile;
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'firstname' => $userProfile ? $userProfile->firstname : null,
            'middlename' => $userProfile ? $userProfile->middlename : null,
            'lastname' => $userProfile ? $userProfile->lastname : null,
            'locale' => $userProfile ? $userProfile->locale : null,
            'gender' => $userProfile ? ($userProfile->gender == '1' ? 'm' : 'f') : null,
            'member_since' => Yii::$app->formatter->asDate($this->created_at, 'short'),
            'roles' => Yii::$app->authManager->getRolesByUser($this->id),
            'permissions' => Yii::$app->authManager->getPermissionsByUser($this->id),
        ];
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->userProfile->firstname,
            'lastname' => $this->userProfile->lastname,
            'username' => $this->username,
            'email' => $this->email
        ];
    }

    /**
     * @return array
     */
    public function getSelectData()
    {
        return [
            'id' => $this->id,
            'text' => $this->userProfile->getFullName() ? $this->userProfile->getFullName() : $this->username
        ];
    }

    /**
     * @param array $role
     * @return array|ActiveRecord[]
     */
    public static function getUsersByRole($role)
    {

        $role = "('" . implode('\',\'', $role) . "')";
        $users = User::find()->active()
            ->innerJoin('rbac_auth_assignment rbac', 'rbac.user_id = user.id AND rbac.item_name IN ' . $role)
            ->all();
        return $users;
    }
}
