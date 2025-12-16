<?php

return [
    'default' => 'file',
    'channels' => [
        'file' => [
            'path' => BASE_PATH . '/storage/logs/app.log',
        ],
        'daily' => [
            'path' => BASE_PATH . '/storage/logs/daily.log',
            'days' => 7,
        ],
        'error' => [
            'path' => BASE_PATH . '/storage/logs/error.log',
        ],
    ],
];