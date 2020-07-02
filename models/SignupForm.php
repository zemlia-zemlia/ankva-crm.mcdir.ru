<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $username;
    public $email;
    public $password;
    public $checkbox;
    public $phone;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот номер уже используется'],
            ['username', 'string', 'min' => 10, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот e-mail уже используется.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['verifyCode', 'captcha'],

            ['checkbox', 'compare', 'compareValue' => 1, 'message' => 'Необходимо принять условия, чтобы продолжить пользоваться сервисом'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }



        $user = new User();

      //  $user->username = $this->username;
        //$user->email = $this->email;
        $user->username = preg_replace('/[^0-9]/', '', $this->username);
        $user->email = $this->email;

        $user->setPassword($this->password);
        $user->generateAuthKey();

   Yii::$app->mailer->compose()
    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
    ->setTo($this->email)

    ->setSubject('Регистрация аккаунта') // тема письма
    ->setTextBody('Благодарим Вас за регистрацию в сервисе Сканер-Недвижимости.рф)')
    ->setHtmlBody('<p><b>Здравствуйте!</b><br>Благодарим Вас за регистрацию в сервисе Сканер-Недвижимости.рф <br> Для входа в личный кабинет используйте следующие данные:<br>Логин: '.$this->email.'<br>Пароль: '.$this->password.'<br> Сайт: <a href="http://сканер-недвижимости.рф">Сканер-недвижимости.рф</a> </p>')
    ->send();


        return $user->save() ? $user : null;

 


    }

}