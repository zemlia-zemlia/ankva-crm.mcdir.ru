<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "blacklist_objects".
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property int $date
 */
class BlacklistObject extends ActiveRecord
{
    public static function tableName()
    {
        return 'blacklist_objects';
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'date'], 'integer'],
            [['phone'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Phone',
            'date' => 'Date',
        ];
    }
}
