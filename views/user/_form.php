<?php

use app\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin() ?>
    <?php echo $form->field($model, 'username') ?>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'firstname') ?>
    <?php echo $form->field($model, 'lastname') ?>
    <?php echo $form->field($model, 'status')->dropDownList(User::statuses()) ?>
    <?php echo $form->field($model, 'position')->dropDownList(User::positions()) ?>
    <?php echo $form->field($model, 'department_id')->dropDownList(\app\models\Department::getDropdown()) ?>
    <?php echo $form->field($model, 'days_left')->textInput() ?>
    <?php echo $form->field($model, 'password')->passwordInput() ?>

    <?php echo $form->field($model, 'roles')->checkboxList($roles) ?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end() ?>

</div>
