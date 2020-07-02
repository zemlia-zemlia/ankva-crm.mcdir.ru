<?php

namespace app\models;

use Yii;
use app\models\Country;

class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }
    
    
    public function rules() {
        return [
            [['country_id'], 'integer'],
            ['name', 'string'],
            ['name', 'trim'],
//            [['id'], 'unique'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'name' => 'Область',
            'country_id' => 'Страна'
        ];
    }

    public function getCountry(){

        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}