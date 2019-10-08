<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Holiday */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="holiday-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

        <?php echo $this->render('@app/views/holiday/types/_' . $model->getViewName(), ['form' => $form, 'model' => $model]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php

foreach ($model->errors as $attribute => $messages) {
    $msg = implode("<br>", $messages);
    $this->registerJs("  
         Lobibox.notify('error', {
              sound: false,
              position: 'top right',
              delay: 5000,
              showClass: 'fadeInDown',
              title: '$attribute',
              msg: '$msg'
         });
     ");
}

?>