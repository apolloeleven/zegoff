<?php

use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WorkingDay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="working-day-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'is_working_day')->dropDownList([
                Yii::t('app', 'No'),
                Yii::t('app', 'Yes')
            ]) ?>
        </div>
        <div class="col-md-4">
            <label><?php echo Yii::t('app', 'Start At') ?></label>
            <?php echo DateTimeWidget::widget([
                'model' => $model,
                'attribute' => 'start_at',
                'phpDatetimeFormat' => "HH:mm",
                'momentDatetimeFormat' => 'HH:mm',
            ]) ?>

        </div>
        <div class="col-md-4">
            <label><?php echo Yii::t('app', 'End At') ?></label>
            <?php echo DateTimeWidget::widget([
                'model' => $model,
                'attribute' => 'end_at',
                'phpDatetimeFormat' => "HH:mm",
                'momentDatetimeFormat' => 'HH:mm',
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
