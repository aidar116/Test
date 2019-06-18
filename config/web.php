<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'language' => 'ru-RU',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4bNEbISgeKYXljLubnO6N6Ktc4vWwFld',
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				['pattern' => '<action:(login|logout|registration|adminer|search)>', 'route' => 'site/<action>',],
                ['pattern' => 'project/<action:(edit|delete)>/<id:\d+>', 'route' => 'project/<action>',],
                ['pattern' => 'project/<action:(new)>', 'route' => 'project/<action>',],
                ['pattern' => 'project/<id:\d+>', 'route' => 'task/index',],
                ['pattern' => 'task/<action:(edit|delete|new)>/<id:\d+>', 'route' => 'task/<action>',],
                ['pattern' => 'user/<action:(ban|delete)>/<id:\d+>', 'route' => 'site/<action>',]
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
		
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
