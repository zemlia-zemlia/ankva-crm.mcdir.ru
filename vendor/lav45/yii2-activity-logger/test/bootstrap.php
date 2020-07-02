<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

new \yii\console\Application([
    'id' => 'unit',
    'basePath' => __DIR__,
    'components' => [
        'cache' => [
            'class' => \yii\caching\MemCache::class,
            'useMemcached' => extension_loaded('memcached'),
        ],
    ]
]);
