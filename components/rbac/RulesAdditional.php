<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 04.11.19
 * Time: 20:23
 */

namespace app\components\rbac;

use Yii;

class RulesAdditional {

    public static function rule(){
        if(\app\models\AuthItemChild::find()->where(['parent'=> Yii::$app->user->identity->role])
            ->andWhere(['child' => 'twoDevice'])->exists()){
            if (!Yii::$app->user->can('twoDevice')) {
                \Yii::$app->session->setFlash('error', 'Вам запрещен доступ с двух устройств');
                Yii::$app->response->redirect(array('/site/index'))->send();
                Yii::$app->end();
            }
        }

        if (!Yii::$app->user->can('accessByTime') || !Yii::$app->user->can('accessByIp'))  {
            \Yii::$app->session->setFlash('error', 'Вам запрещен доступ');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }






    }

}