<?php

namespace app\controllers\client;

use Yii;
use app\models\client\Staff;
use app\models\client\StaffSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\client\AuthAssignment;
use app\models\client\UserLogfSearch;
use app\models\client\Office;
use app\controllers\SiteController;
use yii\web\UploadedFile;

/**
 * SfaffController implements the CRUD actions for Staff model.
 */
class StaffController extends SiteController
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
        if (!Yii::$app->user->isGuest)\app\components\rbac\RulesAdditional::rule();
        if ( Yii::$app->user->isGuest || !Yii::$app->user->can('accessStaff'))  {
            \Yii::$app->session->setFlash('error', 'Вам запрещен доступ к сотрудникам');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }
            $this->enableCsrfValidation = false;


        return parent::beforeAction($action);
    }
    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionCreate()
    {
        if (!Yii::$app->user->can('addStaff'))  {
            \Yii::$app->session->setFlash('error', 'Вам запрещено добавлять сотрудников');
            return $this->redirect('/client/staff');
        }
        $model = new Staff();


        if ( $model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();


            $user->setPassword($model->password);

            $user->generateAuthKey();

            $user->setUsername($model->username);//($model->mobile);
            $user->type = 1;
            $user->role = $model->role;



            if ($user->save()) {
                $userRole = Yii::$app->authManager->getRole($user->role);
                Yii::$app->authManager->assign($userRole, $user->id);

                $model->user_id = $user->id;
                if ($model->save()){
                $user->user_id = $model->id;
                $user->save();

                Yii::$app->session->setFlash('success', 'Пользователь успешно добавлен');

                return $this->redirect(['index']);

            }

            }

        }


        return $this->render('create', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {




        if (!Yii::$app->user->can('updateStaff'))  {
            \Yii::$app->session->setFlash('error', 'Вам запрещено редактировать сотрудников');
            return $this->redirect('/client/staff');
        }



        $model = Staff::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("The staff was not found.");
        }

        $user = User::findOne($model->user_id);
        if (!$user) {
            throw new NotFoundHttpException("The user was not found.");
        }


// Загрузка автара профиля
        $current_image = $model->image; // Watermark


        $file = UploadedFile::getInstance($model, 'file');
        if ($file && $file->tempName) {
            $model->file = $file;
            if ($model->validate(['file'])) {



                $dir = Yii::getAlias('images/avatars/'.Yii::$app->user->identity->id_company.'/'.$model->user_id.'/');
                if (file_exists($dir)) {
                    //echo "The directory {$path} exists";
                } else {
                    mkdir($dir, 0775, true);
                    //echo "The directory {$path} was successfully created.";
                }
                $name = md5(microtime() . rand(0, 1000));
                $fileName = $name  . '.' . $model->file->extension;
                $model->file->saveAs($dir . $fileName);
                $model->file = $fileName; // без этого ошибка
                $model->image = ''.$dir . $fileName;

      /*
                $imagineObj = new Imagine();
                $imageObj = $imagineObj->open(\Yii::$app->basePath . $dir . $fileName);
                $imageObj->resize($imageObj->getSize()->widen(400))->save(\Yii::$app->basePath . $dir . $fileName);
    */

            }
        }



        //Если отмечен чекбокс «удалить файл»
        if($model->del_img == '1'  AND $current_image!='')
        {
            $model->image = '';
            if(file_exists('../web' . $current_image)) {

                unlink('../web' . $current_image);
            }
            /*
            //удаляем файл
            if(file_exists(Yii::getAlias($current_image)))
            {
             unlink(Yii::getAlias('@webroot',$current_image));
            }
            */

        }

// Загрузка автара профиля


        $searchModelLog = new UserLogfSearch(['login' => $user->id]);
        $dataProviderLog = $searchModelLog->search(Yii::$app->request->queryParams);
        $dataProviderLog->sort->defaultOrder = [
            'id' => [
                'default' => SORT_DESC
            ]
        ];




        if ( $model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->save()) {
//                var_dump ($model);die;



                $user->setPassword($model->password);
                $user->generateAuthKey();

                $user->setUsername($model->username);//($model->mobile);

                $user->role = $model->role;
                $user->status = $model->status;
                $user->save();

                $currentRole = AuthAssignment::find()->where(['user_id' => $user->id])->one();



                if($currentRole) {
                    // var_dump($currentRole);die;
                    if ($currentRole->item_name != $user->role) {
                        $userRole = Yii::$app->authManager->getRole($currentRole->item_name);
                        Yii::$app->authManager->revoke($userRole, $user->id); // delete old role
                        $userRole = Yii::$app->authManager->getRole($user->role);
                        Yii::$app->authManager->assign($userRole, $user->id);

                    }
                }
                else {
                    $userRole = Yii::$app->authManager->getRole($user->role);
                    Yii::$app->authManager->assign($userRole, $user->id);

                    }
//
                Yii::$app->session->setFlash('success', 'Пользователь успешно изменен');
                return $this->render('update', [

                    'model' => $model,
                    'dataProviderLog' => $dataProviderLog,
                    'searchModelLog' => $searchModelLog
                ]);
            }


        }else{


            return $this->render('update', [

                'model' => $model,
                'dataProviderLog' => $dataProviderLog,
                'searchModelLog' => $searchModelLog
            ]);

        }






    }


    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionChangeStatus($id, $status){
        $staff = $this->findModel($id);
        $user = User::findOne($staff->user_id);
        $staff->status = $status;
//        var_dump($staff);
        $staff->save();
        $user->status = $status;
        $user->save();
        Yii::$app->session->setFlash('success', 'Пользователь успешно заблокирован');
        return $this->redirect(['index']);


    }

//    public function actionTest(){
//        $user = new User();
//        $user->setPassword('123456');
//        $user->generateAuthKey();
////        $user->setEmail('demo1@demo.ru');
//        $user->setUsername('qwerty');
//        $user->save();
//
//    }


    public function actionStat($period = 3600){

        $staff = Staff::find()->all();

        return $this->render('stat', [
            'staff' => $staff,
    'period' => $period
        ]);


    }

    public function actionStatOffice($period = 3600){

        $office = Office::find()->all();

        return $this->render('stat-office', [
            'office' => $office,
            'period' => $period
        ]);


    }



}
?>