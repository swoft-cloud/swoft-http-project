<?php

use App\Common\DbSelector;
use Swoft\Db\Database;
use Swoft\Db\Pool;
use Swoft\Http\Server\HttpServer;
use Swoft\Server\SwooleEvent;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Task\Swoole\TaskListener;

return [
    'logger'           => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],
    'httpServer'       => [
        'class'    => HttpServer::class,
        'port'     => 18306,
        'listener' => [
            'rpc' => bean('rpcServer')
        ],
        'process' => [
//            'monitor' => bean(MonitorProcess::class)
        ],
        'on'       => [
//            SwooleEvent::TASK   => bean(SyncTaskListener::class),  // Enable sync task
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting'  => [
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true
        ]
    ],
    'httpDispatcher'   => [
        // Add global http middleware
        'middlewares' => [
            \App\Http\Middleware\FavIconMiddleware::class,
            // Allow use @View tag
            \Swoft\View\Middleware\ViewMiddleware::class,
        ],
    ],
    'db'               => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=test;host=172.17.0.2',
        'username' => 'root',
        'password' => 'swoft123456',
    ],
    'db2'              => [
        'class'      => Database::class,
        'dsn'        => 'mysql:dbname=test2;host=172.17.0.2',
        'username'   => 'root',
        'password'   => 'swoft123456',
        'dbSelector' => bean(DbSelector::class)
    ],
    'db2.pool'         => [
        'class'    => Pool::class,
        'database' => bean('db2')
    ],
    'db3'              => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=test2;host=172.17.0.2',
        'username' => 'root',
        'password' => 'swoft123456'
    ],
    'db3.pool'         => [
        'class'    => Pool::class,
        'database' => bean('db3')
    ],
    'migrationManager' => [
        'migrationPath' => '@app/Migration',
    ],
];
