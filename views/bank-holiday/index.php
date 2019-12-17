<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BankHolidaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bank Holidays');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-holiday-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Bank Holiday'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => 'id',
                'contentOptions' => ['style' => 'width:80px; '],
            ],
            'date',
            'description:ntext',
            [
                'label' => Yii::t('app', 'Created By'),
                'attribute' => 'creator',
                'value' => function ($model) {
                    /* @var $model app\models\BankHoliday */
                    return $model->createdBy->userProfile->getFullName();
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
