<?php

namespace app\models\client;

use app\models\User;
use app\models\Role;
use Yii;
use app\models\client\Office;
use app\models\City;
use yii\db\ActiveRecord;
use app\components\Logger;
use app\validators\PhoneValidator;

/**
 * This is the model class for table "staff".
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
 * @property string $birthday
 * @property string $passport
 * @property string $parent_info


 * @property string $fullname
 *
 * @property Office $office
 * @property Client[] $clients
 */
class Staff extends  ActiveRecord//extends User
{


//    public function init(){
//        $this->log();
//        return parent::init();
//    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {

        return 'staff';
    }
    public $file;
    public $del_img;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'status', 'mobile', 'firstname', 'lastname', 'middlename', 'username', 'password', 'role'], 'required'],
            [['passport', 'parent_info', 'site_info', 'site_role'], 'string'],
            [['file'], 'file', 'extensions' => 'png, jpg',  'checkExtensionByMimeType' => true,
                'maxSize' => 512000],
            [['del_img' ], 'boolean'],
            [[ 'office','status','site_view' ], 'integer'],
            [['birthday',  'user_id'], 'safe'],
            ['username', 'unique'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 64],
            [['mobile'],PhoneValidator::class],
            [['mobile_dop'],PhoneValidator::class],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'del_img' => 'Удалить изображение',
            'mobile' => 'Мобильный номер',
            'mobile_dop' => 'Дополнительный мобильный номер',

            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'birthday' => 'День рождения',
            'passport' => 'Паспортные данные',
            'parent_info' => 'Сведения о родителях',
            'office' => 'Офис',
            'file' => 'Фото профиля',
            'username' => 'Логин',
            'password' => 'Пароль',
            'role' => 'Должность',
            'status' => 'Статус',
            'site_view' => 'Отображение сотрудника на сайте',

            'site_info' => 'Информация о сотруднике на сайте',
            'site_role' => 'Должность отображаемая на сайте',
            'email' => 'E-mail',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::className(), ['staff_id' => 'id']);
    }


    /**
     * {@inheritdoc}
     * @return StaffQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaffQuery(get_called_class());
    }

    public function getFullName(){
        $_full_name = $this->lastname . ' ' .$this->firstname.' '.$this->middlename;
        return $_full_name;
    }
    public function getOfficeObj()
    {
        return $this->hasOne(Office::class, ['id' => 'office']);
    }
    public function getOfficeName()
    {
//        $off = Office::findOne($this->office);
//
//        return $off ? $off->office : '- Не назначен -';
        return $this->officeObj ? $this->officeObj->name : '- Не назначен -';

    }



    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id'])
            ->viaTable('office', ['id' => 'office']);
    }

    public function getCityName(){
        return $this->city->name;
    }


    public function getUserStatus(){
        if ($this->status == User::STATUS_ACTIVE) return 'Активен';
        if ($this->status == User::STATUS_DELETED) return 'Заблокирован';
       // if ($this->status == User::STATUS_ACTIVE) return '<span class ="user_active">Активен</span>';
//        if ($this->status == User::STATUS_DELETED) return '<span class ="user_active">Заблокирован</span>';

    }
    public static function getStatusList(){
       $list = [['status' => 0 , 'desc' => 'Заблокирован'], ['status' => 10, 'desc' => 'Активен']];
      return \yii\helpers\ArrayHelper::map($list, 'status', 'desc');


    }

    public static function getList()
    {
        $list =  Staff::find()->select(['id','lastname', 'firstname', 'middlename'])->asArray()->all();
        $list1 = [];
        foreach($list as $staff) $list1[] = ['id' => $staff['id'], 'name' => $staff['lastname']. ' '.  $staff['firstname']
            . ' ' . $staff['middlename'] ];
        return \yii\helpers\ArrayHelper::map($list1, 'id', 'name');
    }

    public function getUser()
    {

        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getRoleObj(){
        return $this->hasOne(Role::className(), ['name' => 'role']);

    }




}
