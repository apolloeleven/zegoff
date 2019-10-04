<?php

use app\models\UserProfile;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('app', 'Edit profile')
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin() ?>

    <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'middlename')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>


    <?php echo $form->field($model, 'gender')->dropDownlist([
        UserProfile::GENDER_FEMALE => Yii::t('app', 'Female'),
        UserProfile::GENDER_MALE => Yii::t('app', 'Male')
    ]) ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
