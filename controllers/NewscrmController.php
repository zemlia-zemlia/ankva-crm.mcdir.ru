<?php

namespace app\controllers;

use app\models\Tag;
use Yii;
use app\models\Newscrm;



use app\models\client\Staff;


use app\models\NewscrmSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;

/**
 * NewscrmController implements the CRUD actions for Newscrm model.
 */
class NewscrmController extends SiteController
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

        if (!Yii::$app->user->isGuest) \app\components\rbac\RulesAdditional::rule();

        $this->enableCsrfValidation = false;

        if (!Yii::$app->user->can('accessArticles')  || Yii::$app->user->isGuest)  {
            \Yii::$app->session->setFlash('error', 'Вам запрещен доступ к информации');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Newscrm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewscrmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionList()
    {
     //   $id = '1';
        $id_tag = Yii::$app->request->get('id_tag');

        if($id_tag != ''){

        $dataProvider = new ActiveDataProvider([
            'query' => Newscrm::find()->where(['=', 'id_tag', $id_tag])->andWhere([ '=', 'activ', 1])->orderBy('id_post DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }else{
            $dataProvider = new ActiveDataProvider([
                'query' => Newscrm::find()->where(['=', 'activ', 1])->orderBy('id_post DESC'),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }




        return $this->render('list', ['listDataProvider' => $dataProvider]);
    }




    /**
     * Displays a single Newscrm model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_post)
    {

        $model = Newscrm::findOne($id_post);
        if ($model === null) {
            throw new NotFoundHttpException;
        }


        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Newscrm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actions(){
        return[
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => 'http://localhost:8888/images/', // Directory URL address, where files are stored.
                'path' => '@webroot/images', // Or absolute path to directory where files are stored.
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']], // These options are by default.
            ],
        ];
}

    public function createDirectory($path) {
        //$filename = "/folder/{$dirname}/";
        if (file_exists($path)) {
            //echo "The directory {$path} exists";
        } else {
            mkdir($path, 0775, true);
            //echo "The directory {$path} was successfully created.";
        }
    }

    public function actionCreate()
    {
        $model = new Newscrm();

        $current_image = $model->image; // Watermark



/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
*/




        $model->date = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');
     //   $model->id_company = Yii::$app->user->identity->id_company;

        if ($model->load(Yii::$app->request->post())) {
            //Если отмечен чекбокс «удалить файл»


            $file = UploadedFile::getInstance($model, 'file');
            if ($file && $file->tempName) {
                $model->file = $file;
                if ($model->validate(['file'])) {



                    $dir = Yii::getAlias('news_crm/');
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

                    //$imagineObj = new Imagine();
                    //$imageObj = $imagineObj->open(\Yii::$app->basePath . $dir . $fileName);
                    //$imageObj->resize($imageObj->getSize()->widen(400))->save(\Yii::$app->basePath . $dir . $fileName);


                }
            }


            $model->id_user = '1';



            if ($model->save()) {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

            return $this->render('create', [
                'model' => $model,

                'id_tag' => Tag::find()->all()
            ]);



    }

    /**
     * Updates an existing Newscrm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_post)
    {
        $model = $this->findModel($id_post);

        $current_image = $model->image; // Изображение новости



        if ($model->load(Yii::$app->request->post())) {

        //Если отмечен чекбокс «удалить файл»
        if($model->del_img == '1' AND $current_image!='')
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
        $file = UploadedFile::getInstance($model, 'file');
        if ($file && $file->tempName) {
            $model->file = $file;
            if ($model->validate(['file'])) {



                $dir = Yii::getAlias('news_crm/');
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

                //$imagineObj = new Imagine();
                //$imageObj = $imagineObj->open(\Yii::$app->basePath . $dir . $fileName);
                //$imageObj->resize($imageObj->getSize()->widen(400))->save(\Yii::$app->basePath . $dir . $fileName);


            }
        }
            if ($model->save()) {

                return $this->redirect(['view', 'id_post' => $model->id_post]);



            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Newscrm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_post)
    {
        $this->findModel($id_post)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Newscrm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Newscrm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_post)
    {
        if (($model = Newscrm::findOne($id_post)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
