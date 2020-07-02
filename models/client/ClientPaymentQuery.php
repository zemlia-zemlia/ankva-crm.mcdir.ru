<?php

namespace app\models\client;

/**
 * This is the ActiveQuery class for [[ClientPayment]].
 *
 * @see ClientPayment
 */
class ClientPaymentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClientPayment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClientPayment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
