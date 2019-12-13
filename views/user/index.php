<?php

use app\grid\EnumColumn;
use app\models\Holiday;
use app\models\User;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('app', 'Create new Employee', [
            'modelClass' => 'User',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            'id',
            [
                'attribute' => 'fullName',
                'value' => 'userProfile.fullName'
            ],
            'email:email',
            [
                'attribute' => 'position',
                'filter' => User::positions(),
                'value' => function ($model) {
                    return User::positions()[$model->position];
                }
            ],

            [
                'attribute' => 'department_id',
                'filter' => \app\models\Department::getDropdown(),
                'value' => function ($model) {
                    return $model->department->name;
                }
            ],
            [
                'class' => EnumColumn::class,
                'attribute' => 'status',
                'contentOptions' => function ($model) {
                    // user status 1 == not active, 2 == active, 3 === deleted
                    if ($model->status == 1) {
                        return ['style' => 'color: yellow;'];
                    } else if ($model->status == 2) {
                        return ['style' => 'color: green;'];
                    } else {
                        return ['style' => 'color: red;'];
                    }
                },
                'enum' => User::statuses(),
                'filter' => User::statuses()
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_at);
                },
                'label' => 'Created at',
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'phpDatetimeFormat' => "yyyy-MM-dd",
                    'momentDatetimeFormat' => 'YYYY-MM-DD',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'login' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-sign-in" aria-hidden="true"></i>',
                            $url,
                            [
                                'title' => Yii::t('app', 'Login')
                            ]
                        );
                    },
                ],
                'visibleButtons' => [
                    'login' => Yii::$app->user->can('administrator')
                ]

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
