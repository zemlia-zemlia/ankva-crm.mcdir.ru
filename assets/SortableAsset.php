<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class SortableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/sortable.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
}