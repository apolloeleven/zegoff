<?php

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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'type',
            'status',
            'title',
            //'start_date',
            //'end_date',
            //'description:ntext',
            //'going_to',
            //'trip_reason:ntext',
            //'travel_coast',
            //'spink_income',
            //'accommodation:ntext',
            //'client_entertainment:ntext',
            //'currency_code',
            //'date_require',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            //'confirmed_at',
            //'created_by',
            //'updated_by',
            //'deleted_by',
            //'confirmed_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
