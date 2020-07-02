<?php

namespace app\models\client;

use Yii;
use app\models\User;
use app\models\client\Client;

/**
 * This is the model class for table "client_notes".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $client_id
 * @property int $date
 * @property int $message
 *
 * @property Staff $staff
 * @property Client $client
 */
class ClientNotes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_notes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'client_id', 'date', 'message'], 'required'],
            [['staff_id', 'client_id', 'date'], 'integer'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'client_id' => 'Client ID',
            'date' => 'Date',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(User::className(), ['id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}
