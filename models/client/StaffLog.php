<?php

namespace app\models\client;

use Yii;
use app\models\User;

/**
 * This is the model class for table "staff_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property string $url
 * @property int $type ---  1: client update, 2: client create, 3 client payment create, 4 client payment update, 5 client sms send
 *                          6 client chanfge status,    0 - test2devices
 * @property int $staff_id
 * @property string $data
 * @property int $created_at
 *
 * @property User $user
 * @property Staff $staff
 *
 */
class StaffLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id', 'type', 'staff_id', 'created_at'], 'integer'],
            [['ip', 'url'], 'string', 'max' => 255],
            [['data'], 'string', 'max' => 1024],
            [['user_id', 'type', 'created_at', 'ip', 'url', 'data' , 'cookie' , 'user_agent', 'count_devices', 'id'], 'safe'],

//            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['staff_id' => 'id']],
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
            'ip' => 'Ip',
            'url' => 'Url',
            'type' => 'Type',
            'staff_id' => 'Сотрудник',
            'data' => 'Данные',
            'created_at' => 'Дата',
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
}
