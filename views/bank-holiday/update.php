<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankHoliday */

$this->title = Yii::t('app', 'Update Bank Holiday: {name}', [
    'name' => $model->date,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank Holidays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="bank-holiday-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
