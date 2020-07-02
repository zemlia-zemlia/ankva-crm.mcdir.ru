<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "favorite_objects".
 *
 * @property int $id
 * @property integer $user_id
 * @property string $ads
 */
class FavoriteObject extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite_objects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['ads'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'ads' => 'Ads',
        ];
    }
}
