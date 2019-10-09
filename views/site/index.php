


<style>
    .fc-time {
        display: none !important;
    }
</style>

<?php

echo edofre\fullcalendar\Fullcalendar::widget([
    'options' => [
        'lang' => 'en',
        'class' => "hello",
        //... more options to be defined here!
    ],
    'events' => $events,

]);
?>
