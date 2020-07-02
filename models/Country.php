<?php

namespace app\models;

use Yii;

class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }
    
    
    public function rules() {
        return [
            ['id', 'integer'],
            ['name', 'string'],
            ['name', 'trim'],
            [['id'], 'unique'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'name' => 'Страна',
        ];
    }
    
    public function countrySelect() {
        
    }
    public function getName(){
        return $this->name;
    }
}