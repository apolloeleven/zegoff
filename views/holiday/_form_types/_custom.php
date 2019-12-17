<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/7/19
 * Time: 6:15 PM
 */

use app\models\Holiday;
use trntv\yii\datetime\DateTimeWidget;

?>
<?php  $disabled = false;?>
<div class="row">
    <div class="col-md-4">
        <?php echo $form->field($model, 'title')->textInput() ?>
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
    <div class="col-md-9">
        <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
</div>

