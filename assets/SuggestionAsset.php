<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class SuggestionAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/suggestions.min.css',
    ];
    public $js = [
        'js/jquery.suggestions.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}