<?php

use Swoft\Http\Server\HttpServer;

return [
    'logger'     => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],
    'httpServer' => [
        'class'   => HttpServer::class,
        'port'    => 18306,
        /* @see HttpServer::$setting */
        'setting' => [
            'worker_num' => 8,
        ]
    ]
];
