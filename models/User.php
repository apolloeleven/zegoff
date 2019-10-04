<?php
namespace app\models;

use app\models\query\UserQuery;
use Yii;
use yii\behaviors\AttributeBehavior;
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

    // AIM Wizard Roles
    const ROLE_SUSTAINABILITY_ANALYST = 'sustainability_analyst';
    const ROLE_SUSTAINABILITY_MANAGER = 'sustainability_manager';
    const ROLE_CREDIT_ANALYST = 'credit_analyst';
    const ROLE_CREDIT_MANAGER = 'credit_manager';
    const ROLE_PORTFOLIO_MANAGER= 'portfolio_manager';
    const ROLE_TEAM = 'team';
    const ROLE_COMPLIANCE = 'compliance';


    const PERMISSION_SUSTAINABILITY_ADD_REVIEW = 'sustainability_add_review';
    const PERMISSION_SUSTAINABILITY_EDIT_REVIEW = 'sustainability_edit_review';
    const PERMISSION_SUSTAINABILITY_ADD_FIELDS_VALUES = 'sustainability_add_fields_values';
    const PERMISSION_SUSTAINABILITY_APPROVE_VIA_PEER_REVIEW = 'sustainability_approve_via_peer_review';
    const PERMISSION_SUSTAINABILITY_ADD_NEW_ENGAGEMENT = 'sustainability_add_new_engagement';
    const PERMISSION_SUSTAINABILITY_CREATE_CUSTOM_REPORT = 'sustainability_create_custom_report';
    const PERMISSION_SUSTAINABILITY_MANAGE_APPROVAL_STATUS = 'sustainability_manage_approval_status';
    const PERMISSION_CREDIT_ADD_REVIEW = 'credit_add_review';
    const PERMISSION_CREDIT_EDIT_REVIEW = 'credit_edit_review';
    const PERMISSION_CREDIT_ADD_FIELDS_VALUES = 'credit_add_fields_values';
    const PERMISSION_CREDIT_CREATE_CUSTOM_REPORT = 'credit_create_custom_report';
    const PERMISSION_CREDIT_MANAGE_APPROVAL_STATUS = 'credit_manage_approval_status';


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
            TimestampBehavior::className(),
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
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::statuses())],
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
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
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
     * Creates user profile and application event
     * @param array $profileData
     */
    public function afterSignup(array $profileData = [])
    {
        $this->refresh();
        Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'category' => 'user',
            'event' => 'signup',
            'data' => [
                'public_identity' => $this->getPublicIdentity(),
                'user_id' => $this->getId(),
                'created_at' => $this->created_at
            ]
        ]));
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

        $role = "('". implode('\',\'',$role) ."')";
        $users = User::find()->active()
            ->innerJoin('rbac_auth_assignment rbac', 'rbac.user_id = user.id AND rbac.item_name IN '.$role)
            ->all();
        return $users;
    }
}
