<?php

namespace app\controllers;
use app\controllers\SiteController;

use Yii;
use app\models\Company;
use app\models\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
 /**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends SiteController
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
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

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function createDirectory($path) {
        //$filename = "/folder/{$dirname}/";
        if (file_exists($path)) {
            //echo "The directory {$path} exists";
        } else {
            mkdir($path, 0775, true);
            //echo "The directory {$path} was successfully created.";
        }
    }


    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->identity->id_company);

        $current_image = $model->image; // Watermark
        $image_logo = $model->logo; // Logo

        if ($model->load(Yii::$app->request->post())) {


            if($model->city_id == NULL)
            {
                $model->city_id = '0';

            }

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

            if($model->del_img2 == '1' AND $image_logo!='')
            {
                $model->logo = '';
                if(file_exists('../web' . $image_logo)) {

                    unlink('../web' . $image_logo);
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



                  $dir = Yii::getAlias('watermark/'.Yii::$app->user->identity->id_company.'/');
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


            $file2 = UploadedFile::getInstance($model, 'file2');
            if ($file2 && $file2->tempName) {
                $model->file2 = $file2;
                if ($model->validate(['file2'])) {



                    $dir = Yii::getAlias('logo/'.Yii::$app->user->identity->id_company.'/');
                    if (file_exists($dir)) {
                        //echo "The directory {$path} exists";
                    } else {
                        mkdir($dir, 0775, true);
                        //echo "The directory {$path} was successfully created.";
                    }
                    $name = md5(microtime() . rand(0, 1000));
                    $fileName = $name  . '.' . $model->file2->extension;
                    $model->file2->saveAs($dir . $fileName);
                    $model->file2 = $fileName; // без этого ошибка
                    $model->logo = ''.$dir . $fileName;

                    //$imagineObj = new Imagine();
                    //$imageObj = $imagineObj->open(\Yii::$app->basePath . $dir . $fileName);
                    //$imageObj->resize($imageObj->getSize()->widen(400))->save(\Yii::$app->basePath . $dir . $fileName);


                }
            }



            if ($model->save()) {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
/*
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->identity->id_company);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->watermark = UploadedFile::getInstance($model, 'watermark');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }

                return $this->redirect(['update', 'model' => $model,]);




        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
*/
    /**
     * Deletes an existing Company model.
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
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
