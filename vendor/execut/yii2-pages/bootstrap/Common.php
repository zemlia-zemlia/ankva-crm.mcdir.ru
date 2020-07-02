<?php
/**
 */

namespace execut\pages\bootstrap;

use execut\pages\Module;
use execut\yii\Bootstrap;
use yii\i18n\PhpMessageSource;

class Common extends Bootstrap
{
    protected $isBootstrapI18n = true;
    public function getDefaultDepends()
    {
        return [
            'bootstrap' => [
                'navigation' => [
                    'class' => \execut\navigation\Bootstrap::class,
                ],
            ],
            'modules' => [
                'pages' => [
                    'class' => Module::class,
                ],
            ],
        ];
    }
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        parent::bootstrap($app);
        $app->urlManager->showScriptName = false;
        $app->urlManager->enablePrettyUrl = true;
    }
}