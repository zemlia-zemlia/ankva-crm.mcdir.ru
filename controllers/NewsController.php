<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\NewsCategory;
use app\models\client\Staff;


use app\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends SiteController
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

        if (!Yii::$app->user->can('accessNews')  || Yii::$app->user->isGuest)  {
            \Yii::$app->session->setFlash('error', 'Вам запрещен доступ к информации');
            Yii::$app->response->redirect(array('/site/index'))->send();
            Yii::$app->end();
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
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
            'query' => News::find()->where(['=', 'category', $id_category])->andFilterWhere(['=', 'id_company', Yii::$app->user->identity->id_company])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }else{
            $dataProvider = new ActiveDataProvider([
                'query' => News::find()->orderBy('id DESC')->where(['=', 'id_company', Yii::$app->user->identity->id_company]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }




        return $this->render('list', ['listDataProvider' => $dataProvider]);
    }




    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = News::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

            if ($model->id_company == Yii::$app->user->identity->id_company) {

                return $this->render('view', [
                    'model' => $model,
                ]);
            }else{

                Yii::$app->session->setFlash('error', 'Ошибка доступа');
                Yii::$app->response->redirect(array('articles/list'))->send();
                Yii::$app->end();
            }
    }

    /**
     * Creates a new News model.
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
        $model = new News();
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
        //счетчик уникального id компании
        $id_c = News::find()->orderBy(['id_c' => SORT_DESC])->where(['id_company' => [Yii::$app->user->identity->id_company]])->one();
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

                'category' => NewsCategory::find()->all()

                    ->orderBy('id')->all()
            ]);



    }

    /**
     * Updates an existing News model.
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
        }else {
            Yii::$app->session->setFlash('error', 'Ошибка доступа');
            Yii::$app->response->redirect(array('articles/list'))->send();
            Yii::$app->end();
        }

    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $id_c = News::find()->where(['id' => [$id]])->one();

        if ($id_c->id_company == Yii::$app->user->identity->id_company) {


        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }else{
            return $this->redirect(['list']);
            Yii::$app->session->setFlash('error', 'Ошибка доступа');
        }
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
