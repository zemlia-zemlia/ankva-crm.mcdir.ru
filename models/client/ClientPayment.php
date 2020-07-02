<?php

namespace app\models\client;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "client_payment".
 *
 * @property int $id
 * @property int $client_id
 * @property int $payment_id
 * @property int $staff_id
 * @property int $date
 * @property int $status ( 0 - проверка платежа, 1 - платеж проведен)
 * @property int $summ
 * @property int $type
 *
 * @property Client $client
 * @property Staff $staff
 */
class ClientPayment extends \yii\db\ActiveRecord
{




    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'staff_id',  'status', 'summ', 'type'], 'required'],
            [['payment_id','date','comment'], 'safe'],
            [['client_id', 'staff_id', 'date', 'status', 'summ', 'type'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'client_id' => 'Client ID',
//            'payment_id' => 'Payment ID',
            'staff_id' => 'Менеджер',
            'date' => 'Дата',

            'summ' => 'Сумма',
            'type' => 'Способ оплаты',
            'status' => 'Статус',
            'comment' => 'Комментарий'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * {@inheritdoc}
     * @return ClientPaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientPaymentQuery(get_called_class());
    }


}
