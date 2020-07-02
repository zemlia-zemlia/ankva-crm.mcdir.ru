<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 24.10.19
 * Time: 17:07
 */

namespace app\components;
use app\models\User;
use app\models\client\StaffLog;
use Yii;

class Logger
{

    public static function log($id){

//        $user = User::find()->where(['id' => $id ])->one();

        $cookie = Yii::$app->request->cookies->getValue('_identity', 0);

       $log = StaffLog::find()->where(['type' => 0])
           ->andWhere(['user_id' => $id])
           ->andWhere(['cookie' => $cookie])
           ->andWhere(['user_agent' => md5(Yii::$app->request->userAgent)])
           ->one();
        if(!$log){
            $log = new StaffLog();
            $log->user_id = $id;
            $log->cookie = $cookie;
            $log->type = 0;
            $log->ip = Yii::$app->request->remoteIP;
            $log->user_agent = md5(Yii::$app->request->userAgent);
            $log->created_at = time();
            $log->save();
//            var_dump($log);



        }
        else{

            $log->ip = Yii::$app->request->remoteIP;
            $log->user_agent = md5(Yii::$app->request->userAgent);
            $log->created_at = time();
            $log->save();



        }










    }








}



