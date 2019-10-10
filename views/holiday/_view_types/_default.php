<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/8/19
 * Time: 6:08 PM
 * @var $this yii\web\View
 * @var $model app\models\Holiday
 */
?>
<?php echo $this->render('@app/views/holiday/_view_types/_' . $model->getViewName(),
    [
        'model' => $model,
        'main_attributes' => [
            'id',
            [
                'label' => Yii::t('app', 'Employee'),
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return $model->user->userProfile->getFullName();
                }
            ],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return $model->getTypeText();
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return $model->getStatusText();
                }
            ],
            'start_date',
            [
                'attribute' => 'start_time',
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return $model->getStartTimeText();
                }
            ],
            'end_date',
            [
                'attribute' => 'end_time',
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return $model->getEndTimeText();
                }
            ],
            'days',
        ],
        'attributes' => [
            'created_at:datetime',
            'updated_at:datetime',
            'confirmed_at:datetime',
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return $model->createdBy->userProfile->getFullName();
                }
            ],
            [
                'attribute' => 'updated_by',
                'label' => Yii::t('app', 'Modified by'),
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return $model->updatedBy->userProfile->getFullName();
                }
            ],
            [
                'attribute' => 'confirmed_by',
                'value' => function ($model) {
                    /** @var \app\models\Holiday $model */
                    return isset($model->confirmedBy) ? $model->confirmedBy->userProfile->getFullName() : null;
                }
            ],
        ]
    ]) ?>
