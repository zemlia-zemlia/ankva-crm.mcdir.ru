<?php

namespace app\helpers;

use app\models\SaleStage;
use yii\helpers\ArrayHelper;

class StageHelper
{
    public static function stageList()
    {
        $stages = SaleStage::find()->select(['id', 'name'])->asArray()->all();
        return ArrayHelper::map($stages, 'id', 'name');
    }

    public static function stageName($stage)
    {
        $stage = SaleStage::find()->where(['id' => $stage])->one();
        return $stage->name;
    }
}