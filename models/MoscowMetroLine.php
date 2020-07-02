<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "msk_metro_line".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string $color
 */
class MoscowMetroLine extends ActiveRecord
{
    public static function tableName()
    {
        return 'msk_metro_line';
    }

    public function rules()
    {
        return [
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
