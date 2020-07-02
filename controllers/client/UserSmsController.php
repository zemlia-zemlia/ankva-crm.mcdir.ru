<?php

namespace app\controllers\client;

use Codeception\Module\Cli;
use Yii;
use app\models\client\UserSms;
use app\models\client\Client;
use app\models\client\UserSmsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use integready\smsc\SMSCenter;
use app\models\client\StaffLog;
use app\models\client\Staff;
use app\models\Company;
use app\controllers\SiteController;
/**
 * UserSmsController implements the CRUD actions for UserSms model.
 */
class UserSmsController extends SiteController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserSms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        var_dump($dataProvider->models[0]);die;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserSms model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * Отправка смс вручную
     */
    public function actionSendAnyone()
    {

        if (!Yii::$app->user->can('sendSMS')  || Yii::$app->user->isGuest)  {
            \Yii::$app->session->setFlash('error', 'Вам запрещено отправлять SMS');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }

        $model = new UserSms();
        $user = Staff::find()->select('id')
        ->where(['user_id' => Yii::$app->user->id])->one();
//
        $user_id = $user->id;

//        var_dump( $user_id);die;
        if ($model->load(Yii::$app->request->post()) ) {

            $sms = $this->sendSms($model->number, $model->message);
//var_dump($sms);die;
            if ($sms) {
                $model->sms_id = $sms;
                $model->status = 1;
                $model->user_id = 1;
                $model->staff_id = $user_id;
                $model->date = time();

//                var_dump($model);die;
//                var_dump($model->save());die;
                $model->save();

                $staffLog =  new StaffLog();
                $staffLog->type = 3;
                $staffLog->user_id = Yii::$app->user->id;
                $staffLog->staff_id = $user_id;
                $staffLog->ip = Yii::$app->request->remoteIP;
                $staffLog->data = 'Отправлено SMS';
                $staffLog->created_at = time();

                $staffLog->save();


            }


            return $this->redirect('/client/user-sms/send-anyone');


        }

        $searchModel = new UserSmsSearch(['user_id' => 1]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);




        return $this->render('create', [
            'model' => $model, 'user_id' => $user_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new UserSms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * Отправка СМС вручную через клиента (Счетчик отправки включен)
     */

    public function actionCreate($user_id)
    {

        if (!Yii::$app->user->can('sendSMS'))  {
            \Yii::$app->session->setFlash('error', 'Вам запрещено отправлять SMS');
            return $this->redirect('/client/client/update/?id='.$user_id);
        }

        $model = new UserSms();
        $client = Client::find()->where(['id' => $user_id])->one();
        if($client->sms < $client->sms_send) {
            if ($model->load(Yii::$app->request->post())) {

                $sms = $this->sendSms($model->number, $model->message);

                if ($sms) {
                    $model->sms_id = $sms;
                    $model->status = 0;
                    $model->save();


                    $staffLog = new StaffLog();
                    $staffLog->type = 3;
                    $staffLog->user_id = $user_id;
                    $staffLog->staff_id = Yii::$app->user->id;
                    $staffLog->ip = Yii::$app->request->remoteIP;
                    $staffLog->data = 'Отправлено SMS клиенту: ' . $model->message . '';
                    $staffLog->created_at = time();

                    $staffLog->save();


                    $client->sms = $client->sms + 1;
                    $client->save();


                }


                return $this->redirect('/client/client/update/?id=' . $user_id);


            }
        }else{
            \Yii::$app->session->setFlash('error', 'Сообщение не отправлено. Лимит СМС превышен');
            return $this->redirect('/client/client/update/?id='.$user_id);
        }

        return $this->render('create', [
            'model' => $model, 'user_id' => $user_id
        ]);
    }

    public static function sendSms($number, $message){

        $company_settings = Company::find()->where(['id' => Yii::$app->user->identity->id_company])->one();


        $number = str_replace(')','',str_replace('(','',str_replace('+', '', str_replace(' ', '', $number))));
        $smsc = Yii::$app->SMSCenter;
        $smsc->login = $company_settings->smsc_login;
        $smsc->password = $company_settings->smsc_password;

        $response =  $smsc->send($number, $message, 'ParserN');
        $response = json_decode($response);
//var_dump($response);die;
        if (isset($response->error)){
            Yii::$app->session->setFlash('error', 'ошибка отправки SMS, код ошибки '. $response->error_code);

            return false;
        }

            Yii::$app->session->setFlash('success', 'SMS успешно отправлено');

        return $response->id;

    }


    /**
     * Updates an existing UserSms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function actionCheckStatus($id)
    {


        $company_settings = Company::find()->where(['id' => Yii::$app->user->identity->id_company])->one();

        $models =  UserSms::find()->where(['user_id' => $id])
            ->andWhere(['status' => 0])->all();

        $smsc = Yii::$app->SMSCenter;
        $smsc->login = $company_settings->smsc_login;
        $smsc->password = $company_settings->smsc_password;

        foreach($models as $model){



            $status  = $smsc->getStatus( $model->number , $model->sms_id , SMSCenter::STATUS_INFO_EXT );
            $status = json_decode($status);

            if (isset($status->error)){
                Yii::$app->session->setFlash('error', 'ошибка проверки статуса SMS, код ошибки '. $status->error_code);

                return false;
            }




            $model->status = $status->status;

            $model->save();


        }


        return true;
    }

    /**
     * Deletes an existing UserSms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserSms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserSms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserSms::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
