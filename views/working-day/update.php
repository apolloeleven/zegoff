<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WorkingDay */

$this->title = Yii::t('app', 'Update Working Day: {name}', [
    'name' => $model->weekday,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Working Days'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="working-day-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
