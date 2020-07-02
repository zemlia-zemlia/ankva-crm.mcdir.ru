<?php

namespace app\models\client;

use Yii;
use app\models\City;
use app\models\District;
use app\models\Region;
use app\models\TypeProperty;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $balance
 * @property int $access_from
 * @property int $access_to
 * @property int $demo
 * @property int $id_company
 * @property string $role
 * @property int $mobile
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property int $dop_tel
 * @property int $city_id
 * @property int $typeproperty
 * @property int $price_from
 * @property int $price_to
 * @property int $client_type
 * @property int $staff_id
 * @property string $source
 *  * @property string $fullName
 *
 * @property City $city

 * @property Region $region
 * @property District $district

 * @property Staff $staff
 */
class Client1 extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'status', 'created_at', 'updated_at', 'mobile', 'firstname', 'lastname', 'middlename', 'typeproperty'], 'required'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'string'],
            [['status', 'created_at', 'updated_at', 'balance', 'access_from', 'access_to', 'demo', 'id_company', 'mobile', 'dop_tel', 'region', 'district', 'city_id', 'typeproperty', 'price_from', 'price_to', 'client_type', 'staff_id'], 'integer'],
            [['role', 'firstname', 'lastname', 'middlename'], 'string', 'max' => 64],
            [['source'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region' => 'id']],
            [['district'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'balance' => 'Balance',
            'access_from' => 'Access From',
            'access_to' => 'Access To',
            'demo' => 'Demo',
            'id_company' => 'Id Company',
            'role' => 'Role',
            'mobile' => 'Телефон',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'dop_tel' => 'Дополнительный телефон',
            'region' => 'Регион',
            'district' => 'Район',
            'city_id' => 'Город',
            'typeproperty' => 'Тип недвижимости',
            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'client_type' => 'Тип клиента',
            'staff_id' => 'Ответственный',
            'source' => 'Сайт',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityObj()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
    public function getCityAndRegion()
    {
        return $this->regionObj->name.' / '.$this->cityObj->name;
    }



    public function getTypePropertyOoj()
    {
        return $this->hasOne(TypeProperty::className(), ['id' => 'typeproperty']);
    }
    public function getTypePropertyName(){
        return $this->typePropertyOoj->name;
    }
    public function getTypePropertyList(){

        var_dump($this->typePropertyOoj);die;
        return $this->typePropertyOoj->list;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionObj()
    {
        return $this->hasOne(Region::className(), ['id' => 'region']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
    public function getStaffName()
    {

        return $this->staff->username;
    }

    /**
     * {@inheritdoc}
     * @return ClientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientQuery(get_called_class());
    }
    public function getFullName(){
        $_full_name = $this->firstname.' '.$this->lastname.' '.$this->middlename;
        return $_full_name;
    }
}
