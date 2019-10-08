<?php

namespace app\models;

use app\behaviors\HolidayBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%holiday}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property int $status
 * @property string $title
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 * @property string $going_to
 * @property string $trip_reason
 * @property float $travel_coast
 * @property float $income
 * @property float $days
 * @property string $accommodation
 * @property string $client_entertainment
 * @property string $currency_code
 * @property string $date_require
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int $confirmed_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property int $confirmed_by
 * @property array $workingDays
 *
 * @property User $confirmedBy
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 * @property User $user
 */
class Holiday extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_REJECTED = 1;
    const STATUS_ACCEPTED = 2;

    const TYPE_PERSONAL = 1;
    const TYPE_BUSINESS = 2;
    const TYPE_CUSTOM = 3;

    const SCENARIO_PERSONAL = '1';
    const SCENARIO_BUSINESS = '2';
    const SCENARIO_CUSTOM = '3';
    const SCENARIO_DEFAULT = 'default';

    public $workingDays;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%holiday}}';
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
            HolidayBehavior::class
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_PERSONAL => [
                'user_id',
                'type',
                'status',
                'title',
                'start_date',
                'end_date',
                'description',
            ],
            self::SCENARIO_BUSINESS => [
                'user_id',
                'type',
                'status',
                'start_date',
                'end_date',
                'going_to',
                'trip_reason',
                'travel_coast',
                'income',
                'accommodation',
                'client_entertainment',
                'currency_code',
                'date_require',
            ],
            self::SCENARIO_CUSTOM => [
                'user_id',
                'type',
                'status',
                'title',
                'start_date',
                'end_date',
                'description',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'status', 'created_at', 'updated_at', 'deleted_at', 'confirmed_at', 'created_by', 'updated_by', 'deleted_by', 'confirmed_by'], 'integer'],
            [['start_date', 'end_date', 'date_require'], 'safe'],
            [['description', 'trip_reason', 'accommodation', 'client_entertainment'], 'string'],
            [['travel_coast', 'income', 'days'], 'number'],
            [['title', 'going_to'], 'string', 'max' => 255],
            [['currency_code'], 'string', 'max' => 10],
            [['confirmed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['confirmed_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['end_date', 'start_date'], 'required'],
            [['end_date', 'start_date'], function ($attribute) {
                if (strtotime($this->start_date) >= strtotime($this->end_date)) {
                    $this->addError($this->getAttributeLabel($attribute), Yii::t('app', "From must be less than To"));
                }
            }],
            [['end_date', 'start_date'], function ($attribute) {
                $count = Holiday::find()->byUserId($this->user_id)
                    ->andWhere(['<=', 'start_date', $this->{$attribute}])
                    ->andWhere(['>=', 'end_date', $this->{$attribute}])
                    ->count();
                if ($count) {
                    $this->addError($this->getAttributeLabel($attribute), Yii::t('app', "Leave already exists for these dates"));
                }
            }],
            [['title', 'description'], 'required', 'on' => self::SCENARIO_PERSONAL],
            [['title', 'description'], 'required', 'on' => self::SCENARIO_CUSTOM],
            [[
                'going_to',
                'trip_reason',
                'travel_coast',
                'date_require',
            ], 'required', 'on' => self::SCENARIO_BUSINESS],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'title' => Yii::t('app', 'Title'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'description' => Yii::t('app', 'Description'),
            'going_to' => Yii::t('app', 'Going To'),
            'trip_reason' => Yii::t('app', 'Trip Reason'),
            'travel_coast' => Yii::t('app', 'Travel Coast'),
            'income' => Yii::t('app', 'Company Income'),
            'accommodation' => Yii::t('app', 'Accommodation'),
            'client_entertainment' => Yii::t('app', 'Client Entertainment'),
            'currency_code' => Yii::t('app', 'Currency Code'),
            'days' => Yii::t('app', 'Days'),
            'date_require' => Yii::t('app', 'Date Require'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'confirmed_at' => Yii::t('app', 'Reviewed At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'confirmed_by' => Yii::t('app', 'Reviewed By'),
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_PENDING => Yii::t('app', 'Pending'),
            self::STATUS_REJECTED => Yii::t('app', 'Rejected'),
            self::STATUS_ACCEPTED => Yii::t('app', 'Accepted')
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function types()
    {
        return [
            self::TYPE_PERSONAL => Yii::t('app', 'Personal'),
            self::TYPE_BUSINESS => Yii::t('app', 'Business'),
            self::TYPE_CUSTOM => Yii::t('app', env('CUSTOM_HOLIDAY_NAME', 'Custom'))
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfirmedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'confirmed_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\HolidayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\HolidayQuery(get_called_class());
    }

    public function markDeleted()
    {
        $this->deleted_at = time();
        $this->deleted_by = Yii::$app->user->id;
        $this->save();
    }

    public function getTypeText()
    {
        $types = Holiday::types();
        return isset($types[$this->type]) ? $types[$this->type] : $this->type;
    }

    public function getStatusText()
    {
        $statuses = Holiday::statuses();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : $this->status;
    }

    public function getViewName()
    {
        return self::getViews()[$this->type];
    }

    public static function getViews()
    {
        return [
            self::TYPE_PERSONAL => 'personal',
            self::TYPE_BUSINESS => 'business',
            self::TYPE_CUSTOM => 'custom'
        ];
    }

    public static function getCurrencies()
    {
        return [
            'USD' => 'USD',
            'EUR' => 'EUR',
        ];
    }
}
