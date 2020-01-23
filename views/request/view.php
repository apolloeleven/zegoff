<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Holiday */
$this->title = Yii::t('app', '{employee} {type} Holiday', [
    'employee' => $model->user->userProfile->getFullName(),
    'type' => \app\models\Holiday::types()[$model->type],
]);
$this->title = $this->title ." : ID $model->id";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holidays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="holiday-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(  [
        'fieldConfig' => ['inputOptions' => ['class' => 'form-control input-sm' ,'disabled' => true]],
    ]); ?>
    <?php echo $this->render('@app/views/holiday/_form_types/_' . $model->getViewName(), ['form' => $form, 'model' => $model, 'disabled' => true]) ?>

    <?php ActiveForm::end(); ?>

    <?php echo $this->render('@app/views/holiday/_view_types/_default',
        [
            'model' => $model,
        ]) ?>

</div>


<?php
$js = "";
foreach ($model->errors as $attribute => $messages) {
    $msg = implode("<br>", $messages);
    $js .= "  
         Lobibox.notify('error', {
              sound: false,
              position: 'top right',
              delay: 3500,
              showClass: 'fadeInDown',
              title: '$attribute',
              msg: " . '"' . $msg . '"' . "
         });
     ";
}

$this->registerJs($js)

?>
