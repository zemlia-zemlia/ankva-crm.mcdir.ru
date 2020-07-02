<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FileStylerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/filestyler.min.css',
        'css/filestyler-theme.min.css',
    ];
    public $js = [
        'js/filestyler-style-only.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
}