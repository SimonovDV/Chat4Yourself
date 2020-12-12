<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$components_urlManager = require __DIR__ . '/components/urlManager.php';
$components_assetManager = require __DIR__ . '/components/assetManager.php';
$components_response = require __DIR__ . '/components/response.php';

$config = [
    'id' => 'basic',
    'name' => 'Сам себе чат',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DxWCXgl8SkllGa4jwexy2HKxJR4_NjZk',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => $components_urlManager,
        'assetManager' => $components_assetManager,
        'response' => $components_response,
        
    ],
    'modules' => [
        //'1c' => [
        //    'class' => 'app\modules\1c\Module',
        //],        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    unset($config['components']['cache']);
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*', '::1'],
    ];
}

return $config;
