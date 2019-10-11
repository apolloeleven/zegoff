<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */
$this->title = Yii::t('app', 'Edit account')
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin() ?>

    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'username') ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'email') ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'password')->passwordInput() ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'password_confirm')->passwordInput() ?>

        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
