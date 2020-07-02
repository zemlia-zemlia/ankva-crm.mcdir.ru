<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\client\Staff;
/**
 * This is the model class for table "object_logs".
 *
 * @property int $log_id
 * @property int $log_category
 * @property int $log_type
 * @property int $log_user_id
 * @property int $log_object_id
 * @property string $log_description
 * @property int $log_old_value
 * @property int $log_new_value
 * @property int $created_at
 *
 * @property User $user
 */
class ObjectLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'object_logs';
    }

    public static function create($category, $type, $user_id, $object_id, $description, $old_value, $new_value)
    {
        $orderLog = new static();
        $orderLog->log_category = $category;
        $orderLog->log_type = $type;
        $orderLog->log_user_id = $user_id;
        $orderLog->log_object_id = $object_id;
        $orderLog->log_description = $description;
        $orderLog->log_old_value = $old_value;
        $orderLog->log_new_value = $new_value;
        $orderLog->created_at = time();
        return $orderLog;
    }

    /**
     * @param ObjectLog $objectLog
     * @return bool
     */
    public function isForOrderLog($objectLog)
    {
        return $this->log_id == $objectLog->log_id;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'log_user_id']);
    }

    public function getStaff(){
        return $this->hasOne(Staff::className(), ['user_id' => 'log_user_id']);
    }
}
