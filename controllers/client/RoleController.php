<?php

namespace app\controllers\client;

use app\components\rbac\Ip;
use app\components\rbac\twoDevice;
use app\models\AuthItemChild;
use app\models\client\AccessByTime;
use app\models\client\AccessByIp;
use app\models\User;
use app\models\client\Staff;
use Yii;
use app\models\Role;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\client\Permit;
use app\controllers\SiteController;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends SiteController
{

    public function beforeAction($action)
    {
        if (!Yii::$app->user->can('admin')) {
            \Yii::$app->session->setFlash('error', 'Вам запрещен доступ к этому разделу');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();

        }

        $this->enableCsrfValidation = false;


        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $auth = Yii::$app->authManager;
//        $rule = new twoDevice();
//        $auth->add($rule);
//        $accessByIp = $auth->createPermission('twoDevice');
//        $accessByIp->description = 'Доступ с двух и более устройств';
//        $accessByIp->ruleName = $rule->name;
//
//        $auth->add($accessByIp);
//        $admin = $auth->getRole('admin');
//        $manager = $auth->getRole('manager');
//        $client = $auth->getRole('Client');
//        $accessByIp = $auth->getPermission('accessMoreDevaces');

//        $auth->remove($accessByIp);
//
//        $auth->addChild($admin,$accessByIp);
//        $auth->addChild($manager,$accessByIp);
//        $auth->addChild($client,$accessByIp);

//var_dump(Yii::$app->user->can('twoDevice'));die;


        $dataProvider = new ActiveDataProvider([
            'query' => Role::find()->where(['type' => 1]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();

        if ($model->load(Yii::$app->request->post())) {
            $role = Yii::$app->authManager->createRole($model->name);
            $role->description = $model->description;
            Yii::$app->authManager->add($role);
            $role = Yii::$app->authManager->getRole($model->name);
            $perm = Yii::$app->authManager->getPermission('accessByTime');
            Yii::$app->authManager->addChild($role, $perm);
            $perm = Yii::$app->authManager->getPermission('accessByIp');
            Yii::$app->authManager->addChild($role, $perm);
            $perm = Yii::$app->authManager->getPermission('twoDevice');
            Yii::$app->authManager->addChild($role, $perm);

            $time = new AccessByTime();
            $time->role = $model->name;
            $time->save();
            $ip = new AccessByIp();
            $ip->role = $model->name;
            $ip->save();


            \Yii::$app->session->setFlash('success', 'Роль успешно добавлена');


            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);//ROLE
        $permit = Role::find()->where(['type' => 2])->all();   // Permission

        if (Yii::$app->request->post()) {

            foreach (Yii::$app->request->post() as $key => $permit) {

                if ($key != 'accessFrom' && $key != 'accessTo' && $key != 'accessRemoteIp') {
                    $isExists = Permit::find()->where(['parent' => $model->name])
                        ->andWhere(['child' => $key])->exists();
                    if ($isExists) {
                        if ($permit == 0) {
                            $role = Yii::$app->authManager->getRole($model->name);
                            $perm = Yii::$app->authManager->getPermission($key);
                            Yii::$app->authManager->removeChild($role, $perm);

                        }
                    } else {
                        if ($permit == 1) {
                            $role = Yii::$app->authManager->getRole($model->name);
                            $perm = Yii::$app->authManager->getPermission($key);
                            Yii::$app->authManager->addChild($role, $perm);

                        }
                    }

                } else { // for rule : accessByTime, accessByIp
                    switch ($key) {
                        case 'accessFrom':

                            $time = AccessByTime::find()->where(['role' => $model->name])->one();
                            if ($time) {
                                $time->time_from = $permit;
//                                    var_dump($time);die;
                                $time->save();
                            }


                            break;

                        case 'accessTo':


                            $time = AccessByTime::find()->where(['role' => $model->name])->one();
                            if ($time) {
                                $time->time_to = $permit;
                                $time->save();
                            } else {
                                $time = new AccessByTime();
                                $time->time_to = $permit;
                                $time->save();
                            }


                            break;
                        case 'accessRemoteIp':

                            $ips = AccessByIp::find()->where(['role' => $model->name])->one();
//                            var_dump($ips);die;
                        if(!$ips) break;
                            $ips->ips = $permit;
                            $ips->save();

                            break;
                    }


                }


            }


            Yii::$app->session->setFlash('success', 'Разрешения успешно изменены');


            return $this->redirect(['index', 'id' => $model->name]);
        }

        $time = AccessByTime::find()->where(['role' => $model->name])->one();
        $ips = AccessByIp::find()->where(['role' => $model->name])->one();

        if ($time) $model->accessFrom = $time->time_from ;
        if ($time) $model->accessTo = $time->time_to;
        if ($ips) $model->accessRemoteIp = $ips->ips;

        return $this->render('update', [
            'model' => $model,
            'permit' => $permit
        ]);
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);


        AccessByTime::findOne(['role' => $id])->delete();
        $role = Yii::$app->authManager->getRole($model->name);
        $perm = Yii::$app->authManager->getPermission('accessByTime');
        Yii::$app->authManager->removeChild($role, $perm);
        Yii::$app->authManager->remove($role);

        AccessByIp::findOne(['role' => $id])->delete();
        $role = Yii::$app->authManager->getRole($model->name);
        $perm = Yii::$app->authManager->getPermission('accessByIp');
        Yii::$app->authManager->removeChild($role, $perm);
        Yii::$app->authManager->remove($role);

        $role = Yii::$app->authManager->getRole($model->name);
        $perm = Yii::$app->authManager->getPermission('twoDevice');
        Yii::$app->authManager->removeChild($role, $perm);
        Yii::$app->authManager->remove($role);

        $users = User::find()->where(['role' => $id]);
        $staffs = Staff::find()->where(['role' => $id]);
        foreach ($users as $user) {
            $user->role = 'manager';
            $user->save();
        }
        foreach ($staffs as $staff) {
            $staff->role = 'manager';
            $staff->save();
        }


        Yii::$app->session->setFlash('success', 'Роль успешно удалена');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
