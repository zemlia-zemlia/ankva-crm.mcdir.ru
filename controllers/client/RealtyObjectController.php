<?php

namespace app\controllers\client;


use Yii;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;

use app\models\client\RealtyObject;
use app\models\client\RealtyObjectSearch;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\client\UploadFile;
use app\controllers\SiteController;
/**
 * RealtyObjectController implements the CRUD actions for RealtyObject model.
 */
class RealtyObjectController extends SiteController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],

        ];
    }

    public function actionIndex()
    {
        $searchModel = new RealtyObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }




    public function actionCreate()
    {

        $model = new RealtyObject();
        $file = new UploadFile();

        if ($model->load(Yii::$app->request->post()) && $file->load(Yii::$app->request->post()) ) {

            $file->imageFile = UploadedFile::getInstances($file, 'imageFile');
            $model->images = $file->upload();
            $model->staff = Yii::$app->user->id;
            $model->status = 1;





            $model->save();
            Yii::$app->session->setFlash('success', 'Объект успешно добавлен');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'file' => $file

        ]);


    }

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $file = new UploadFile();

        if ($model->load(Yii::$app->request->post()) &&  $file->load(Yii::$app->request->post())) {

            $file->imageFile = UploadedFile::getInstances($file, 'imageFile');
            $images = $file->upload();
//            var_dump($images);die;

            $model->images = ( $images != "[]") ?  $images : $model->images;
            if($model->removeFoto) $model->images = '';
            $model->save();


            Yii::$app->session->setFlash('success', 'Объект успешно сохранен');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'file' => $file
        ]);


    }

    public function actionXml()
    {


        $models = RealtyObject::find()->where(['status' => 1])->all();

        return $this->renderPartial('xml', [
            'models' => $models

        ]);
    }


    public function actionXmlAvito()
    {

        $id = Yii::$app->request->get('id');

        //$id = 'abKlso92';
        $models = RealtyObject::find()->where(['status' => 1])->all();

        return $this->renderPartial('xml-avito', [
            'models' => $models,
            'company' => $id

        ]);
    }

    public function actionXmlYandex()
    {

        $id = Yii::$app->request->get('id');

        //$id = 'abKlso92';
        $models = RealtyObject::find()->where(['status' => $id])->all();

        return $this->renderPartial('xml-yandex', [
            'models' => $models,
            'company' => $id

        ]);
    }


 public function actionExportSelect(){

     $check=Yii::$app->request->post('selection');

     var_dump($check);die;




 }






    public function actionUpload()
    {
        $model = new UploadFile();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return '{}';
            }
        }

        return $this->render('upload', ['model' => $model]);
    }





    public function actionDeleteBatch($ids)
    {
        $ids = json_decode($ids);
        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $model->delete();
        }
        Yii::$app->session->setFlash('success', 'Объекты успешно удалены');

        return $this->actionIndex();
    }






    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Объект успешно удален');

        return $this->actionIndex();
    }



    protected function findModel($id)
    {
        if (($model = RealtyObject::findOne($id)) !== null) {
         return $model;
        }

        Yii::$app->session->setFlash('warning', 'Объекты не найдены');
        return $this->actionIndex();
    }

    public function actionChangeStatus($ids, $act)
    {
//        RealtyObject::updateAll(['status' => 0], 'status = 1');
        $ids = json_decode($ids);
        foreach ($ids as $id) {
            $model = $this->findModel($id);
//            var_dump($model);die;
            if($act) $model->status = 1 ;
            else $model->status = 0 ;
            $model->save();


        }
        Yii::$app->session->setFlash('success', 'Объекты изменены');

        return $this->actionIndex();
    }

        public function actionChangeStatusAll(){

            RealtyObject::updateAll(['status' => 1]);
            Yii::$app->session->setFlash('success', 'Объекты добавленны в выгрузку');

            return $this->actionIndex();

        }










}
