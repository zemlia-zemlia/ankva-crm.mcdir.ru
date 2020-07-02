<?php

namespace app\helpers;
use Yii;
use app\models\Category;
use yii\helpers\Html;
use app\controllers\CategoryController;

class SiteHelper
{


    public static function categoryTypeName($category_id)
    {
        $category = Category::findOne($category_id);
        return $category->title;
    }

}