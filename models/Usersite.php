<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
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
 */
class Usersite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'status', 'created_at', 'updated_at', 'balance', 'access_from', 'access_to', 'demo', 'id_company'], 'required'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'string'],
            [['status', 'created_at', 'updated_at', 'balance', 'access_from', 'access_to', 'demo', 'id_company'], 'integer'],
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
        ];
    }
}
