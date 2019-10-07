<?php

use app\models\Holiday;
use dosamigos\datetimepicker\DateTimePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\HolidaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Holidays');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Holiday'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'status',
                'filter' => Holiday::statuses(),
                'value' => function ($model) {
                    /** @var $model Holiday */
                    return $model->getStatusText();
                }
            ],
            [
                'attribute' => 'type',
                'filter' => Holiday::types(),
                'value' => function ($model) {
                    /** @var $model Holiday */
                    return $model->getTypeText();
                }
            ],
            [
                'attribute' => 'start_date',
                'value' => function ($model) {
                    return $model->start_date;
                },
                'label' => 'Date From',
//                    'filter' => DateTimePicker::widget([
//                        'model' => $searchModel,
//                        'attribute' => 'start_date',
//                        'size' => 'ms',
//                        'clientOptions' => [
//                            'autoclose' => true,
//                            'format' => 'dd MM yyyy - HH:ii P',
//                            'todayBtn' => true
//                        ]
//                    ])
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>