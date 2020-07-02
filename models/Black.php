<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "black".
 *
 * @property int $id
 * @property int $id_user
 * @property string $phone
 */
class Black extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'black';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'phone'], 'required'],
            [['id_user', 'phone'], 'integer'],
            [['name', 'description'], 'string'],

            ['phone', 'unique', 'targetAttribute' => ['phone', 'id_user'] ,'message' => 'Этот номер уже внесен в базу'],
            ['phone', 'string', 'min' => 10, 'max' => 10],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date2' => 'Дата добавления',
            'id_user' => 'Пользователь',
            'phone' => 'Телефон',
            'name' => 'Имя',
            'description' => 'Комментарий',

        ];
    }
}
