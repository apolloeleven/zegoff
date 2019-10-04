<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'pluralize' => false,
            'controller' => [
                'api/v1/guest'
            ],
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS <action>/{id}' => 'options',
                'PUT <action>/{id}' => 'update',
                'GET <action>/{id}' => '<action>',
                'GET search' => 'search',
                'DELETE delete' => 'delete',
                'DELETE delete/{id}' => 'delete',
            ]
        ]
    ]
];
