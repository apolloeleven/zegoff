<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/8/19
 * Time: 5:19 PM
 */

use app\models\Holiday;
use app\models\User;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\HolidaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'All Requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-index">

    <h1 style="margin-bottom: 20px"><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'employee',
                'value' => function ($model) {
                    /** @var $model Holiday */
                    return $model->user->userProfile->getFullName();
                }
            ],
            [
                'attribute' => 'department',
                'filter' => \app\models\Department::getDropdown(),
                'value' => function ($model) {
                    /** @var $model Holiday */
                    return $model->user->department->name;
                },
                'visible' => Yii::$app->user->identity->position == User::POSITION_HR
            ],
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            ['/holiday/request-view', 'id' => $model->id], ['data-pjax' => "0"]
                        );

                    },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>