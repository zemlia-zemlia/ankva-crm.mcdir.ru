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

use app\models\client\AccessByTime;

class Time extends Rule
{
    public $name = 'isTime';

    /**
     * @param string|integer $user ID пользователя.
     * @param Item $item роль или разрешение с которым это правило ассоциировано
     * @param array $params параметры, переданные в ManagerInterface::checkAccess(), например при вызове проверки
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $role = Yii::$app->user->identity->role;
        $time = AccessByTime::find()->where(['role' => $role])->one();

        if (!$time || !$time->time_from || !$time->time_to) {

            return true;
        }
//        var_dump($time);die;
        $start = $time->time_from;
        $finish = $time->time_to;


        $allowedRange = ($start > $finish) ? array_merge(range($start, 23), range(0, $finish)) : range($start, $finish);


        $isCan = in_array(date('G'), $allowedRange);
          //  var_dump($isCan, $allowedRange);die;
        return  $isCan ;

//

    }
}