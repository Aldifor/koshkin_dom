<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout'=>'default',
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'FfuQJmy4-Lhcmh_dmnjwyfnJTUHCbWeT',
        ],
        
        // 'vk' => [
        //     'class' => 'jumper423\VK',
        //     'clientId' => '6995449',
        //     'clientSecret' => '9SHh0a9Ke6vaPwb2SYlD',
        //     'access_token' => '',
        //     'delay' => 0.7, // Минимальная задержка между запросами
        //     'delayExecute' => 120, // Задержка между группами инструкций в очереди
        //     'limitExecute' => 1, // Количество инструкций на одно выполнении в очереди
        //     'captcha' => 'captcha', // Компонент по распознованию капчи
        // ],
        // 'authClientCollection' => [
        //     'class' => 'yii\authclient\Collection',
        //     'clients' => [
        //         'vkontakte' => [
        //             'class' => 'jumper423\VK',
        //             'clientId' => '6995449',
        //             'clientSecret' => '9SHh0a9Ke6vaPwb2SYlD',
        //             'access_token' => '',
        //             'delay' => 0.7,
        //             'delayExecute' => 120,
        //             'limitExecute' => 1,
        //             'captcha' => 'captcha',
        //             'scope' => 'friends,photos,pages,wall,groups,email,stats,ads,offline,notifications', //,messages,nohttps
        //             'title' => 'ВКонтакте'
        //         ],
        //     ],
        // ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '' => 'main/index',
                'abclan' => 'main/abclan',
                'news' => 'main/news',
                'communication' => 'main/communication',
                'communication/private' => 'main/communication-private',
                'useful' => 'main/useful',
                'voiseservis' => 'main/voiseservis',
                'listusers' => 'main/listusers',
                'register' => 'account/register',
                'account' => 'account/index',
                'account/change-password' => 'account/change-password',
                'admin' => 'admin/main/index',
                'admin/creat-news' => 'admin/main/creat-news',
                'admin/list-users' => 'admin/main/list-users',
                'admin/kos' => 'admin/main/kos',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
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
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'cathouse.gild.pw@gmail.com',
                'password' => 'yXB%t~bsm2$w',
                'port' => '587',
                'encryption' => 'tls',
                ],
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
