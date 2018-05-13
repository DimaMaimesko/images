<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        
//        'cache' => [
//        'class' => 'yii\caching\MemCache',
//        'servers' => [
//            [
//                'host' => 'server1',
//                'port' => 11211,
//                'weight' => 100,
//            ],
//           
//        ],
//    ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//        ],
        
        'cache' => [
        'class' => 'yii\redis\Cache',
         'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 1,
            ]
        ],
         'storage' => [
            'class' => 'frontend\components\Storage',
        ],
        'onLineUsers' => [
            'class' => 'frontend\components\OnLineUsers',
        ],
         'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
       
    ],
];

