<style>
    .fc-time {
        display: none !important;
    }
</style>

<?php

use yii\helpers\Url;
use yii\web\JsExpression;

echo edofre\fullcalendar\Fullcalendar::widget([
    'clientOptions' => [
        'eventResize' => new JsExpression("
                function(event, delta, revertFunc, jsEvent, ui, view) {
                    console.log(event.id);
                    console.log(delta);
                }
            "),
    ],
    'events' => Url::to(['/site/events']),
]);
?>
