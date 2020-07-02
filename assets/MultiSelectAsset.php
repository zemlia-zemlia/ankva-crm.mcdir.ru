<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class MultiSelectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery.multiselect.css',
    ];
    public $js = [
        // 'js/jquery-ui.min.js',
        'js/jquery.multiselect.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}