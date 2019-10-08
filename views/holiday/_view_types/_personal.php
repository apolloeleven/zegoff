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
    'attributes' => array_merge(array_merge($main_attributes, [
        'title',
        'description:ntext',
    ]), $attributes),
]) ?>



