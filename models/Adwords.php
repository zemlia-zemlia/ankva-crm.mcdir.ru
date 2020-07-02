<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "adwords".
 *
 * @property int $id
 * @property string $name
 * @property int $color
 */
class Adwords extends ActiveRecord
{
    public static function tableName()
    {
        return 'adwords';
    }

    public static function adwordList()
    {
        $adwords = self::find()->select(['id', 'name'])->asArray()->all();
        return ArrayHelper::map($adwords, 'id', 'name');
    }

    public static function adwordName($id)
    {
        $adword = self::find()->where(['id' => $id])->one();
        return $adword->name;
    }
}
