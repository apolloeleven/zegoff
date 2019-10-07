<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankHoliday */

$this->title = Yii::t('app', 'Create Bank Holiday');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank Holidays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-holiday-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
