<?php

namespace app\models;

use app\behaviors\HolidayBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Exception;

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
 * @property integer $start_time
 * @property integer $end_time
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int $confirmed_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property int $confirmed_by
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
    const SCENARIO_CONFIRM = 'confirm';

    const TIME_MORNING = 1;
    const TIME_AFTERNOON = 2;
    const TIME_EVENING = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%holiday}}';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            BlameableBehavior::class,
            TimestampBehavior::class,
            HolidayBehavior::class
        ]);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_PERSONAL => [
                'user_id',
                'type',
                'status',
                'title',
                'start_date',
                'start_time',
                'end_time',
                'end_date',
                'description',
            ],
            self::SCENARIO_BUSINESS => [
                'user_id',
                'type',
                'status',
                'start_date',
                'end_date',
                'start_time',
                'end_time',
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
                'start_time',
                'end_time',
                'description',
            ],
            self::SCENARIO_CONFIRM => [
                'status',
                'days',
            ]
        ]);
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
            [['start_time', 'end_time'], 'integer'],
            ['start_time', 'in', 'range' => [self::TIME_MORNING, self::TIME_AFTERNOON], 'allowArray' => false],
            ['end_time', 'in', 'range' => [self::TIME_EVENING, self::TIME_AFTERNOON], 'allowArray' => false],
            [['travel_coast', 'income', 'days'], 'number'],
            [['title', 'going_to'], 'string', 'max' => 255],
            [['currency_code'], 'string', 'max' => 10],
            [['confirmed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['confirmed_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],

            [['end_date', 'start_date'], 'required'],
            [['end_date'], 'validateDates', 'on' => [self::SCENARIO_PERSONAL, self::SCENARIO_BUSINESS, self::SCENARIO_CUSTOM]],
            [['start_time'], 'validateTimes', 'on' => [self::SCENARIO_PERSONAL, self::SCENARIO_BUSINESS, self::SCENARIO_CUSTOM]],
            [['days'], 'checkAvailable', 'on' => [self::SCENARIO_CONFIRM]],
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
            'start_time' => Yii::t('app', 'From Time'),
            'end_time' => Yii::t('app', 'To Time'),
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
            self::TYPE_CUSTOM => Yii::t('app', Yii::$app->holidaySettings->customHolidayName)
        ];
    }

    public function checkAvailable($attribute)
    {
        if ($this->user->days_left < $this->days && $this->status == self::STATUS_ACCEPTED) {
            $this->addError($attribute, \Yii::t('app', "Employee doesn't have enough days | Please contact HR"));
        }
    }

    public function validateDates($attribute)
    {
        $startTimeStamp = strtotime($this->start_date);
        $endTimeStamp = strtotime($this->end_date);
        if ($startTimeStamp > $endTimeStamp) {
            $this->addError($this->getAttributeLabel($attribute), Yii::t('app', "From must be less than To"));
        }

        if ($this->countInRange()) {
            $this->addError($this->getAttributeLabel($attribute), Yii::t('app', "Leave already exists for these dates"));
        }
    }

    public function validateTimes($attribute)
    {
        $startTimeStamp = strtotime($this->start_date);
        $endTimeStamp = strtotime($this->end_date);

        if ($startTimeStamp == $endTimeStamp && $this->start_time == $this->end_time) {
            $this->addError($this->getAttributeLabel($attribute), Yii::t('app', "From and To is a similar dates"));
        }
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

    /**
     * @inheritdoc
     */
    public function countInRange()
    {
        $id = $this->id ?: '';
        return Holiday::find()->andWhere(['user_id' => $this->user_id])
            ->notDeleted()
            ->andWhere(['or', ['and', ['<=', 'start_date', $this->start_date],
                    ['>=', 'end_date', $this->start_date]], ['and', ['<=', 'start_date', $this->end_date],
                    ['>=', 'end_date', $this->end_date]], ['and', ['>=', 'start_date', $this->start_date],
                    ['<=', 'start_date', $this->end_date]], ['and', ['>=', 'end_date', $this->start_date],
                    ['<=', 'end_date', $this->end_date]]]
            )
            ->andWhere(['!=', 'id', $id])
            ->count();
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

    /**
     * @throws Exception
     */
    public function decreaseUserDays()
    {
        $user = $this->user;
        $user->days_left = $user->days_left - $this->days;
        if (!$user->save()) {
            throw new Exception("User could not saved");
        }
    }

    public static function getStartTimeDropdown()
    {
        $times = self::getTimes();
        unset($times[Holiday::TIME_EVENING]);
        return $times;
    }

    public static function getEndTimeDropdown()
    {
        $times = self::getTimes();
        unset($times[Holiday::TIME_MORNING]);
        return $times;
    }

    public static function getTimes()
    {
        return [
            Holiday::TIME_MORNING => Yii::t('app', 'Morning'),
            Holiday::TIME_EVENING => Yii::t('app', 'Evening'),
            Holiday::TIME_AFTERNOON => Yii::t('app', 'Afternoon'),
        ];
    }

    public function getStartTimeText()
    {
        return isset(self::getTimes()[$this->start_time]) ? self::getTimes()[$this->start_time] : null;
    }

    public function getEndTimeText()
    {
        return isset(self::getTimes()[$this->end_time]) ? self::getTimes()[$this->end_time] : null;
    }
}
