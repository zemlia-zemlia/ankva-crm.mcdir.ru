<?php

namespace app\models\client;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $id_user
 * @property string $operation_id
 * @property string $amount
 * @property string $withdraw_amount
 * @property string $currency
 * @property string $datetime
 * @property string $sender
 * @property string $id_company
 * @property string $label
 * @property string $sha1_hash
 * @property string $notification_type
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'operation_id', 'amount', 'withdraw_amount', 'currency', 'datetime', 'sender', 'id_company', 'label', 'sha1_hash', 'notification_type'], 'required'],
            [['id_user'], 'integer'],
            [['operation_id', 'amount', 'withdraw_amount', 'currency', 'datetime', 'sender', 'id_company', 'label', 'sha1_hash', 'notification_type'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'operation_id' => 'Operation ID',
            'amount' => 'Amount',
            'withdraw_amount' => 'Withdraw Amount',
            'currency' => 'Currency',
            'datetime' => 'Datetime',
            'sender' => 'Sender',
            'id_company' => 'Id Company',
            'label' => 'Label',
            'sha1_hash' => 'Sha1 Hash',
            'notification_type' => 'Notification Type',
        ];
    }
}
