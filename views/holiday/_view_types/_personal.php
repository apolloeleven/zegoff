<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/7/19
 * Time: 6:40 PM
 *
 * @var $attributes array
 * @var $main_attributes array
 */

use yii\widgets\DetailView; ?>


<table class="table">
    <tbody>
    <tr>
        <td><?php echo Yii::t('app', 'Title') ?></td>
        <td><?php echo $model->title ?></td>
    </tr>
    <tr>
        <td><?php echo Yii::t('app', 'Description') ?></td>
        <td><?php echo Yii::$app->formatter->asNtext($model->description) ?></td>
    </tr>
    </tbody>
</table>

