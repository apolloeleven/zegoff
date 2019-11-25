<?php
/* @var $this yii\web\View */
/* @var $model app\models\UserForm */
/* @var $roles yii\rbac\Role[] */
$this->title = Yii::t('app', 'Create new Employee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>

    <?php $this->registerJsFile('@web/js/user-form.js') ?>

</div>
