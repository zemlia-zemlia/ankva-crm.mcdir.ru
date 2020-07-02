<?php

namespace app\controllers;

use app\models\Contragent;
use Yii;
use app\forms\ObjectDeleteForm;
use app\helpers\ObjectHelper;
use app\models\ObjectLog;
use app\models\ObjectLogType;
use app\models\BlacklistObject;
use app\models\FavoriteObject;
use app\models\Black;
use app\models\Rooms;
use app\models\RoomsSearch;
use app\models\Task;
use app\forms\RealtyObjectForm;
use app\models\User;
use app\models\RealtyObject;
use app\models\RealtyObjectSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\controllers\SiteController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use ZipArchive;
use kartik\mpdf\Pdf;
use app\models\client\Staff;
/**
 * RealtyObjectController implements the CRUD actions for RealtyObject model.
 */
class RealtyObjectController extends SiteController
{

    public function beforeAction($action)
    {

        if (!Yii::$app->user->isGuest) \app\components\rbac\RulesAdditional::rule();
        if (!Yii::$app->user->can('accessRealObject')  || Yii::$app->user->isGuest)  {
            Yii::$app->session->setFlash('error', 'Вам запрещен доступ к базе');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }
        $this->enableCsrfValidation = false;
//        $this->getView()->registerJsFile("/js/main.js", yii\web\View::POS_READY, $key = null );
//        $this->getView()->registerJsFile("js/custom.js");


        return parent::beforeAction($action);
    }


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        /** @var User $user */
        $user = User::findOne(Yii::$app->user->id);
     //   $id_company = User::findOne(Yii::$app->user->id_company);

        $is_admin = ($user && $user->role == 'admin');


        $rentResidentalSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);
//        var_dump(Yii::$app->request->post());die;
        $rentResidentalDataProvider = $rentResidentalSearchModel->search(Yii::$app->request->post());

        $rentResidentalArchiveSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_ARCHIVE,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);
        $rentResidentalArchiveDataProvider = $rentResidentalArchiveSearchModel->search(Yii::$app->request->post());

        $rentCommercialSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);
        $rentCommercialDataProvider = $rentCommercialSearchModel->search(Yii::$app->request->post());

        $rentCommercialArchiveSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_ARCHIVE,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);
        $rentCommercialArchiveDataProvider = $rentCommercialArchiveSearchModel->search(Yii::$app->request->post());

        $sellResidentalSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);
        $sellResidentalDataProvider = $sellResidentalSearchModel->search(Yii::$app->request->post());

        $sellResidentalArchiveSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_ARCHIVE,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);
        $sellResidentalArchiveDataProvider = $sellResidentalArchiveSearchModel->search(Yii::$app->request->post());

        $sellCommercialSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);
        $sellCommercialDataProvider = $sellCommercialSearchModel->search(Yii::$app->request->post());

        $sellCommercialArchiveSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_ARCHIVE,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);
        $sellCommercialArchiveDataProvider = $sellCommercialArchiveSearchModel->search(Yii::$app->request->post());

        $deletedResidentalSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_DELETED,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);
        $deletedResidentalDataProvider = $deletedResidentalSearchModel->search(Yii::$app->request->post());

        $deletedCommercialSearchModel = new RealtyObjectSearch([
            'status' => RealtyObject::REALTY_OBJECT_BOARD_STATUS_DELETED,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);
        $deletedCommercialDataProvider = $deletedCommercialSearchModel->search(Yii::$app->request->post());

        $user_favorites = FavoriteObject::findOne(['user_id' => Yii::$app->user->id]);

        if ($user_favorites) {
            $favorites = explode(',', $user_favorites->ads);
        } else {
            $favorites = [];
        }

        $user_blacklist = BlacklistObject::find()->where(['user_id' => Yii::$app->user->id])->all();

        if ($user_blacklist) {
            $blacklists = ArrayHelper::getColumn($user_blacklist, 'phone');
        } else {
            $blacklists = [];
        }

        $users = Staff::find()->select(['id', 'firstname'])->asArray()->all();
        $managers = ArrayHelper::map($users, 'id', 'firstname');

        $object_delete_form = new ObjectDeleteForm();
        $object_delete_form->target = 'index';

        $rentResidentalSearchForm = $this->renderPartial('full-search-form', [
            'model' => $rentResidentalSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);

        $rentCommercialSearchForm = $this->renderPartial('full-search-form', [
            'model' => $rentCommercialSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);

        $rentResidentalArchiveSearchForm = $this->renderPartial('full-search-form', [
            'model' => $rentResidentalArchiveSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);

        $rentCommercialArchiveSearchForm = $this->renderPartial('full-search-form', [
            'model' => $rentCommercialArchiveSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_RENT,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);

        $sellResidentalSearchForm = $this->renderPartial('full-search-form', [
            'model' => $sellResidentalSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);

        $sellCommercialSearchForm = $this->renderPartial('full-search-form', [
            'model' => $sellCommercialSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);

        $sellResidentalArchiveSearchForm = $this->renderPartial('full-search-form', [
            'model' => $sellResidentalArchiveSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);

        $sellCommercialArchiveSearchForm = $this->renderPartial('full-search-form', [
            'model' => $sellCommercialArchiveSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);

        $deletedResidentalSearchForm = $this->renderPartial('full-search-form', [
            'model' => $deletedResidentalSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL,
        ]);
        $deletedCommercialSearchForm = $this->renderPartial('full-search-form', [
            'model' => $deletedCommercialSearchModel,
            'managers' => $managers,
            'type' => RealtyObject::REALTY_OBJECT_TYPE_SELL,
            'category' => RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL,
        ]);

        return $this->render('index', [

            'rentResidentalSearchModel' => $rentResidentalSearchModel,
            'rentResidentalDataProvider' => $rentResidentalDataProvider,
            'rentResidentalArchiveSearchModel' => $rentResidentalArchiveSearchModel,
            'rentResidentalArchiveDataProvider' => $rentResidentalArchiveDataProvider,
            'rentCommercialSearchModel' => $rentCommercialSearchModel,
            'rentCommercialDataProvider' => $rentCommercialDataProvider,
            'rentCommercialArchiveSearchModel' => $rentCommercialArchiveSearchModel,
            'rentCommercialArchiveDataProvider' => $rentCommercialArchiveDataProvider,

            'sellResidentalSearchModel' => $sellResidentalSearchModel,
            'sellResidentalDataProvider' => $sellResidentalDataProvider,
            'sellResidentalArchiveSearchModel' => $sellResidentalArchiveSearchModel,
            'sellResidentalArchiveDataProvider' => $sellResidentalArchiveDataProvider,
            'sellCommercialSearchModel' => $sellCommercialSearchModel,
            'sellCommercialDataProvider' => $sellCommercialDataProvider,
            'sellCommercialArchiveSearchModel' => $sellCommercialArchiveSearchModel,
            'sellCommercialArchiveDataProvider' => $sellCommercialArchiveDataProvider,

            'deletedResidentalSearchModel' => $deletedResidentalSearchModel,
            'deletedResidentalDataProvider' => $deletedResidentalDataProvider,
            'deletedCommercialSearchModel' => $deletedCommercialSearchModel,
            'deletedCommercialDataProvider' => $deletedCommercialDataProvider,

            'rentResidentalSearchForm' => $rentResidentalSearchForm,
            'rentCommercialSearchForm' => $rentCommercialSearchForm,
            'rentResidentalArchiveSearchForm' => $rentResidentalArchiveSearchForm,
            'rentCommercialArchiveSearchForm' => $rentCommercialArchiveSearchForm,
            'sellResidentalSearchForm' => $sellResidentalSearchForm,
            'sellCommercialSearchForm' => $sellCommercialSearchForm,
            'sellResidentalArchiveSearchForm' => $sellResidentalArchiveSearchForm,
            'sellCommercialArchiveSearchForm' => $sellCommercialArchiveSearchForm,
            'deletedResidentalSearchForm' => $deletedResidentalSearchForm,
            'deletedCommercialSearchForm' => $deletedCommercialSearchForm,

            'is_admin' => $is_admin,
            'favorites' => $favorites,
            'blacklists' => $blacklists,


            'objectDeleteForm' => $object_delete_form,

        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = 'object-detail';

        $object = $this->findModel($id);
        $form = new RealtyObjectForm($object);

        $users = Staff::find()->select(['id', 'firstname'])->asArray()->all();
        $managers = ArrayHelper::map($users, 'id', 'firstname');


        $dubleParserSearch = new RoomsSearch(['phone' => $object->phone]);
        $parserDataProvider = $dubleParserSearch->search(Yii::$app->request->queryParams);
        $parserDataProvider->sort = false;

        $dubleObjectSearch = new RealtyObjectSearch('`phone` = ' . $object->phone . ' AND `status` = ' . RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC . ' AND ob.id != ' . $object->id);
        $objectDataProvider = $dubleObjectSearch->search(Yii::$app->request->queryParams);
        $objectDataProvider->sort = false;

        $operation_logs = ObjectLog::find()->where([
            'log_object_id' => $object->id,
            'log_category' => ObjectLogType::LOG_CATEGORY_OPERATION,
        ])->orderBy(['created_at' => SORT_DESC])->all();

        $modification_logs = ObjectLog::find()->where([
            'log_object_id' => $object->id,
            'log_category' => ObjectLogType::LOG_CATEGORY_MODIFICATION,
        ])->orderBy(['created_at' => SORT_DESC])->all();

        $logs = $this->renderPartial('object-logs', [
            'model' => $object,
            'operation_logs' => $operation_logs,
            'modification_logs' => $modification_logs,
        ]);

        $object_delete_form = new ObjectDeleteForm();
        $object_delete_form->target = 'view';


        if (Yii::$app->request->isAjax) {  // редактирование объекта

            $query = Yii::$app->request->post();

            $form = new RealtyObjectForm();
            $form->load($query);

            if ($form->validate()) {

                $form->metro = ArrayHelper::getValue($query, 'metro');
                $form->old_images = ArrayHelper::getValue($query, 'old_images');

                $form->uploadImages();

                $data_updated = $object->edit($form);

                if ($data_updated) {

                    $object->save();

                    $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                        ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object->id, 'Редактирование объекта', null, null);
                    $objectLog->save();

                    Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');

                } else {

                    Yii::$app->session->setFlash('error', 'Изменений нет.');

                }


                if ($form->call_back == '1') {

                    if ($form->call_back_date) {

                        if (!$task = Task::findOne(['id_object' => $object->id])) {
                            $task = new Task();
                            $task->id_object = $object->id;
                        }

                        $task->id_user = $form->manager ? $form->manager : 0;
                        $task->date = strtotime($form->call_back_date);
                        $task->date_add = time();
                        $task->save();
                    }

                } else {

                    if ($task = Task::findOne(['id_object' => $object->id])) {
                        $task->delete();
                    }
                }

                // $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                //     ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object->id, 'Редактирование объекта', null, null);
                // $objectLog->save();
                //
                // Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');

                $result = array (
                    "status" => "success",
                    "object_id" => $object->id,
                );

                return(json_encode($result));
            }

            $result = array (
                "status" => "error",
            );

            return (json_encode($result));
        }

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('print' , [
                'model' => $form,
                'managers' => $managers,
                'logs' => $logs,
                'parserDataProvider' => $parserDataProvider,
                'objectDataProvider' => $objectDataProvider,
                'objectDeleteForm' => $object_delete_form,
            ]),
            'options' => [
                // any mpdf options you wish to set
            ],
            'cssFile' => '@webroot/css/kv-mpdf-bootstrap.min.css',



            'methods' => [
                'SetTitle' => 'Информация о объекте',
                'SetSubject' => 'Сгенирирован PDF файл',
                'SetHeader' => ['Документ сгенерирован: ' . Yii::$app->formatter->format(date("Y-m-d H:s"), 'date')],
                'SetFooter' => ['|Страница {PAGENO}|'],
                'SetAuthor' => 'RentCRM',
                'SetCreator' => 'RentCRM',
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);
        return $pdf->render();


    }



    public function actionView($id)
    {
        $this->layout = 'object-detail';

        $object = $this->findModel($id);
        $form = new RealtyObjectForm($object);

        $users = Staff::find()->select(['id', 'firstname', 'lastname'])->asArray()->all();
        $managers = ArrayHelper::map($users, 'id', 'fullName');




        $dubleParserSearch = new RoomsSearch(['phone' => $object->phone]);
        $parserDataProvider = $dubleParserSearch->search(Yii::$app->request->queryParams);
        $parserDataProvider->sort = false;

        $dubleObjectSearch = new RealtyObjectSearch('`phone` = ' . $object->phone . ' AND `status` = ' . RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC . ' AND ob.id != ' . $object->id);
        $objectDataProvider = $dubleObjectSearch->search(Yii::$app->request->queryParams);
        $objectDataProvider->sort = false;

        $operation_logs = ObjectLog::find()->where([
            'log_object_id' => $object->id,
            'log_category' => ObjectLogType::LOG_CATEGORY_OPERATION,
        ])->orderBy(['created_at' => SORT_DESC])->all();

        $modification_logs = ObjectLog::find()->where([
            'log_object_id' => $object->id,
            'log_category' => ObjectLogType::LOG_CATEGORY_MODIFICATION,
        ])->orderBy(['created_at' => SORT_DESC])->all();

        $logs = $this->renderPartial('object-logs', [
            'model' => $object,
            'operation_logs' => $operation_logs,
            'modification_logs' => $modification_logs,
        ]);

        $object_delete_form = new ObjectDeleteForm();
        $object_delete_form->target = 'view';


        if (Yii::$app->request->isAjax) {  // редактирование объекта

            $query = Yii::$app->request->post();

            $form = new RealtyObjectForm();
            $form->load($query);

            if ($form->validate()) {

                $form->metro = ArrayHelper::getValue($query, 'metro');
                $form->old_images = ArrayHelper::getValue($query, 'old_images');

                $form->uploadImages();

                $data_updated = $object->edit($form);

                if ($data_updated) {

                    $object->save();

                    $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                        ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object->id, 'Редактирование объекта', null, null);
                    $objectLog->save();

                    Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');

                } else {

                    Yii::$app->session->setFlash('error', 'Изменений нет.');

                }


                if ($form->call_back == '1') {

                    if ($form->call_back_date) {

                        if (!$task = Task::findOne(['id_object' => $object->id])) {
                            $task = new Task();
                            $task->id_object = $object->id;
                        }

                        $task->id_user = $form->manager ? $form->manager : 0;
                        $task->date = strtotime($form->call_back_date);
                        $task->date_add = time();
                        $task->save();
                    }

                } else {

                    if ($task = Task::findOne(['id_object' => $object->id])) {
                        $task->delete();
                    }
                }

                // $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                //     ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object->id, 'Редактирование объекта', null, null);
                // $objectLog->save();
                //
                // Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');

            $result = array (
                "status" => "success",
                "object_id" => $object->id,
            );

            return(json_encode($result));
            }

            $result = array (
                "status" => "error",
            );

            return (json_encode($result));
        }

        return $this->render('view', [
            'model' => $form,
            'managers' => $managers,
            'logs' => $logs,
            'parserDataProvider' => $parserDataProvider,
            'objectDataProvider' => $objectDataProvider,
            'objectDeleteForm' => $object_delete_form,
        ]);
    }


    public function actionViewModal($id)
    {
        return $this->renderAjax('view-modal', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate($copy_id = null)
    {
        if ($copy_id) {

            $parser_object = Rooms::findOne($copy_id);
            $form = new RealtyObjectForm($parser_object);

            $dubleParserSearch = new RoomsSearch('`phone` = ' . $parser_object->phone . ' AND `id` != ' . $copy_id);
            $parserDataProvider = $dubleParserSearch->search(Yii::$app->request->queryParams);
            $parserDataProvider->sort = false;

        } else {

            $form = new RealtyObjectForm();
            $parserDataProvider = null;

        }

        $users = User::find()->select(['id', 'username'])->asArray()->all();
        $managers = ArrayHelper::map($users, 'id', 'username');

        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();

            $form = new RealtyObjectForm();
            $form->load($query);

            if ($form->validate()) { // TODO fix this

                $form->metro = ArrayHelper::getValue($query, 'metro');
                $form->old_images = ArrayHelper::getValue($query, 'old_images');


                $object = RealtyObject::create($form);
                $object->save();

                $form->id = $object->id;
                $form->uploadImages();

                $object->updateAttributes(['images' => $form->images]);

                if ($form->copy_id) {

                    Yii::$app->db->createCommand()->insert('company_rooms', [
                        'parser_id' => $form->copy_id,
                        'object_id' => $object->id,
                    ])->execute();



                    $copy_phone = substr($form->phone, 4, 3) . substr($form->phone, 9, 3) . substr($form->phone, 13, 2) . substr($form->phone, 16, 2);

                    if (!Contragent::find()->where(['phone' => $copy_phone])->exists()) {

                        Yii::$app->db->createCommand()->insert('contragents', array_filter([
                            'name' => $form->name,
                            'phone' => $copy_phone,
                            'email' => $form->email,
                            'telegram' => $form->telegram,
                            'whatsapp' => $form->whatsapp ? substr($form->whatsapp, 4, 3) . substr($form->whatsapp, 9, 3) . substr($form->whatsapp, 13, 2) . substr($form->whatsapp, 16, 2) : '',
                            'viber' => $form->viber ? substr($form->viber, 4, 3) . substr($form->viber, 9, 3) . substr($form->viber, 13, 2) . substr($form->viber, 16, 2) : '',
                            'vk' => $form->vk,
                        ]))->execute();
                    }
                }

                // Таск для уведомлений
                if ($form->call_back == '1' && $form->call_back_date) {

                    $task = new Task();
                    $task->id_object = $object->id;
                    $task->id_user = $form->manager ? $form->manager : 0;
                    $task->date = strtotime($form->call_back_date);
                    $task->date_add = time();
                    $task->save();
                }

                $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_CREATE,
                    ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object->id, 'Добавление объекта', null, null);
                $objectLog->save();

                $result = array (
                    "status" => "success",
                    "object_id" => $object->id,
                );

                Yii::$app->session->setFlash('success', 'Объект успешно добавлен.');

                return(json_encode($result));
            }

            $result = array (
                "status" => "error",
            );

            return (json_encode($result));
        }

        return $this->render('create', [
            'model' => $form,
            'managers' => $managers,
            'parserDataProvider' => $parserDataProvider,
            'objectDataProvider' => null,
        ]);
    }


    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);
    //     $form = new RealtyObjectForm($model);
    //
    //     $users = User::find()->select(['id', 'username'])->asArray()->all();
    //     $managers = ArrayHelper::map($users, 'id', 'username');
    //
    //     $dubleParserSearch = new RoomsSearch(['phone' => $model->phone]);
    //     $parserDataProvider = $dubleParserSearch->search(Yii::$app->request->queryParams);
    //     $parserDataProvider->sort = false;
    //
    //     $dubleObjectSearch = new RealtyObjectSearch('`phone` = ' . $model->phone .
    //          ' AND `status` = ' . RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC . ' AND ob.id != ' . $model->id);
    //     $objectDataProvider = $dubleObjectSearch->search(Yii::$app->request->queryParams);
    //     $objectDataProvider->sort = false;
    //
    //     if (Yii::$app->request->isAjax) {
    //
    //         $query = Yii::$app->request->post();
    //
    //         $form = new RealtyObjectForm();
    //         $form->load($query);
    //
    //         if ($form->validate()) {
    //
    //             $form->metro = ArrayHelper::getValue($query, 'metro');
    //             $form->old_images = ArrayHelper::getValue($query, 'old_images');
    //
    //             $form->uploadImages();
    //
    //             $model->edit($form);
    //             $model->save();
    //
    //             if ($form->call_back == '1') {
    //
    //                 if ($form->call_back_date) {
    //
    //                     if (!$task = Task::findOne(['id_object' => $model->id])) {
    //                         $task = new Task();
    //                         $task->id_object = $model->id;
    //                     }
    //
    //                     $task->id_user = $form->manager ? $form->manager : 0;
    //                     $task->date = strtotime($form->call_back_date);
    //                     $task->date_add = time();
    //                     $task->save();
    //                 }
    //
    //             } else {
    //
    //                 if ($task = Task::findOne(['id_object' => $model->id])) {
    //                     $task->delete();
    //                 }
    //             }
    //
    //             $result = array (
    //                 "status" => "success",
    //             );
    //
    //             Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
    //
    //             return(json_encode($result));
    //         }
    //
    //         $result = array (
    //             "status" => "error",
    //         );
    //
    //         return (json_encode($result));
    //     }
    //
    //     return $this->render('update', [
    //         'model' => $form,
    //         'managers' => $managers,
    //         'parserDataProvider' => $parserDataProvider,
    //         'objectDataProvider' => $objectDataProvider,
    //     ]);
    // }

    public function actionDublicationSearch()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $phone = ArrayHelper::getValue($query, 'phone');
            $object_id = ArrayHelper::getValue($query, 'obj_id');
            $copy_id = ArrayHelper::getValue($query, 'copy_id');

            $search_phone = substr($phone, 4, 3) . substr($phone, 9, 3) . substr($phone, 13, 2) . substr($phone, 16, 2);

            $dubleParserSearch = new RoomsSearch('`phone` = ' . $search_phone . ($copy_id ? (' AND `id` != ' . $copy_id) : ''));
            $parserDataProvider = $dubleParserSearch->search(Yii::$app->request->queryParams);
            $parserDataProvider->sort = false;

            $dubleObjectSearch = new RealtyObjectSearch('`phone` = ' . $search_phone .
                ' AND `status` = ' . RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC . ($object_id ? (' AND `ob`.`id` != ' . $object_id) : ''));
            $objectDataProvider = $dubleObjectSearch->search(Yii::$app->request->queryParams);
            $objectDataProvider->sort = false;

            $search_result = $this->renderPartial('dublication-search', [
                'parserDataProvider' => $parserDataProvider,
                'objectDataProvider' => $objectDataProvider,
            ]);

            $result = array (
                "status" => "success",
                "dublication_block" => $search_result,
            );

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }

    // public function actionDelete($id)
    // {
    //     $object = $this->findModel($id);
    //     $path = 'images/objects/' . $object->id . '/';
    //     $images = array_filter(explode(',', $object->images));
    //
    //     foreach ($images as $image) {
    //
    //         $img_file = substr($image, 1);
    //
    //         try {
    //             if (file_exists($img_file)) {
    //                 unlink($img_file);
    //             }
    //         } catch (\Exception $e) {
    //             continue;
    //         }
    //     }
    //
    //     if (file_exists($path)) {
    //         rmdir($path);
    //     }
    //
    //     $company_room = CompanyRoom::findOne(['object_id' => $object->id]);
    //     if ($company_room) {
    //         $company_room->delete();
    //     }
    //
    //     $tasks = Task::find()->where(['id_object' => $object->id])->all();
    //     foreach ($tasks as $task) {
    //         $task->delete();
    //     }
    //
    //     $object->delete();
    //
    //     return $this->redirect(['index']);
    // }

    // public function actionDeleteObjects()
    // {
    //     if (Yii::$app->request->isAjax) {
    //
    //         $query = Yii::$app->request->post();
    //         $object_ids = $query['objects'];
    //
    //         $objects = RealtyObject::find()->where(['in', 'id', $object_ids])->all();
    //
    //         /** @var RealtyObject $object */
    //         foreach ($objects as $object) {
    //
    //             $object->setDelete();
    //             $object->save();
    //         }
    //
    //         $result = array (
    //             "status" => "success",
    //         );
    //
    //         Yii::$app->session->setFlash('success', 'Выбранные объекты удалены.');
    //
    //         return(json_encode($result));
    //     }
    //
    //     $result = array (
    //         "status" => "error",
    //     );
    //
    //     return (json_encode($result));
    // }


    public function actionArchiveObjects()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $object_ids = $query['objects'];

            $objects = RealtyObject::find()->where(['in', 'id', $object_ids])->all();

            /** @var RealtyObject $object */
            foreach ($objects as $object) {

                $object->setArchive();
                $object->save();
            }

            $result = array (
                "status" => "success",
            );

            // Yii::$app->session->setFlash('success', 'Выбранные объекты перемещены в архив.');

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }

    public function actionFavoriteObjects()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $object_ids = $query['objects'];

            if (!$favorite = FavoriteObject::findOne(['user_id' => Yii::$app->user->id])) {
                $favorite = new FavoriteObject();
                $favorite->user_id = Yii::$app->user->id;
            }

            $favorite_list = array_filter(explode(',', $favorite->ads));

            // $add_count = 0;

            foreach ($object_ids as $object_id) {

                if (!in_array($object_id, $favorite_list)) {
                    $favorite_list[] = $object_id;
                    // $add_count++;
                }
            }

            $favorite->ads = implode(',', $favorite_list);
            $favorite->save();

            $result = array (
                "status" => "success",
            );

            // if ($add_count > 0) {
            //     Yii::$app->session->setFlash('success', 'Выбранные объекты добавлены в избранное.');
            // } else {
            //     Yii::$app->session->setFlash('error', 'Выбранные объекты уже в избранном.');
            // }

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    public function actionRestoreObjects()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $object_ids = $query['objects'];

            $objects = RealtyObject::find()->where(['in', 'id', $object_ids])->all();

            /** @var RealtyObject $object */
            foreach ($objects as $object) {

                $object->setPublic();
                $object->save();
            }

            $result = array (
                "status" => "success",
            );

            // Yii::$app->session->setFlash('success', 'Выбранные объекты перемещены в актуальные.');

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    // обновление даты актуальности
    public function actionActual($id)
    {
        if (Yii::$app->request->isAjax) {

            $flash = ArrayHelper::getValue(Yii::$app->request->post(), 'flash');
            $object = RealtyObject::findOne($id);

            $object->refreshActualDate();
            $object->save();

            $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $id, 'Редактирование объекта', null, null);
            $objectLog->save();

            $actual_date = date('d M Y H:i', $object->actual_date);

            if ($flash) {
                Yii::$app->session->setFlash('success', 'Дата актуальности обновлена.');
            }

            $result = array (
                "status" => "success",
                "object_id" => $id,
                "actual_date" => $actual_date,
            );

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    // метка "недоступен"
    public function actionUnavailable($id)
    {
        if (Yii::$app->request->isAjax) {

            // $query = Yii::$app->request->post();
            // $id = $query['object_id'];

            $flash = ArrayHelper::getValue(Yii::$app->request->post(), 'flash');
            $object = RealtyObject::findOne($id);

            $object->setUnavailable();
            $object->save();

            $result = array (
                "status" => "success",
                "object_id" => $id,
            );

            if ($flash) {
                Yii::$app->session->setFlash('success', 'Метка установлена.');
            }

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    public function actionArchive($id)
    {
        if (Yii::$app->request->isAjax) {

            // $query = Yii::$app->request->post();
            $flash = ArrayHelper::getValue(Yii::$app->request->post(), 'flash');
            // $id = $query['object_id'];

            $object = RealtyObject::findOne($id);

            if ($object->isArchive()) {

                if ($flash) {
                    Yii::$app->session->setFlash('error', 'Объект уже в архиве.');
                }

            } else {

                $object->setArchive();
                $object->save();

                if ($flash) {
                    Yii::$app->session->setFlash('success', 'Объект перенесен в архив.');
                }

            }

            $result = array (
                "status" => "success",
                "object_id" => $id,
            );

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    public function actionRestore($id)
    {
        if (Yii::$app->request->isAjax) {

            // $query = Yii::$app->request->post();
            $flash = ArrayHelper::getValue(Yii::$app->request->post(), 'flash');
            // $id = $query['object_id'];

            $object = RealtyObject::findOne($id);

            if ($object->isPublic()) {

                if ($flash) {
                    Yii::$app->session->setFlash('error', 'Объект уже в актуальных.');
                }

            } else {

                $object->setPublic();
                $object->save();

                if ($flash) {
                    Yii::$app->session->setFlash('success', 'Объект перенесен в актуальные.');
                }

            }

            $result = array (
                "status" => "success",
                "object_id" => $id,
            );

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();

            $object_ids = array_filter(explode(',', ArrayHelper::getValue($query, 'object_id')));
            $reason = ArrayHelper::getValue($query, 'reason');
            $flash = ArrayHelper::getValue($query, 'flash') == 'true';

            if (count($object_ids) == 1) {  // удаляем один объект

                $object = RealtyObject::findOne($object_ids[0]);

                if ($object->isDeleted()) {

                    if ($flash) {
                        Yii::$app->session->setFlash('error', 'Объект уже удален.');
                    }

                } else {

                    $object->setDelete();
                    $object->del_reason = $reason;
                    $object->save();

                    $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                        ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object_ids[0], 'Редактирование объекта', null, null);
                    $objectLog->save();

                    if ($flash) {
                        Yii::$app->session->setFlash('success', 'Объект удален.');
                    }
                }

            } else {  // удаляем несколько выбранных объектов

                $objects = RealtyObject::find()->where(['in', 'id', $object_ids])->all();


                /** @var RealtyObject $object */
                foreach ($objects as $object) {

                    $object->setDelete();
                    $object->del_reason = $reason;
                    $object->save();

                    $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                        ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object->id, 'Редактирование объекта', null, null);
                    $objectLog->save();
                }

                if ($flash) {
                    Yii::$app->session->setFlash('success', 'Выбранные объекты удалены.');
                }

            }

            $result = array (
                "status" => "success",
                "object_id" => count($object_ids) == 1 ? $object_ids[0] : '',
            );

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    public function actionBlacklist($id, $action)
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $flash = ArrayHelper::getValue($query, 'flash');
            // $action = ArrayHelper::getValue($query, 'action');

            $object = RealtyObject::findOne($id);


            if ($action == 'add') {

                if ($object->inBlacklist()) {

                    if ($flash) {
                        Yii::$app->session->setFlash('error', 'Объект уже в черном списке.');
                    }

                } else {

                    if (!$black_list_object = BlacklistObject::find()->where(['user_id' => Yii::$app->user->id, 'phone' => $object->phone])->one()) {

                        $black_list_object = new BlacklistObject();
                        $black_list_object->user_id = Yii::$app->user->id;
                        $black_list_object->phone = $object->phone;
                        $black_list_object->date = time();

                        $black_list_object->save();
                    }

                    if ($flash) {
                        Yii::$app->session->setFlash('success', 'Объект добавлен в черный список.');
                    }

                }

            } else {

                $black_list_object = BlacklistObject::find()->where(['user_id' => Yii::$app->user->id, 'phone' => $object->phone])->one();

                if ($black_list_object) {
                    $black_list_object->delete();
                }

                if ($flash) {
                    Yii::$app->session->setFlash('success', 'Объект удален из черного списка.');
                }

            }

            $result = array (
                "status" => "success",
                "object_id" => $id,
            );

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    // избранное
    public function actionFavorite($id, $action)
    {
        if (Yii::$app->request->isAjax) {

            $flash = ArrayHelper::getValue(Yii::$app->request->post(), 'flash');
            // $action = ArrayHelper::getValue($query, 'action');

            if (!$favorite = FavoriteObject::findOne(['user_id' => Yii::$app->user->id])) {
                $favorite = new FavoriteObject();
                $favorite->user_id = Yii::$app->user->id;
            }

            $favorite_list = array_filter(explode(',', $favorite->ads));

            if ($action == 'add') {

                if (!in_array($id, $favorite_list)) {
                    $favorite_list[] = $id;
                }

            } else {

                if (in_array($id, $favorite_list)) {

                    $key = array_search($id, $favorite_list);
                    if ($key !== false ) {
                        unset($favorite_list[$key]);
                    }
                }

            }

            $favorite->ads = implode(',', $favorite_list);
            $favorite->save();

            if ($flash) {
                Yii::$app->session->setFlash('success', $action == 'add' ? 'Объект добавлен в избранное.' : 'Объект удален из избранного.');
            }

            $result = array (
                "status" => "success",
                "object_id" => $id,
            );



            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    // кнопка "Недоступен" при копировании объекта
    public function actionRoomObjectNocall()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $object_id = $query['object_id'];

            Yii::$app->db->createCommand()->update('rooms', [
                'nd' => '1',
            ], 'id = ' . $object_id)->execute();

            $result = array (
                "status" => "success",
            );

            Yii::$app->session->setFlash('success', 'Метка установлена.');

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    // кнопка "В черный список" при копировании объекта
    public function actionRoomObjectBlacklist()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $phone = $query['object_phone'];

            if (!Black::find()->where(['phone' => $phone])->exists()) {

                $black = new Black;

                $black->id_user = Yii::$app->user->id;
                $black->phone = $phone;

                $black->save();

                Yii::$app->session->setFlash('success', 'Объект занесен в черный список.');

            } else {

                Yii::$app->session->setFlash('error', 'Объект уже в черном списке.');

            }

            $result = array (
                "status" => "success",
            );

            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    public function actionCategorySelectorChange()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->get();

            $types = ObjectHelper::propertyTypeList($query['category']);

            $types_html = '';

            foreach ($types as $key => $value) {
                $types_html .= '<option value="' . $key . '">' . $value . '</option>';
            }

            $type_selectbox = [
                'types' => $types_html,
                'disabled' => (count($types) == 0) ? 1 : 0,
            ];

            return json_encode($type_selectbox);
        }

        return null;
    }


    public function actionCropImage()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $file_name = Yii::getAlias('@webroot') . $query['imageFileName'];
            $object_id = $query['object_id'];

            $file_to_upload = $_FILES['croppedImage']['tmp_name'];

            if (move_uploaded_file($file_to_upload, $file_name)) {

                $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_OPERATION,
                    ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object_id, 'Редактирование объекта', null, null);
                $objectLog->save();

                $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_MODIFICATION,
                    ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $object_id, 'Редактирование фотографий', null, null);
                $objectLog->save();

                Yii::$app->session->setFlash('success', 'Изменения сохранены.');

            } else {

                Yii::$app->session->setFlash('error', 'При редактировании изображения произошла ошибка, попробуйте позже.');

            }

            $result = array (
                "status" => "success",
            );



            return(json_encode($result));
        }

        $result = array (
            "status" => "error",
        );

        return (json_encode($result));
    }


    // public function actionSetImagesOrder()
    // {
    //     if (Yii::$app->request->isAjax) {
    //
    //         $query = Yii::$app->request->post();
    //         $order = $query['order'];
    //         $object_id = $query['object_id'];
    //
    //         $path = 'images/objects/' . $object_id . '/';
    //         $images_order = explode(',', $order);
    //
    //         foreach ($images_order as $key => $image) {
    //             $images_order[$key] = '/' . $path . $image;
    //         }
    //
    //         $images = implode(',', $images_order);
    //
    //         Yii::$app->db->createCommand()->update('objects', [
    //             'images' => $images,
    //         ], 'id = ' . $object_id)->execute();
    //
    //         $result = array (
    //             "status" => "success",
    //         );
    //
    //         Yii::$app->session->setFlash('success', 'Изменения сохранены.');
    //
    //         return(json_encode($result));
    //     }
    //
    //     $result = array (
    //         "status" => "error",
    //     );
    //
    //     return (json_encode($result));
    // }


    public function actionDownloadImages($id)
    {
        $path = 'images/objects/' . $id . '/';

        $strImages = RealtyObject::find()->select('images')->asArray()->where(['id' => $id])->column();

        $arrImages = array_filter(explode(',', $strImages[0]));
        $newArray = [];

        foreach($arrImages as $item) {
            $newArray[] = trim(basename($item));
        }

        if (!empty($newArray)) {

            $zip_name = time() . '.zip';
            $file_name = time();

            $zip = new ZipArchive();
            $zip->open('uploads/' . $zip_name, ZIPARCHIVE::CREATE);

            $i = 1;

            foreach ($newArray as $file) {

                // $file = file_get_contents($file);
                $zip->addFile($path . $file, $file_name . '-' . $i . '.jpg');
                $i++;
            }
            $zip->close();

            return Yii::$app->response->sendFile('uploads/' . $zip_name)->on(Response::EVENT_AFTER_SEND, function($event) {
                unlink($event->data);
            }, 'uploads/' . $zip_name);
        } else {

            Yii::$app->session->setFlash('error', 'Нет файлов для зашрузки.');

            return $this->redirect(['/realty-object/view', 'id' => $id]);
        }


    }

    protected function findModel($id)
    {
        if (($model = RealtyObject::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
