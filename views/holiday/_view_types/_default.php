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
        <div class="col-sm-12 holiday-panel">
            <table class="table">
                <tbody>
                <tr>
                    <td class="title col-md-3"><?php echo Yii::t('app', 'Created At') ?></td>
                    <td class="col-md-4"><?php echo Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                    <td class="title col-md-3"><?php echo Yii::t('app', 'Created By') ?></td>
                    <td class="col-md-2"><?php echo $model->createdBy->userProfile->getFullName() ?></td>
                </tr>
                <tr>
                    <td class="title"><?php echo Yii::t('app', 'Updated At') ?></td>
                    <td><?php echo Yii::$app->formatter->asDatetime($model->updated_at) ?></td>
                    <td class="title"><?php echo Yii::t('app', 'Updated By') ?></td>
                    <td><?php echo $model->updatedBy->userProfile->getFullName() ?></td>
                </tr>
                <tr> <?php if ($model->confirmed_at) : ?>
                        <td class="title"><?php echo Yii::t('app', 'Reviewed At') ?></td>
                        <td><?php echo Yii::$app->formatter->asDatetime($model->confirmed_at) ?></td>
                        <td class="title"><?php echo Yii::t('app', 'Reviewed By') ?></td>
                        <td><?php echo $model->confirmedBy->userProfile->getFullName() ?></td>
                    <?php endif; ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .holiday-panel .table {
        margin: 8px 3px 8px 3px;
    }

    .holiday-panel .table > tbody > tr > td {
        border-top: none;
        padding: 1px;
        font-style: italic;
    }

    .holiday-panel .table > tbody > tr .title {
        font-style: normal;
        font-weight: 600;
    }

    .holiday-panel {
        margin: 0;
        border: 1px solid #ddd;
    }
</style>