<?php

namespace app\models;

/**
 * This is the model class for table "metro_station".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $color
 * @property string $city
 */
class MetroStation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'metro_station';
    }

    public function rules()
    {
        return [
            [['title', 'title_en', 'color', 'city'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'title_en' => 'Title En',
            'color' => 'Color',
            'city' => 'City',
        ];
    }
}
