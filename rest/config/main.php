<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'rest-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'rest\controllers\crud\RestCrudModule'
        ],
        'v2' => [
            'class' => 'rest\controllers\read\RestReadModule'
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/categories', 'v1/orders', 'v1/products', 'v1/partners', 'v1/users',
                        'v2/categories',
                    ]
                ],
                'OPTIONS v1/user/login' => 'v1/user/login',
                'POST v1/user/login' => 'v1/user/login',
                'OPTIONS v1/user/register' => 'v1/user/register',
                'POST v1/user/register' => 'v1/user/register'
            ],
        ],
    ],
    'params' => $params,
];
