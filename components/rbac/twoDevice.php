<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 04.11.19
 * Time: 10:42
 */

namespace app\components\rbac;
use yii\rbac\Rule;
use Yii;

use app\models\client\StaffLog;

class twoDevice extends Rule
{
    public $name = 'isTwoDevices';

    public function execute($user, $item, $params)
    {
       $user_id =  Yii::$app->user->id;

        $oldLog = StaffLog::find()->where(['<', 'created_at', (time() - 60)])
            ->andWhere(['type' => 0])
            ->all();
        if($oldLog) foreach($oldLog as $ol) $ol->delete();

        $logs = StaffLog::find()->where(['user_id' => $user_id])
            ->andWhere(['type' => 0])->count();
//        var_dump($logs);die;

        if($logs > 1) return false;


return true;



    }
}