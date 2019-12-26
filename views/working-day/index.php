<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\WorkingDaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Working Days');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-day-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'weekday',
//            'week_index',
            'is_working_day:boolean',
            [
                'attribute' => 'start_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asTime($model->start_at, 'HH:mm');
                }
            ],
            [
                'attribute' => 'end_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asTime($model->end_at, 'HH:mm');
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>


</div>
