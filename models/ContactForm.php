<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $checkbox;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
            ['checkbox', 'compare', 'compareValue' => 1, 'message' => 'Необходимо принять условия, чтобы отправить сообщение'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Ваш email',
            'subject' => 'Тема письма',
            'body' => 'Сообщение',

            'verifyCode' => 'Проверочный код',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
            ->setTo('rent-scanner@yandex.ru')
            ->setFrom(['rent-scanner@yandex.ru' => 'Запрос Технической поддержки'])
                ->setSubject('Обратная связь - Новый тикет')
        //        ->setTextBody($this->body)
    ->setHtmlBody('<p>Тикет из формы Обратной связи <br> Имя отправителя: '.$this->name.' <br> E-mail отправителя: '.$this->email.'<br>Тема письма: '.$this->subject.'<br>Сообщение: '.$this->body.'</p>')

                ->send();

            return true;
        }
        return false;
    }
}
