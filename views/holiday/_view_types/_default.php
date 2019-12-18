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
                    <td class="title"><?php echo Yii::t('app', 'Created At') ?></td>
                    <td><?php echo Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                </tr>
                <tr>
                    <td class="title"><?php echo Yii::t('app', 'Updated At') ?></td>
                    <td><?php echo Yii::$app->formatter->asDatetime($model->updated_at) ?></td>
                </tr>
                <tr> <?php if ($model->confirmed_at) : ?>
                        <td class="title"><?php echo Yii::t('app', 'Reviewed At') ?></td>
                        <td><?php echo Yii::$app->formatter->asDatetime($model->confirmed_at) ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td class="title"><?php echo Yii::t('app', 'Created By') ?></td>
                    <td><?php echo $model->createdBy->userProfile->getFullName() ?></td>
                </tr>
                <tr>
                    <td class="title"><?php echo Yii::t('app', 'Modified By') ?></td>
                    <td><?php echo $model->updatedBy->userProfile->getFullName() ?></td>
                </tr>
                <tr> <?php if ($model->confirmedBy) : ?>
                        <td class="title"><?php echo Yii::t('app', 'Reviewed By') ?></td>
                        <td><?php echo $model->confirmedBy->userProfile->getFullName() ?></td>
                    <?php endif; ?>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6 holiday-panel">
            <table class="table">
                <tbody>
                <tr>
                    <td class="title"><?php echo Yii::t('app', 'ID') ?></td>
                    <td><?php echo $model->id ?></td>
                </tr>
                <tr>
                    <td class="title"><?php echo Yii::t('app', 'Type') ?></td>
                    <td><?php echo $model->getTypeText() ?></td>
                </tr>
                <tr>
                    <td class="title"><?php echo Yii::t('app', 'Status') ?></td>
                    <td><?php echo $model->getStatusText() ?></td>
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