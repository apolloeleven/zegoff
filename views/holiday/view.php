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

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'type',
            'status',
            'title',
            'start_date',
            'end_date',
            'description:ntext',
            'going_to',
            'trip_reason:ntext',
            'travel_coast',
            'spink_income',
            'accommodation:ntext',
            'client_entertainment:ntext',
            'currency_code',
            'date_require',
            'created_at',
            'updated_at',
            'deleted_at',
            'confirmed_at',
            'created_by',
            'updated_by',
            'deleted_by',
            'confirmed_by',
        ],
    ]) ?>

</div>
