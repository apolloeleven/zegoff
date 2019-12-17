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


<?= DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'table detail-view', 'style' => '  font-family: sans-serif;padding: 0 16px;font-style: italic;font-size: 16px;'],
    'attributes' => array_merge(array_merge($main_attributes, [
        'title',
        'description:ntext',
    ]), $attributes),
]) ?>



