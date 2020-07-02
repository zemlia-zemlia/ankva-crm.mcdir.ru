<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/animations.css',
        'fonts\font-awesome\css\font-awesome.css',
        'fonts\fontello\css\fontello.css',
        'css/jquery.multiselect.css?v=1547788904',
        'css/select2.min.css',
    ];

    public $js = [
        'js/main.js',
        'js/template.js',
        'js/custom.js',
        'js/modernizr.js',
        'js/client.js',
        '/js/jquery.multiselect.js',
        '/js/jquery.multiselect.js?v=1593547283',
        'js/multisel.js',
        'js/select2.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\FileStylerAsset',
    ];
}


