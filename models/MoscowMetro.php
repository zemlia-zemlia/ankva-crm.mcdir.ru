<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "msk_metro".
 *
 * @property int $id
 * @property string $loc_metro_line_id
 * @property string $title
 * @property string $title_en
 */
class MoscowMetro extends ActiveRecord
{
    public static function tableName()
    {
        return 'msk_metro';
    }

    public function rules()
    {
        return [
            [['loc_metro_line_id'], 'string', 'max' => 40],
            [['title', 'title_en'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loc_metro_line_id' => 'Loc Metro Line ID',
            'title' => 'Title',
            'title_en' => 'Title En',
        ];
    }
}
