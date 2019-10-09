<?php

use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BankHoliday */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-holiday-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <label><?php echo Yii::t('app', 'Date') ?></label>
            <?php echo DateTimeWidget::widget([
                'model' => $model,
                'attribute' => 'date',
                'phpDatetimeFormat' => "yyyy-MM-dd",
                'momentDatetimeFormat' => 'YYYY-MM-DD',
            ]) ?>
        </div>
    </div>
    <br>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
