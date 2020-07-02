<?php
/*
 * Yii2 Ide Helper
 * https://github.com/takashiki/yii2-ide-helper
 */

class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication
     */
    public static $app;
}

/**
 * @property yii\caching\FileCache $cache
 * @property yii\i18n\Formatter $formatter
 * @property yii\swiftmailer\Mailer $mailer
 * @property yii\db\Connection $db
 */
abstract class BaseApplication extends \yii\base\Application {}