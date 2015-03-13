<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    
    'language'=> 'en',
    'sourceLanguage'=> 'en',
    
    
    
    //'defaultRoute'=>'book/index',
    //'catchAll'=>['book/index'],
    
    
    
    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                    'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation']
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zcDPFQ-c4sxL3ljnbfz3LDFIRtZ2-NBa',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'enableSession'=> false,
            'loginUrl' => NULL
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
                    'levels' => ['error','warning'],
                    'logVars' => ['_POST'],
                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['info'],
//                    'categories' => ['luke'],
//                    'logVars' => ['_POST'],
//                ],
            ],
        ],
        
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => 
        [
            'enablePrettyUrl'=>'true',
            //'enableStrictParsing'=>'true',
            //
            //'showScriptName'=>'false',
            'rules' => [
                //'books' => 'book/index',
                //'<controller>s' => '<controller>/index',
                //'<controller>/<id:\d+>' => '<controller>/view',   
                //[
                //    'pattern' => 'books',
                //    'route' => 'book/index',
                //    'suffix' => '.html',
                //],
                //'book/view/<id:\d+>'=>'book/view',
            ],
        ],
         'authManager' => [
            'class'=>'yii\rbac\DbManager',
        ],
    ],
    'modules' => [
      'admin' => [
        'class' => 'mdm\admin\Module',  
      ],  
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*',
        ],
    ],
    'as beforeRequest' => [
        'class' => 'app\components\LanguageHandler',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
