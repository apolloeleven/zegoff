<?php

use app\helpers\Helper;
use app\models\Holiday;
use dosamigos\datetimepicker\DateTimePicker;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\HolidaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Holidays');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-index">

    <h1 style="margin-bottom: 20px"><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo ButtonDropdown::widget([
            'encodeLabel' => false,
            'options' => ['class' => 'btn btn-default'],
            'label' => '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Submit Holiday'),
            'dropdown' => [
                'items' => array_map(function ($label, $type) {
                    return [
                        'label' => $label,
                        'url' => ['/holiday/create', 'type' => $type],
                    ];
                }, Holiday::types(), array_keys(Holiday::types()))
            ],
        ]); ?>
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
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'start_date',
                    'phpDatetimeFormat' => "yyyy-MM-dd",
                    'momentDatetimeFormat' => 'YYYY-MM-DD',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],
            [
                'attribute' => 'end_date',
                'value' => function ($model) {
                    return $model->end_date;
                },
                'label' => 'Date To',
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'end_date',
                    'phpDatetimeFormat' => "yyyy-MM-dd",
                    'momentDatetimeFormat' => 'YYYY-MM-DD',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],
            'days',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>