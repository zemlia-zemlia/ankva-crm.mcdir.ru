<?php

namespace app\models;

/**
 * This is the model class for table "spb_metro_line".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $color
 */
class SpbMetroLine extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'spb_metro_line';
    }

    public function rules()
    {
        return [
            [['title', 'title_en'], 'required'],
            [['title', 'title_en'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 40],
            [['title'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'title_en' => 'Title En',
            'color' => 'Color',
        ];
    }
}
