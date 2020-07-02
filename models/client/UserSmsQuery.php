<?php

namespace app\models\client;

/**
 * This is the ActiveQuery class for [[UserSms]].
 *
 * @see UserSms
 */
class UserSmsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserSms[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserSms|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
