<?php

namespace app\models;

/**
 * This is the model class for table "typeproperty_commerc".
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string $reduced
 * @property int $active
 * @property string $rang
 * @property string $name_href
 * @property string $name_full
 * @property int $id_company
 */
class CommercialTypeProperty extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'typeproperty_commerc';
    }
}
