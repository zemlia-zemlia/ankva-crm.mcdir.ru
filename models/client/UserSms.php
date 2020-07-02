<?php

namespace app\models\client;

use Yii;
use app\models\User;

/**
 * This is the model class for table "user_sms".
 *
 * @property int $id
 * @property int $user_id
 * @property int $staff_id
 * @property string $number
 * @property string $message
 * @property int $date
 * @property int $status
 *
 * @property User $user
 * @property Staff $staff
 */
class UserSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'number', 'message'], 'required'],
            [['user_id', 'staff_id', 'date', 'status'], 'safe'],
            [['message'], 'string', 'max' => 255],

            [['number'], 'string', 'max' => 25],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['user_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'staff_id' => 'Сотрудник',
            'number' => 'Номер',
            'message' => 'Сообщение',
            'date' => 'Дата',
            'statusName' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
    public function getStatusName()
    {
        return ($this->status) ? "Доставлено":"Отправлено";
    }

    /**
     * {@inheritdoc}
     * @return UserSmsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserSmsQuery(get_called_class());
    }
}
