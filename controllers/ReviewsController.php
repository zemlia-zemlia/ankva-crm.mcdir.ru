<?php

namespace app\controllers;

use Yii;
use app\models\Reviews;
use app\models\Category;
use app\models\client\Staff;


use app\models\ReviewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;

/**
 * ReviewsController implements the CRUD actions for Reviews model.
 */
class ReviewsController extends SiteController
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

        if (!Yii::$app->user->can('accessReviews')  || Yii::$app->user->isGuest)  {
            \Yii::$app->session->setFlash('error', 'Вам запрещен доступ к отзывам');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Reviews models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReviewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionList()
    {
     //   $id = '1';
        $id_category = Yii::$app->request->get('id_category');

        if($id_category != ''){

        $dataProvider = new ActiveDataProvider([
            'query' => Reviews::find()->where(['=', 'category', $id_category])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }else{
            $dataProvider = new ActiveDataProvider([
                'query' => Reviews::find()->orderBy('id DESC'),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }




        return $this->render('list', ['listDataProvider' => $dataProvider]);
    }




    /**
     * Displays a single Reviews model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = Reviews::findOne($id);







        if ($model === null) {
            throw new NotFoundHttpException;
        }

            if ($model->id_company == Yii::$app->user->identity->id_company) {
        return $this->render('view', [
            'model' => $model,
        ]);
    }else{

                Yii::$app->session->setFlash('error', 'Ошибка доступа');
                Yii::$app->response->redirect(array('reviews/index'))->send();
                Yii::$app->end();

            }
    }

    /**
     * Creates a new Reviews model.
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



    public function actionCreate()
    {
        $model = new Reviews();
/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
*/
        $model->date = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');
        $model->id_company = Yii::$app->user->identity->id_company;

       // $model->id_c = Yii::$app->user->identity->id_company;
        //счетчик уникального id компании
        //счетчик уникального id компании
        $id_c = Reviews::find()->orderBy(['id_c' => SORT_DESC])->where(['id_company' => [Yii::$app->user->identity->id_company]])->one();
        if($id_c){
            $model->id_c = $id_c->id_c +1;

        }else{
            $model->id_c = 1;
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

            return $this->render('create', [
                'model' => $model,

                'category' => Category::find()->all(),
                'manager_added' => Staff::find()->where(['!=', 'status', 0])
                    ->orderBy('id')->all()
            ]);



    }

    /**
     * Updates an existing Reviews model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if ($model->id_company == Yii::$app->user->identity->id_company) {


            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            Yii::$app->session->setFlash('error', 'Ошибка доступа');
            Yii::$app->response->redirect(array('reviews/index'))->send();
            Yii::$app->end();


        }
    }

    /**
     * Deletes an existing Reviews model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $id_c = Reviews::find()->where(['id' => [$id]])->one();

        if($id_c->id_company == Yii::$app->user->identity->id_company){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            return $this->redirect(['index']);
            Yii::$app->session->setFlash('error', 'Ошибка доступа');

        }

    }

    /**
     * Finds the Reviews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reviews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reviews::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
