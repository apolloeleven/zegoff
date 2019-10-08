<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Holiday */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holidays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="holiday-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->status == 0) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        </p>
    <?php endif; ?>

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
                'end_date',
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


</div>
