<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%working_day}}".
 *
 * @property int $id
 * @property string $weekday
 * @property int $week_index
 * @property int $is_working_day
 * @property string $start_at
 * @property string $end_at
 */
class WorkingDay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%working_day}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['week_index', 'is_working_day'], 'integer'],
            [['start_at', 'end_at'], 'safe'],
            [['weekday'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'weekday' => Yii::t('app', 'Weekday'),
            'week_index' => Yii::t('app', 'Week Index'),
            'is_working_day' => Yii::t('app', 'Is Working Day'),
            'start_at' => Yii::t('app', 'Start At'),
            'end_at' => Yii::t('app', 'End At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\WorkingDayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\WorkingDayQuery(get_called_class());
    }
}
