<style>
    .fc-time {
        display: none !important;
    }
</style>

<?php

use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = Yii::t('app', 'Calendar');

echo edofre\fullcalendar\Fullcalendar::widget([
    'events' => Url::to(['/site/events']),
]);
?>
