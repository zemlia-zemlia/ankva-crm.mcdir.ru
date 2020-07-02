<?php

namespace app\models;

/**
 * This is the model class for table "spb_metro".
 *
 * @property int $id
 * @property string $loc_metro_line_id
 * @property string $title
 * @property string $title_en
 */
class SpbMetro extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'spb_metro';
    }

    public function rules()
    {
        return [
            [['loc_metro_line_id', 'title', 'title_en'], 'required'],
            [['loc_metro_line_id'], 'string', 'max' => 40],
            [['title', 'title_en'], 'string', 'max' => 255],
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
