<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */
/* @var $roles yii\rbac\Role[] */

$this->title = Yii::t('app', 'Update Employee "{name}"', ['name' => $model->getModel()->getPublicIdentity()]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->email, 'url' => ['view', 'id' => $model->email]];
$this->params['breadcrumbs'][] = ['label'=>Yii::t('app', 'Update')];
?>
<div class="user-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]) ?>

</div>
