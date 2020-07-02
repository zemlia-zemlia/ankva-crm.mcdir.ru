<?php

namespace app\controllers\client;

use app\models\client\Client;
use app\models\User;
use Yii;
use app\models\client\ClientPayment;
use app\models\client\ClientPaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\client\UserSmsController;
use app\models\client\UserSms;
use app\models\client\StaffLog;
use app\controllers\SiteController;
/**
 * ClientPaymentController implements the CRUD actions for ClientPayment model.
 */
class ClientPaymentController extends SiteController
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


    public function beforeAction($action)
    {
        \app\components\rbac\RulesAdditional::rule();
        $this->enableCsrfValidation = false;



        return parent::beforeAction($action);
    }

    /**
     * Lists all ClientPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientPayment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionChangeStatus($id, $status)
    {
        $payment = ClientPayment::find()->where(['id' => $id])->one();

        $payment->status = $status;
        if ($payment->save()){

           if ($payment->status == 1) {
             $this->clientOn($payment->client_id);

           }

        }


        return $this->redirect(['/client/client/update?id='.$payment->client_id]);
    }

    /**
     * Creates a new ClientPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($client_id, $staff_id)
    {

        if (!Yii::$app->user->can('addClientPayment'))  {
            \Yii::$app->session->setFlash('error', 'Вам запрещено добавлять платежи');
            return $this->redirect('/client/client/update/?id='.$client_id);
        }

        $model = new ClientPayment();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->date = time();
            if ($model->type == 1) {
                $model->status = 0;

            }
            if ($model->save()){

                if ($model->status == 1) {
                  $this->clientOn($client_id);
                }

                $staffLog =  new StaffLog();
                $staffLog->type = 3;
                $staffLog->user_id = $client_id;
                $staffLog->staff_id = Yii::$app->user->id;
                $staffLog->ip = Yii::$app->request->remoteIP;
                $staffLog->data = 'Добавлен платеж';
                $staffLog->created_at = time();

                $staffLog->save();


                Yii::$app->session->setFlash('success', 'Платеж успешно добавлен');
                return $this->redirect(['/client/client/update?id='.$client_id]);
            }

        }

        $model->client_id = $client_id;
        $model->staff_id = $staff_id;
        $model->status = 1;
        $model->type = 1;

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function clientOn($id){
       if (Client::changeStatus($id, 1) && Client::changeType($id, 1)){

           $client = Client::find()->where(['id' => $id])->one();
           $user = User::find()->where(['id' => $client->user_id])->one();
           $password = rand(10000,99999);
           $user->setPassword($password);

           $user->generateAuthKey();
           $user->save();



           $client->password_view = $password;
           $site = $this->context->url;
           $client->save();

           $mobile=substr(preg_replace('/[^0-9]/', '', $client->mobile), 1);

           $smsBody = "Ваши данные для входа: Логин ".$mobile." Пароль ".$password." Сайт: ".$site."";

           if( $client->sms_login =='1'){
               $result = UserSmsController::sendSms($client->mobile, $smsBody);
           }else{
               Yii::$app->session->setFlash('success',  'Платеж успешно добавлен');
               return true;
           }


           if($result ){
               $sms = new UserSms();
               $sms->user_id = $client->id;
               $sms->number = $client->mobile;
               $sms->message = $smsBody;
               $sms->sms_id = $result;
               $sms->status = 0;
               $sms->staff_id = 0;
               $sms->date = time();
//               var_dump($sms);die;
               $sms->save();

               $client->sms = $client->sms+1;
               $client->save();


               Yii::$app->session->setFlash('success',  'Платеж успешно добавлен, клиенту отправлен доступ.');
                return true;
           }

           else
           return false;
       }
        Yii::$app->session->setFlash('error', 'Произошла ошибка при обработке платежа.');
        return false;
    }





    /**
     * Updates an existing ClientPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClientPayment model.
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
     * Finds the ClientPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientPayment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
