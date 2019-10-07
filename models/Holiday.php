<?php

namespace app\models;

use Yii;

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
 * @property string $travel_coast
 * @property string $spink_income
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
 *
 * @property User $confirmedBy
 * @property User $createdBy
 * @property User $deletedBy
 * @property User $updatedBy
 */
class Holiday extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_REJECTED = 1;
    const STATUS_ACCEPTED = 2;

    const TYPE_PERSONAL = 1;
    const TYPE_BUSINESS = 2;
    const TYPE_CUSTOM = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%holiday}}';
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
            [['travel_coast', 'spink_income'], 'number'],
            [['title', 'going_to'], 'string', 'max' => 255],
            [['currency_code'], 'string', 'max' => 10],
            [['confirmed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['confirmed_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'spink_income' => Yii::t('app', 'Spink Income'),
            'accommodation' => Yii::t('app', 'Accommodation'),
            'client_entertainment' => Yii::t('app', 'Client Entertainment'),
            'currency_code' => Yii::t('app', 'Currency Code'),
            'date_require' => Yii::t('app', 'Date Require'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'confirmed_at' => Yii::t('app', 'Confirmed At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
            'confirmed_by' => Yii::t('app', 'Confirmed By'),
        ];
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
}
