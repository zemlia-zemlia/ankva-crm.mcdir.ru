<?php

namespace app\models\client;

use app\models\TypeProperty;
use Yii;

use app\helpers\LocationHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\District;
use app\models\Region;
use app\models\City;
use app\models\client\Staff;
use app\validators\PhoneValidator;

/**
 * This is the model class for table "object_import".
 *
 * @property int $id* @property int $category
 * @property int $property_type
 * @property int $type

 * @property int $region_id
 * @property int $city_id
 * @property int $district_id

 * @property string $street
 * @property string $home

 * @property int $floor
 * @property int $total_floor
 * @property int $total_area
 * @property int $living_area
 * @property int $kitchen_area

 * @property int $price

 * @property string $name
 * @property string $phone
 * @property string $phone_2


 * @property string $description

 * @property int $staff

 * @property int $source

 * @property string $images
 * @property int $status

 * @property int $created_at
 * @property int $updated_at


 *
 * @property District $district

 */


class RealtyObject extends ActiveRecord
{
public $removeFoto;


    public static function tableName()
    {
        return 'object_import';
    }




    public function rules()
    {
        return [
            [[ 'region_id', 'city_id', 'street', 'home',  'name', 'phone',   'price', 'property_type'], 'required'],
            [[ 'property_type',  'region_id', 'city_id', 'district_id',  'floor', 'total_floor',
                'total_area', 'living_area', 'kitchen_area',   'staff',  'source'], 'integer'],

            [['description'], 'string'],


            [[ 'description', 'floor', 'total_floor', 'total_area', 'property_type', 'id', 'removeFoto', 'staffname', 'status'], 'safe'],
            [['street', 'home', 'name'], 'string', 'max' => 255],
            [['phone', 'phone_2'], PhoneValidator::class],


            [['images'], 'string'],

        ];
    }

    // -----------------------------------




    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'property_type' => 'Тип недв.',

            'repair' => 'Ремонт',
            'furniture' => 'Мебель',
            'address' => 'Адрес',
            'region_id' => 'Область',
            'city_id' => 'Город',
            'district_id' => 'Район',
            'districtName' => 'Район',

            'street' => 'Улица',
            'home' => 'Дом',

            'floor' => 'Этаж',
            'total_floor' => 'Этажность',
            'floors' => 'Этажность',
            'total_area' => 'Общая площадь',
            'living_area' => 'Жилая площадь',
            'kitchen_area' => 'Площадь кухни',

            'price' => 'Стоимость',

            'name' => 'Имя',
            'phone' => 'Телефон',
            'phone_2' => 'Доп. телефон',

            'description' => 'Описание',

            'staff' => 'Отв. пользователь',

            'source' => 'Источник',

            'images' => 'Фотографии',
            'created_at' => 'Добавлен',
            'updated_at' => 'Изменен',
            'status' => 'Статус',
            'removeFoto' => 'Удалить фотографии',




        ];
    }


    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
    public function getStaffObj()
    {
        return $this->hasOne(Staff::class, ['user_id' => 'staff']);
    }
    public function getStaffname()
    {
        return $this->staffObj->fullname;
    }

    public function getDistrict()
    {
        return $this->hasOne(District::class, ['id' => 'district_id']);
    }
    public function getDistrictName()
    {


        return $this->district_id ?  $this->district->login : 'не задан';
    }

    public function getAddress()
    {
        return '<a href="">'.LocationHelper::regionName($this->region_id) . ', ' . LocationHelper::cityName($this->city_id) . ' ' .
        $this->street . ', ' . ($this->district_id ? ('р-н ' . LocationHelper::districtName($this->district_id) . ' ') : '') .
        $this->home .'</a>' ;
    }
    public function getType()
    {
        return $this->hasOne(TypeProperty::class, ['id' => 'property_type']);
    }

}
