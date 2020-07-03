<?php
setlocale(LC_ALL, 'ru_RU.utf8');
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
Yii::setAlias('@images', dirname(__DIR__) . '/web/uploads');


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',

    'bootstrap' => ['log'],
    'name' => 'CRM',

    'sourceLanguage' =>'ru-RU',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [


        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],

        'SMSCenter' => [
            'class' => 'integready\smsc\SMSCenter',
            'login' => '',
            'password' => '',
            'useSSL' => false,
            'options' => [
                'sender' => 'ParserN',   // имя отправителя
//                'hlr' => 1,
//                'translit', // кодировать ли сообщения в транслит (self::TRANSLIT_NONE)
//                'charset',  // кодировка запроса и ответа (self::CHARSET_UTF8)
//                'fmt',      // формат ответа сервера (self::FMT_JSON)
//                'type',     // тип сообщения (self::MSG_SMS), замена push, ping, hlr и прочих
//                'cost',     // запрашивать ли стоимость (self::COST_NO)
//                'time',     // время отправки сообщения (null)
//                'tz',       // часовой пояс параметра time (null)
            ],
        ],
        'config' => [ // сам компонент прописываем
            'class' => 'app\components\Config',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/views/client/yii2-app'//'@vendor/dmstr/yii2-adminlte-asset/example-views/testing/app' //
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'nfnnfnbhfibhdFdccwed^87e8xscscdcfeegtb',
            'baseUrl'=> '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [

            //'class' => 'dektrium\user\Module',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache' //Включаем кеширование
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
'formatter' => [
    'dateFormat' => 'dd.MM.YYYY',
    'timeFormat' => 'php:H:i:s',
    'decimalSeparator' => ',',
    'thousandSeparator' => ' ',
    'defaultTimeZone' => 'UTC',
    'timeZone' => 'Europe/Moscow',
    'locale' => 'ru-RU'
],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
        'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'rent-scanner@yandex.ru',
                'password' => '810Ag70vKla',
                'port' => '465',
                'encryption' => 'ssl',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'pages/<page:[\w-]+>' => 'pages/default/index',

            ],
        ],



        /**
         * Компонент принимает и управляет логами
         */
        'activityLogger' => [
            'class' => \lav45\activityLogger\Manager::class,

            // Включаем логирование для PROD версии
            'enabled' => YII_ENV_DEV,

            // при вызове метода `clean()` будут удалены все данные добавленные 365 дней назад
            'deleteOldThanDays' => 365,

            // идентификатор компонента `\yii\web\User`
            'user' => 'user',

            // Поле для отображения имени из модели пользователя
            'userNameAttribute' => 'username',

            // идентификатор компонента хранилища логов `\lav45\activityLogger\StorageInterface`
            'storage' => 'activityLoggerStorage',

            'messageClass' => [
                'class' => \lav45\activityLogger\LogMessage::class,

                // При использовании компанета когда пользователь ещё не авторизировался его действия
                // можно записывать от имени "Неизвесный пользователь", к примеру.
                'userId' => 'cron',
                'userName' => 'Неизвесный пользователь',

                // Окружение из которого проиводило действие
                'env' => 'console',

                // Так же можно указать значение по умолчанию и для других параметров
                // 'entityId' => '...',
                // 'createdAt' => time(),
                // 'action' => '...',
                // 'data' => [" ... "],
            ],
        ],

        /**
         * Компонент принимает и управляет логами
         */
        'activityLoggerStorage' => [
            'class' => \lav45\activityLogger\DbStorage::class,

            // Имя таблицы в которой будут хранится логи
            'tableName' => '{{%activity_log}}',

            // идентификатор компонента `\yii\db\Connection`
            'db' => 'db',
        ]





    ],

    'modules' => [
    'pages' => [
        'class' => 'bupy7\pages\Module',


    ],
        'dynagrid'=> ['class'=>'\kartik\dynagrid\Module'],
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module'
        ],
        'gridview' => ['class' => 'kartik\grid\Module'],
        'logger' => [
            'class' => \lav45\activityLogger\modules\Module::class,

            // Список моделей которые логировались
            'entityMap' => [
                'user' => 'app\models\User',
            ],
        ]
//





//
],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
       'allowedIPs' => ['127.0.0.1',  '79.126.56.121','::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
       'allowedIPs' => ['*', '79.126.56.121', '::1'],
    ];
}

return $config;
