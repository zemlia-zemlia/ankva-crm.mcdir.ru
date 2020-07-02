<?php

namespace app\models\client;

use Yii;
use app\models\User;

/**
 * This is the model class for table "user_log".
 *
 * @property int $id
 * @property string $date
 * @property int $login
 * @property string $browser
 * @property string $ip
 *
 * @property User $login0
 */
class UserLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'login', 'browser', 'ip'], 'required'],
            [['date'], 'safe'],
            [['login'], 'integer'],
            [['browser', 'ip'], 'string', 'max' => 255],
            [['login'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['login' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'login' => 'Логин',
            'browser' => 'Браузер / ОС / Тип устройства',
            'ip' => 'Ip',
            'user.username' => 'Логин'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'login']);
    }

    public function getLog($user_id){
        $user = new UserLog;
        $user->ip = Yii::$app->request->remoteIP;
        $user->login = $user_id;

         $_browser =    get_browser(Yii::$app->request->userAgent) ;
        $user->browser = $_browser->browser . ' / ' . $_browser->platform . ' / ' . $_browser->device_type;
        $user->date = time();
        //var_dump($user);die;
        $user->save();
    }
//   public static function getLog($user_id){
//        $user = new UserLog;
//        $user->ip = Yii::$app->request->remoteIP;
//        $user->login = User::findIdentity($user_id);
//        var_dump($user->login);
//        $user->browser = Yii::$app->request->userAgent;
//        $user->date = time();
//        $user->save();
//    }

}
