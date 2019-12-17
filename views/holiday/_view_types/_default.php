<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/8/19
 * Time: 6:08 PM
 * @var $this yii\web\View
 * @var $model app\models\Holiday
 */
?>


<div class="col-md-8">
    <div class="row">
        <div class="col-sm-6 holiday-panel">
            <table class="table">
                <tbody>
                <tr>
                    <td><?php echo Yii::t('app', 'Created At') ?></td>
                    <td><?php echo Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Updated At') ?></td>
                    <td><?php echo Yii::$app->formatter->asDatetime($model->updated_at) ?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Reviewed At') ?></td>
                    <td><?php echo Yii::$app->formatter->asDatetime($model->confirmed_at) ?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Created By') ?></td>
                    <td><?php echo $model->createdBy->userProfile->getFullName() ?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Modified By') ?></td>
                    <td><?php echo $model->updatedBy->userProfile->getFullName() ?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Reviewed By') ?></td>
                    <td><?php echo $model->confirmedBy->userProfile->getFullName() ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6 holiday-panel">

            <?php echo $this->render('@app/views/holiday/_view_types/_' . $model->getViewName(), ['model' => $model]); ?>
        </div>

    </div>
</div>

<style>
    .holiday-panel .table > tbody > tr > td {
        border-top: none;
        font-style: italic;

    }
    .holiday-panel {
        margin: 0;
        border: 1px solid #ddd;
    }
</style>