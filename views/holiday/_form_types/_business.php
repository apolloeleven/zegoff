<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/7/19
 * Time: 6:40 PM
 */

use app\models\Holiday;
use trntv\yii\datetime\DateTimeWidget; ?>


<div class="row">
    <div class="col-md-4">
        <?php echo $form->field($model, 'going_to')->textInput(['style' => 'width:300px']) ?>
    </div>
    <div class="col-md-2">
        <?php if ($disabled): ?>
            <?php  $model->status = $model->getStatusText()?>
            <?php echo $form->field($model, 'status')->textInput(['style' => ($model->status == "Accepted") ? 'color: green !important;' : 'color: red !important;'])  ?>
        <?php endif;?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label><?php echo Yii::t('app', 'From Date') ?></label>
        <?php echo DateTimeWidget::widget([
            'model' => $model,
            'attribute' => 'start_date',
            'phpDatetimeFormat' => "yyyy-MM-dd",
            'momentDatetimeFormat' => 'YYYY-MM-DD',
            'options' => ['disabled' => $disabled]
        ]) ?>
    </div>
    <div class="col-md-4">
        <label><?php echo Yii::t('app', 'To Date') ?></label>
        <?php echo DateTimeWidget::widget([
            'model' => $model,
            'attribute' => 'end_date',
            'phpDatetimeFormat' => "yyyy-MM-dd",
            'momentDatetimeFormat' => 'YYYY-MM-DD',
            'options' => ['disabled' => $disabled]
        ]) ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4">
        <?php echo $form->field($model, 'start_time')->dropDownList(Holiday::getStartTimeDropdown()) ?>
    </div>
    <div class="col-md-4">
        <?php echo $form->field($model, 'end_time')->dropDownList(Holiday::getEndTimeDropdown()) ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-8">
        <?= $form->field($model, 'trip_reason')->textarea(['rows' => 6]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'travel_coast')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'income')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'currency_code')->dropDownList(\app\models\Holiday::getCurrencies()) ?>
    </div>
    <div class="col-md-4">
        <label><?php echo Yii::t('app', 'Date Require') ?></label>
        <?php echo DateTimeWidget::widget([
            'model' => $model,
            'attribute' => 'date_require',
            'phpDatetimeFormat' => "yyyy-MM-dd",
            'momentDatetimeFormat' => 'YYYY-MM-DD',
            'options' => ['disabled' => $disabled]
        ]) ?>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <?= $form->field($model, 'accommodation')->textarea(['rows' => 6]) ?>

    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <?= $form->field($model, 'client_entertainment')->textarea(['rows' => 6]) ?>
    </div>
</div>






