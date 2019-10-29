<?php

use app\grid\EnumColumn;
use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
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
            'username',
            'email:email',
            [
                'attribute' => 'position',
                'filter' => User::positions(),
                'value' => function($model){
                    return User::positions()[$model->position];
                }
            ],
            [
                'class' => EnumColumn::class,
                'attribute' => 'status',
                'enum' => User::statuses(),
                'filter' => User::statuses()
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
