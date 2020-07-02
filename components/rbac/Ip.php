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

use app\models\client\AccessByIp;

class Ip extends Rule
{
    public $name = 'isIp';

    /**
     * @param string|integer $user ID пользователя.
     * @param Item $item роль или разрешение с которым это правило ассоциировано
     * @param array $params параметры, переданные в ManagerInterface::checkAccess(), например при вызове проверки
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $role = Yii::$app->user->identity->role;
        $ips = AccessByIp::find()->where(['role' => $role])->one();

        if (!$ips || $ips->ips == '' ) {

            return true;
        }
        $ips = explode(',', $ips->ips);

        foreach($ips as $ip )
            if ($ip == Yii::$app->request->remoteIP) return true;

        return false;


    }
}