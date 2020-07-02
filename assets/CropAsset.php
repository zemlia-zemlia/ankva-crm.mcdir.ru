<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class CropAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/cropper.min.css',
    ];
    public $js = [
        'js/cropper.min.js',
        // 'js/crop.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
}