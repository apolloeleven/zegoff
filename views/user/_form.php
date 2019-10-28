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

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?php echo $this->title ?></h3>
    </div>
    <div class="panel-body">

        <div class="user-form">

            <?php $form = ActiveForm::begin() ?>

            <div class="row">
                <div class="col-md-3">
                    <?php echo $form->field($model, 'username') ?>

                </div>
                <div class="col-md-3">
                    <?php echo $form->field($model, 'email') ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?php echo $form->field($model, 'firstname') ?>

                </div>
                <div class="col-md-3">
                    <?php echo $form->field($model, 'lastname') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?php echo $form->field($model, 'position')->dropDownList(User::positions()) ?>

                </div>
                <div class="col-md-3">
                    <?php echo $form->field($model, 'department_id')->dropDownList(\app\models\Department::getDropdown()) ?>

                </div>
            </div>


            <div class="row">
                <div class="col-md-3">
                    <?php echo $form->field($model, 'days_left')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?php echo $form->field($model, 'status')->dropDownList(User::statuses()) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?php echo $form->field($model, 'password')->passwordInput() ?>
                </div>
            </div>


            <?php echo $form->field($model, 'roles')->checkboxList($roles) ?>
            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end() ?>

        </div>
    </div>
</div>

