<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    //'language' => 'ru-RU',
    'language' => 'en-US',
    'bootstrap' => [
        'log',
        [
         'class' => 'frontend\components\LanguageSelector'  
        ],
        
        
    ],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
        'post' => [
            'class' => 'frontend\modules\post\Module',
        ],
     ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
//        'session' => [
//            'class' => 'yii\web\DbSession',
//            'timeout' => 60*10,    //'expire' field
//            'writeCallback' => function ($session) {
//                return [
//                    'user_id' => Yii::$app->user->id,
//                    'last_write' => time(),
//                ];
//            },
//        ],
//       'cache2' => [
//        'class' => 'yii\redis\Cache',
////         'redis' => [
////                'hostname' => 'localhost',
////                'port' => 6379,
////                'database' => 1,
////            ]
//        ],
        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    //'levels' => ['error', 'warning'],
                    'levels' => ['info'],
                    //'logVars' => [''],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
               'privacy' => 'site/index', 
               'moreusers' => 'site/add-users', 
               'morefeeds' => 'site/add-feeds', 
               'experinent' => 'site/session-experinent', 
               'profile/<nickname:\w+>' => 'user/profile/view', 
               'subscribe/<id:\d+>' => 'user/profile/subscribe', 
               'unsubscribe/<id:\d+>' => 'user/profile/unsubscribe', 
               'comments/<postId:\d+>' => 'post/comments/comment-form-view', 
               'edit/<postId:\d+>/<commentId:\d+>' => 'post/comments/edit', 
            ],
        ],
       
        'FeedService' => [
            'class' => 'frontend\components\FeedService',
        ],
        'i18n' => [
        'translations' => [
            '*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                //'basePath' => '@app/messages',
                //'sourceLanguage' => 'en-US',
//                'fileMap' => [
//                    'app'       => 'app.php',
//                    'app/error' => 'error.php',
//                ],
            ],
        ],
    ],
        
    ],
    'params' => $params,
//       'on afterRequest' => function () {
//    //exit('Остановка перед запуском приложения.');
//                
//},   
];

