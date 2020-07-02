<?php

namespace app\models\client;

use Yii;

/**
 * This is the model class for table "accsessByIp".
 *
 * @property int $id
 * @property int $ips
 * @property int $role
 */
class AccessByIp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accsessByIp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role'], 'required'],
            [['id'], 'integer'],
            [['ips' , 'role'] , 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ips' => 'Ips',
            'role' => 'Role',
        ];
    }
}
