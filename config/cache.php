<?php

return [
    'default' => 'file',
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => BASE_PATH . '/storage/cache',
        ],
    ],
];