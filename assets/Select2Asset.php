<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class Select2Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/select2.min.css',
    ];
    public $js = [
        'js/select2.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}