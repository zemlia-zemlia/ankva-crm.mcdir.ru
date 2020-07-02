<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "contragents".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $middlename
 * @property string $phone
 * @property string $email
 * @property string $telegram
 * @property string $whatsapp
 * @property string $viber
 * @property string $vk
 * @property string $sex
 */
class Contragent extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contragents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['name', 'surname', 'middlename', 'phone', 'email', 'telegram', 'whatsapp', 'viber', 'vk', 'sex'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'middlename' => 'Middlename',
            'phone' => 'Phone',
            'email' => 'Email',
            'telegram' => 'Telegram',
            'whatsapp' => 'Whatsapp',
            'viber' => 'Viber',
            'vk' => 'Vk',
            'sex' => 'Sex',
        ];
    }
}
