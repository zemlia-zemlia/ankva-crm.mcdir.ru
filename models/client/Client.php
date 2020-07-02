<?php

namespace app\models\client;

use Yii;
use app\models\City;
use app\models\User;
use app\models\District;
use app\models\Region;
use app\models\TypeProperty;
use app\models\client\Payments;
use app\validators\PhoneValidator;

/**
 * This is the model class for table "client".
 *
 * @property int $id
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
 * @property string $status
 * @property string $fullName
 *
 * @property City $city
 * @property User $user_id

 * @property Region $region
 * @property District $district

 * @property Staff $staff
 */
class Client extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
//    public function setStatus($status){
//        $this->status = $status;
//        return true;
//
//    }

    public static function  changeStatus($id, $status)
    {
        $client = self::find()->where(['id' => $id])->one();

        $client->status = $status;
        if ($client->save()) {
            $staffLog =  new StaffLog();
            $staffLog->type = 6;
            $staffLog->user_id = $client->id;
            $staffLog->staff_id = Yii::$app->user->id;
            $staffLog->ip = Yii::$app->request->remoteIP;
            $staffLog->data = 'Изменение статуса пользователя';
            $staffLog->created_at = time();

            $staffLog->save();



            return true;
        }

        return false;
    }


    public static function changeType($id, $type)
    {
        $client = self::find()->where(['id' => $id])->one();
        $client->client_type = $type;
        if ($client->save()) {


            return true;
        }

        return false;
    }



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
            [['mobile', 'firstname',  'region', 'typeproperty', 'user_id',  'city_id'], 'required'],


            [['status',  'region', 'city_id','price_from', 'price_to', 'client_type', 'staff_id', 'user_id', 'access_days', 'date_registration', 'password_view', 'sms',  'sms_send', 'parser_bd', 'parser_sms', 'sms_login', 'id_company'], 'integer'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 64],
            [['metro'], 'string', 'max' => 255],

            [['source'], 'string', 'max' => 255],
            [['typeproperty', 'district' ], 'safe'],
            [['mobile' ,'dop_tel'],PhoneValidator::class],

            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['region'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region' => 'id']],


            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'mobile' => 'Телефон',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'dop_tel' => 'Дополнительный телефон',
            'region' => 'Регион',
            'district' => 'Район',
            'city_id' => 'Город',
            'typeproperty' => 'Тип недвижимости',
            'metro' => 'Метро',

            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'client_type' => 'Тип клиента',
            'staff_id' => 'Ответственный',
            'source' => 'Сайт',
            'user_id' => 'id',
            'status' => 'Статус',
            'access_days' => 'Кол-во дней',
            'sms_send' => 'Кол-во SMS',
            'id_company' => 'id_company',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
    public function getCityAndRegion()
    {
        return $this->regionObj->name.' / '.$this->city->name;
    }



//    public function getTypePropertyOoj()
//    {
//        return $this->hasOne(TypeProperty::className(), ['id' => 'typeproperty']);
//    }
//    public function getTypePropertyName(){
//        return $this->typePropertyOoj->name;
//    }
//    public function getTypePropertyList(){
//
//        var_dump($this->typePropertyOoj);die;
//        return $this->typePropertyOoj->list;
//    }

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



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
    public function getStaffName()
    {

        return $this->staff->fullname;
    }

    /**
     * {@inheritdoc}
     * @return ClientQuery the active query used by this AR class.
     */

    public function getFullName(){
        $_full_name = $this->lastname.' '.$this->firstname.' '.$this->middlename;
        return $_full_name;
    }
//    public function getClientPayment(){
//        $userPayments = Payments::findAll(['user_id' => 1]);
//
//        return $userPayments;
//
//    }
    public static function getPaymentList($id)
    {
        return ClientPayment::find()->where(['client_id' => $id])->all();
    }

    public  function getUserObj()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public  function getUserId()
    {
        return $this->getUserObj()->id;
    }
    public static  function getClientNumber($user_id)
    {
        $client = Client::findOne(['user_id' => $user_id]);


        return $client->mobile;
    }
    public function getClientTypeName()
    {
        return  ["Потенциальный","Пользователь"];
    }
    public static function getClientStatus()
    {
        return  ["Не активен","Активен"];
    }







}
