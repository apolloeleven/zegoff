<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/7/19
 * Time: 6:15 PM
 */

use trntv\yii\datetime\DateTimeWidget;

?>

<div class="row">
    <div class="col-md-4">
        <?php echo $form->field($model, 'title')->textInput() ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label><?php echo Yii::t('app', 'From') ?></label>
        <?php echo DateTimeWidget::widget([
            'model' => $model,
            'attribute' => 'start_date',
            'phpDatetimeFormat' => "yyyy-MM-dd HH:mm:ss",
            'momentDatetimeFormat' => 'YYYY-MM-DD HH:mm:ss',
        ]) ?>
    </div>
    <div class="col-md-4">
        <label><?php echo Yii::t('app', 'To') ?></label>
        <?php echo DateTimeWidget::widget([
            'model' => $model,
            'attribute' => 'end_date',
            'phpDatetimeFormat' => "yyyy-MM-dd HH:mm:ss",
            'momentDatetimeFormat' => 'YYYY-MM-DD HH:mm:ss',
        ]) ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-8">
        <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
</div>



