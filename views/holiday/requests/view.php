<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Holiday */
$this->title = Yii::t('app', '{employee} {type} Holiday', [
    'employee' => $model->user->userProfile->getFullName(),
    'type' => \app\models\Holiday::types()[$model->type],
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holidays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="holiday-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('../_view_types/_default',
        [
            'model' => $model,
        ]) ?>


</div>
