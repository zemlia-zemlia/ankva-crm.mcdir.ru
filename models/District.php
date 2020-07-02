<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property int $id
 * @property string $login
 * @property string $citys
 * @property string $name_href
 * @property int $id_company
 * @property int $active
 */
class District extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',  'active'], 'integer'],
            [['login', 'citys', 'name_href'], 'string'],
            [['login'], 'required'],
            [['id', 'id_company',], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Район',
            'citys' => 'Город',
            'name_href' => 'Район предложный падеж',
            'id_company' => 'Id Company',
            'active' => 'Active',
        ];
    }





}
