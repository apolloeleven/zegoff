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
        'going_to',
        'trip_reason:ntext',
        'travel_coast',
        'income',
        'accommodation:ntext',
        'client_entertainment:ntext',
        'currency_code',
        'date_require',
    ]), $attributes),
]) ?>



