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

<?php if ($model->status == 0): ?>
    <form class="form-horizontal" action="<?php echo \yii\helpers\Url::to(['holiday/confirm']) ?>" method="post">
        <div style="margin-left: 10px">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                   value="<?= Yii::$app->request->csrfToken; ?>"/>
            <div class="form-group field-holiday-type">
                <label class="control-label"><h4>Reject/Approve</h4></label>
                <div id="holiday-type" aria-invalid="false">
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" value="2" required>Approve
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" value="1">Reject
                        </label>
                    </div>
                </div>
            </div>
            <input type="hidden" value="<?= Html::encode($model->id) ?>" name="id">
            <div class="form-group">
                <div style="margin-top: 15px">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
<?php endif; ?>