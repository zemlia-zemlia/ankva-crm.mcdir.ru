<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\client\UserLog;
use yii\web\User as UserComponent;
use app\components\Logger;
use app\models\client\Staff;
use app\models\client\Client;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;


    public static function tableName()
    {
        return '{{%user}}';

    }

    public function transactions()
    {

        return [
            ActiveRecord::SCENARIO_DEFAULT => ActiveRecord::OP_ALL,
        ];
    }









public function behaviors()
    {
        return [
            TimestampBehavior::className(),



        ];
    }

    public function rules()
    {

        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
         ];
    }

    public static function findIdentity($id)
    {
        Logger::log($id);


        $user = static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);

        if (!$user) \Yii::$app->session->setFlash('error', 'Ваш логин заблокирован или такого пользователя не существует');


        return $user;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
//        $username = preg_replace('/[^0-9]/', '', $username);
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
//        Yii::$app->user->on(
//            UserComponent::EVENT_AFTER_LOGIN,
//            $this->afterLogin()
//        );
        //$this->afterLogin();

        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {

        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {

        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }


    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public static function getName($user_id)
    {
        /** @var User $user */
        if ($user == User::findOne($user_id)) {
            return $user->username;
        }
        return '';
    }
    public function userStatus(){

        if ($this->status == self::STATUS_ACTIVE) return '<span class ="user_active">Активен</span>';
        if ($this->status == self::STATUS_DELETED) return '<span class ="user_active">Заблокирован</span>';


    }
    public function getStatusName(){


        if ($this->status == self::STATUS_ACTIVE) return '<span class ="user_active">Активен</span>';
        if ($this->status == self::STATUS_DELETED) return '<span class ="user_active">Заблокирован</span>';


    }

    public function setEmail($_email){
        $this->email = $_email;
        return true;
    }
    public function setUsername($_username){
        $this->username = $_username;
        return true;
    }

    public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'user_id']);
    }
    public function getClient(){
        return $this->hasOne(Client::className(), ['id' => 'user_id']);
    }
    public function getPosition(){
        return $this->hasOne(Role::className(), ['name' => 'role']);
    }





//    public function afterLogin(){
//
//      $log = new UserLog;
//      $log->getLog($this->id);
//        //var_dump($this->id);die;
//  }

}