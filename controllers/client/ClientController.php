<?php

namespace app\controllers\client;

use app\models\client\ClientNotes;
use app\models\client\ClientPayment;
use app\models\client\StaffLog;
use app\models\client\UserLog;
use app\models\client\UserSms;
use app\models\RealtyObject;
use app\models\User;
use Yii;
use app\models\client\Client;
use app\models\client\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\client\UserSmsSearch;
use app\models\RealtyObjectSearch;
use yii\helpers\ArrayHelper;

use app\models\client\ClientPaymentSearch;
use app\models\client\ClientNotesSearch;
use app\controllers\client\UserSmsController;
use app\models\client\UserLogfSearch;
use yii\behaviors\TimestampBehavior;
use app\models\client\StaffLogSearch;
use yii\filters\AccessControl;
use app\controllers\SiteController;
/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends SiteController
{
    public $active;

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

        if (!Yii::$app->user->isGuest) \app\components\rbac\RulesAdditional::rule();

        $this->enableCsrfValidation = false;

        if (!Yii::$app->user->can('accessClient')  || Yii::$app->user->isGuest)  {
            \Yii::$app->session->setFlash('error', 'Вам запрещен доступ к клиентам');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()

    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];

        $this->active = [true, false, false, false, false];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'active' => $this->active
        ]);
    }

    public function actionMy()

    {
        $searchModel = new ClientSearch(['staff_id' => Yii::$app->user->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];

        $this->active = [false, true, false, false, false];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'active' => $this->active
        ]);
    }

    public function actionPot()

    {
        $searchModel = new ClientSearch(['client_type' => 0]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];

        $this->active = [false, false, true, false, false];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'active' => $this->active
        ]);
    }

    public function actionSuccess()

    {
        $searchModel = new ClientSearch(['status' => 2]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];


        $this->active = [false, false, false, true, false];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'active' => $this->active
        ]);
    }

    public function actionArhiv()

    {
        $searchModel = new ClientSearch(['status' => 3]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];


        $this->active = [false, false, false, false, true];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'active' => $this->active
        ]);
    }



    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('addClient'))  {
            Yii::$app->session->setFlash('error', 'Вам запрещено добавлять клиентов');
            return $this->redirect('index');
        }
        $model = new Client();

        if ($model->load(Yii::$app->request->post())) {
            $user = new User();
            $user->setPassword(rand(10000,99999));
            $user->generateAuthKey();

            $user->setUsername(str_replace(')','',str_replace('(','',str_replace('+7', '', str_replace(' ', '', $model->mobile)))));
//            var_dump($user, $model);die;
            $user->role = 'Client';
            $user->isAdminCRM = '0';
            $user->isFirst = '0';
            $user->isAdmin = '0';
            $query = Yii::$app->request->post();

            if ($user->save()) {

                $query = Yii::$app->request->post();
                $model->id_company = Yii::$app->user->identity->id_company;
            //    $model->metro = '1';
           //     $model->metro[] = ArrayHelper::getValue($query, 'metro');
                $model->metro = $model->metro ? implode(',', $model->metro) : '';

                $model->user_id = $user->getId();
//
                $model->district = json_encode($model->district);

                $model->typeproperty = json_encode($model->typeproperty);



            //    var_dump(Yii::$app->request->post());


                if(!$model->date_registration AND $model->status =='1'){
                    $model->date_registration = time();
                    $staffLog =  new StaffLog();
                    $staffLog->type = 1;
                    $staffLog->user_id = $model->id;
                    $staffLog->staff_id = Yii::$app->user->id;
                    $staffLog->ip = Yii::$app->request->remoteIP;
                    $staffLog->data = 'Предоставлен доступ пользователю';
                    $staffLog->created_at = time();

                    $staffLog->save();
                }
                if($model->status =='0'){
                    $model->date_registration = '0';

                    $staffLog =  new StaffLog();
                    $staffLog->type = 1;
                    $staffLog->user_id = $model->id;
                    $staffLog->staff_id = Yii::$app->user->id;
                    $staffLog->ip = Yii::$app->request->remoteIP;
                    $staffLog->data = 'Заблокирован доступ пользователю';
                    $staffLog->created_at = time();

                    $staffLog->save();

                }



                if ($model->save()) {
                    var_dump($model->errors);

                    $user->user_id = $model->id;
                    $user->save();

                    $staffLog =  new StaffLog();
                    $staffLog->type = 2;
                    $staffLog->user_id = $model->id;
                    $staffLog->staff_id = Yii::$app->user->id;
                    $staffLog->ip = Yii::$app->request->remoteIP;
                    $staffLog->data = 'Добавление пользователя ';
                    $staffLog->created_at = time();
//                    var_dump($user, $model, $staffLog, Yii::$app->user);die;

                    $staffLog->save();


               Yii::$app->session->setFlash('success', 'Пользователь успешно добавлен');
                }

            }
         //   echo var_dump($model->save());

        return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())) {
            $model->district = json_encode($model->district);

            if(!$model->date_registration AND $model->status =='1'){
                $model->date_registration = time();
                $staffLog =  new StaffLog();
                $staffLog->type = 1;
                $staffLog->user_id = $model->id;
                $staffLog->staff_id = Yii::$app->user->id;
                $staffLog->ip = Yii::$app->request->remoteIP;
                $staffLog->data = 'Предоставлен доступ пользователю';
                $staffLog->created_at = time();

                $staffLog->save();
            }
            if($model->status =='0'){
                $model->date_registration = '0';

                $staffLog =  new StaffLog();
                $staffLog->type = 1;
                $staffLog->user_id = $model->id;
                $staffLog->staff_id = Yii::$app->user->id;
                $staffLog->ip = Yii::$app->request->remoteIP;
                $staffLog->data = 'Заблокирован доступ пользователю';
                $staffLog->created_at = time();

                $staffLog->save();

            }

            $model->typeproperty = json_encode($model->typeproperty);
            $model->save();
            $staffLog =  new StaffLog();
            $staffLog->type = 1;
            $staffLog->user_id = $model->id;
            $staffLog->staff_id = Yii::$app->user->id;
            $staffLog->ip = Yii::$app->request->remoteIP;
            $staffLog->data = 'Редактирование пользователя';
            $staffLog->created_at = time();

            $staffLog->save();
//            var_dump($model, $staffLog, Yii::$app->user);die;




            Yii::$app->session->setFlash('success', 'Пользователь успешно сохранен');
            return $this->redirect(['update?id=' . $id]);

        }

        $model->district = json_decode($model->district);
        $model->typeproperty = json_decode($model->typeproperty);

        UserSmsController::actionCheckStatus($id);

        $searchModel = new UserSmsSearch(['user_id' => $id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];

        $searchModelNotes = new ClientNotesSearch(['client_id' => $id]);
        $dataProviderNotes = $searchModelNotes->search(Yii::$app->request->queryParams);

        $RelatedObjectSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
            'city' => $model->city_id,
            'region' => $model->region,

        ]);
        $RelatedObjectDataProvider = $RelatedObjectSearchModel->search(
            ['RealtyObjectSearch' =>
                [
                    'district2' => $model->district,
                    'prop_type' => $model->typeproperty,

                    'price_from' => $model->price_from, 'price_to' => $model->price_to

                ]]
        );
//        var_dump($RelatedObjectDataProvider);die;

        $searchModelPayment = new ClientPaymentSearch(['client_id' => $id]);
        $dataProviderPayment = $searchModelPayment->search(Yii::$app->request->queryParams);
        $dataProviderPayment->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];


        $searchModelLog = new UserLogfSearch(['login' => $model->user_id]);
        $dataProviderLog = $searchModelLog->search(Yii::$app->request->queryParams);
        $dataProviderLog->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];

        $searchModelStaffLog = new StaffLogSearch(['user_id' => $id]);
        $dataProviderStaffLog = $searchModelStaffLog->search(Yii::$app->request->queryParams);
        $dataProviderStaffLog->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];





        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'RelatedObjectSearchModel' => $RelatedObjectSearchModel,
            'RelatedObjectDataProvider' => $RelatedObjectDataProvider,
            'searchModelPayment' => $searchModelPayment,
            'dataProviderPayment' => $dataProviderPayment,
            'searchModelNotes' => $searchModelNotes,
            'dataProviderNotes' => $dataProviderNotes,
            'searchModelLog' => $searchModelLog,
            'dataProviderLog' => $dataProviderLog,
            'searchModelStaffLog' => $searchModelStaffLog,
            'dataProviderStaffLog' => $dataProviderStaffLog
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $client = $this->findModel($id);
        $user = User::find()->where(['id' => $client->user_id])->one();
        $payments = ClientPayment::find()->where(['client_id' => $id])->all();
        $sms = UserSms::find()->where(['user_id' => $id])->all();
        $notes = ClientNotes::find()->where(['client_id' => $id])->all();
        $user_log = UserLog::find()->where(['login' => $user->id])->all();
        $staff_log = StaffLog::find()->where(['user_id' => $id])->all();

        if (!empty($payments)) foreach ($payments as $pay) $pay->delete();
        if (!empty($notes)) foreach ($notes as $note) $note->delete();
        if (!empty($sms)) foreach ($sms as $s) $s->delete();
        if (!empty($user_log)) foreach ($user_log as $ul) $ul->delete();
        if (!empty($staff_log)) foreach ($staff_log as $sl) $sl->delete();
        if ($user->delete() && $client->delete())
            Yii::$app->session->setFlash('success', 'Пользователь успешно удален');
        else    Yii::$app->session->setFlash('error', 'Не удалось удалить пользователя');


        return $this->redirect(['index']);
    }

    public function actionChangeStatus($id, $status){
         if (Client::changeStatus($id, $status)) {
         Yii::$app->session->setFlash('success', 'Статус клиента успешно изменен');


             return $this->redirect('index');

         }
        else {
            Yii::$app->session->setFlash('error', 'Ошибка при изменении  статуса');
            return $this->redirect('index');

        }

    }


}
