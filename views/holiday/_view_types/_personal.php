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
?>


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


