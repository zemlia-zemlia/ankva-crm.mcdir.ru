<?php

namespace app\models\client;

use Yii;
use app\models\Role;

/**
 * This is the model class for table "accessByTime".
 *
 * @property int $id
 * @property string $role
 * @property int $time_from
 * @property int $time_to
 *
 * @property User $user
 */
class AccessByTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accessByTime';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'required'],
            [['time_from', 'time_to'], 'integer'],
            [['role'], 'string' ]

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'role',
            'time_from' => 'Time From',
            'time_to' => 'Time To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['name' => 'role']);
    }
}
