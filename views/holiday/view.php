<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Holiday */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Holidays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="holiday-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->status == 0) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        </p>
    <?php endif; ?>

    <?php echo $this->render('@app/views/holiday/_view_types/_default',
        [
            'model' => $model,
        ]) ?>

</div>
