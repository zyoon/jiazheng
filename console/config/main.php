<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'language'=>'zh-CN',
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-console',
        ],
        'user' => [
            'identityClass' => 'common\models\YxCmpUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-console', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the console
            'name' => 'advanced-console',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    // 'aliases' => [
    //     '@bower' => '@vendor/bower-asset',
    //     '@npm'   => '@vendor/npm-asset',
    // ],
    // 'controllerMap' => [
    //     'fixture' => [
    //         'class' => 'yii\console\controllers\FixtureController',
    //         'namespace' => 'common\fixtures',
    //       ],
    // ],
    // 'components' => [
    //     'log' => [
    //         'targets' => [
    //             [
    //                 'class' => 'yii\log\FileTarget',
    //                 'levels' => ['error', 'warning'],
    //             ],
    //         ],
    //     ],
    // ],
    'params' => $params,
];
