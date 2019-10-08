<?php
/**
 * Created by PhpStorm.
 * User: zura
 * Date: 10/7/19
 * Time: 6:40 PM
 */

use yii\widgets\DetailView; ?>


<?= DetailView::widget([
    'model' => $model,
    'attributes' => array_merge($attributes, [
        'id',
        'user_id',
        'type',
        'status',
        'title',
        'start_date',
        'end_date',
        'description:ntext',
        'going_to',
        'trip_reason:ntext',
        'travel_coast',
        'income',
        'accommodation:ntext',
        'client_entertainment:ntext',
        'currency_code',
        'date_require',
        'created_at',
        'updated_at',
        'deleted_at',
        'confirmed_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'confirmed_by',
    ]),
]) ?>



