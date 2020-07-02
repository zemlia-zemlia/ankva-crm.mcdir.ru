<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use app\models\Region;
/**
 * This is the model class for table "client".
 *
* @property string $name
 */
class City extends ActiveRecord
{
    //public $name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }
    
    
    public function rules() {
        return [
            [['id', 'region_id'], 'integer'],
            ['name', 'string'],
            ['name', 'trim'],
            [['id'], 'unique'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'name' => 'Город',
            'region_id' => 'Регион'
        ];
    }

    public function getCity(){
        $_full_name = $this->name;
        return $_full_name;
    }

    public function getRegion(){

        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }
    public function getCityFullName(){

        return $this->region->name . ' / ' . $this->name;
    }




}