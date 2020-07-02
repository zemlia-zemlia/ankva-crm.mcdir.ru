<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blackphones".
 *
 * @property int $id
 * @property int $id_user
 * @property int $phone
 */
class Blackphones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blackphones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'phone'], 'required'],
            [['id', 'id_user', 'phone'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'phone' => 'Phone',
        ];
    }
}
