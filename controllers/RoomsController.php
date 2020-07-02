<?php

namespace app\controllers;

use Yii;
use app\models\Rooms;
use app\models\Country;
use app\models\Region;
use app\models\City;
use app\models\RoomsSearch;
use app\models\Wishlist;
use app\models\Black;
use app\models\Notes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use ZipArchive;
use app\helpers\LocationHelper;
/**
 * RoomsController implements the CRUD actions for Rooms model.
 */
class RoomsController extends SiteController
{



    public function beforeAction($action)
    {

        \app\components\rbac\RulesAdditional::rule();
        if (!Yii::$app->user->can('accessRealObject')  || Yii::$app->user->isGuest)  {
            Yii::$app->session->setFlash('error', 'Вам запрещен доступ к базе');
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Rooms models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) return $this->redirect('/site/login');
        else {

            $searchModel = new RoomsSearch();
            $model = new Rooms;

            $countryModel = Country::find()->asArray()->all();
            $countryModel = ArrayHelper::map($countryModel, 'id', 'name');
            $districtModel = Region::find()->select(['id', 'name'])->asArray()->where(['country_id' => 1])->all();
            $districtModel = ArrayHelper::map($districtModel, 'id', 'name');


            $currentUser = Yii::$app->user->identity->username;
            $currentUserId = Yii::$app->user->identity->id;

            $wishListModel = Wishlist::find()->select('ads')->asArray()->where(['username' => $currentUser])->limit(1)->one();
            $notesModel = Notes::find()->select(['ads_id', 'note'])->asArray()->where(['user_id' => $currentUserId])->all();
            $arrNotes = ArrayHelper::map($notesModel, 'ads_id', 'note');
        }

        if (Yii::$app->request->get('Rooms')) {

            $dataProvider = $searchModel->filter(Yii::$app->request->get('Rooms'));

            if (Yii::$app->request->get('Rooms')['districtSearch']) {

                $cityModel = City::find()->select(['id', 'name'])->asArray()->where(['region_id' => Yii::$app->request->get('Rooms')['districtSearch']])->all();
                $cityModel = ArrayHelper::map($cityModel, 'id', 'name');
            }

//            if ( Yii::$app->request->get('Rooms')['citySearch'] ) {
//                $cityModel = City::find()->select(['id', 'name'])->asArray()->where( ['region_id' => Yii::$app->request->get('Rooms')['districtSearch'] ] )->all();
//                $cityModel = ArrayHelper::map($cityModel, 'id', 'name');
//            }

        } else {

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        }

        if(\Yii::$app->request->isAjax) {

            if ( Yii::$app->request->post('district') ) {

                $districtModel = City::find()->select(['id', 'name'])->asArray()->where(['region_id' => Yii::$app->request->post('district')])->all();

                $str;
                foreach ($districtModel as $item) {
                    $str .= $item['id'] . ":" . $item['name'] . ",";
                }
            }
            return $str;
        }

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'districtModel' => $districtModel,
            'cityModel' => @$cityModel,
            'wishListModel' => $wishListModel,
            'arrNotes' => $arrNotes,
        ]);
    }

    /**
     * Displays a single Rooms model.
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
     * Creates a new Rooms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rooms();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Rooms model.
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
     * Deletes an existing Rooms model.
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
     *   Страница вывода избранных объявлений
     */
    public function actionWishlist()
    {

        $currentUser = Yii::$app->user->identity->username;
        $notesModel = Notes::find()->select(['ads_id', 'note'])->asArray()->where(['user_id' => $currentUserId])->all();
        $arrNotes = ArrayHelper::map($notesModel, 'ads_id', 'note');

        if (\Yii::$app->request->isAjax) {

            $modelWish = new Wishlist;

            if (Yii::$app->request->post('user') && Yii::$app->request->post('key')) {

                $newAds = Yii::$app->request->post('key');
                $act = Yii::$app->request->post('act');

                if ($act === "add") {

                    $issetUser = Wishlist::findOne(['username' => $currentUser]);


                    if ($issetUser) {

                        if (!Wishlist::find()->where(['like', 'ads', $newAds])->exists()) {

                            $issetUser['ads'] = $issetUser['ads'] . ',' . $newAds;
                            $issetUser->save();

                        }

                        return 'success';

                    } else {

                        $modelWish->username = $currentUser;
                        $modelWish->ads = $newAds;

                        if ($modelWish->save()) {
                            return "success";
                        }

                        return "error";
                    }

                }

                if ($act === "del") {

                    $issetUser = Wishlist::findOne(['username' => $currentUser]);

                    $arr = explode(',', $issetUser['ads']);
                    $k = array_search($newAds, $arr);
                    unset($arr[$k]);

                    $issetUser['ads'] = implode(',', $arr);
                    $issetUser->save();

                    return 'success';

                }

                if ($act === "delete") {

                    $issetUser = Wishlist::findOne(['username' => $currentUser]);

                    $arr = explode(',', $issetUser['ads']);
                    $k = array_search($newAds, $arr);
                    unset($arr[$k]);

                    $issetUser['ads'] = implode(',', $arr);
                    $issetUser->save();

                    return 'delete';

                }

            }

            if (Yii::$app->request->post('user') && Yii::$app->request->post('add-list')) {

                $issetUser = Wishlist::findOne(['username' => $currentUser]);

                if ($issetUser) {

                    $arrWishlist = explode(',', Yii::$app->request->post('add-list'));
                    $newAds = [];
                    $j = 0;
                    foreach ($arrWishlist as $item) {
                        if (!Wishlist::find()->where(['like', 'ads', $item])->exists()) {
                            $newAds[$j] = $item;
                            $j++;
                        }
                    }

                    $newAdsStr = implode(',', $newAds);

                    $issetUser['ads'] = $issetUser['ads'] . ',' . $newAdsStr;

                    if ($issetUser->save()) {
                        return 'success';
                    }

                    return 'error';

                } else {

                    $modelWish->username = $currentUser;
                    $modelWish->ads = Yii::$app->request->post('add-list');

                    if ($modelWish->save()) {
                        return "success";
                    }

                    return "error";

                }

            }
        }

        $userWishlist = Wishlist::find()->select('ads')->asArray()->where(['username' => $currentUser])->limit(1)->one();

        $arrWishlist = explode(',', $userWishlist['ads']);

        $dataProvider = new ActiveDataProvider([
            'query' => Rooms::find()->where(['in', 'id', $arrWishlist]),
        ]);

        return $this->render('wishlist', [
            'dataProvider' => $dataProvider,
            'arrNotes' => $arrNotes,
        ]);

    }

    /**
     *   Работа с чёрным списком
     */
    public function actionBlacklist()
    {

        $currentUser = Yii::$app->user->identity->id;

        if (\Yii::$app->request->isAjax) {

            $modelBlacklist = new Black;

            if (Yii::$app->request->post('userId') && Yii::$app->request->post('phone')) {

                $modelBlacklist->id_user = $currentUser;
                $modelBlacklist->phone = Yii::$app->request->post('phone');

                if ($modelBlacklist->save()) {
                    return "blacklist";
                } else {
                    return "error";
                }

            }

            if (Yii::$app->request->post('add-list')) {


                $arrList = explode(',', Yii::$app->request->post('add-list'));
                $arrListInsert = [];

                foreach ($arrList as $item) {

                    $arrListInsert[] = [
                        'id_user' => $currentUser,
                        'phone' => $item
                    ];
                }

                $columnNameArray = ['id_user', 'phone'];

                Yii::$app->db->createCommand()->batchInsert('black', $columnNameArray, $arrListInsert)->execute();

                return "blacklist";
            }
        }

    }

    /**
     *   Работа
     */
    public function actionNotes()
    {

        $currentUser = Yii::$app->user->identity->id;

        if (\Yii::$app->request->isAjax) {

            $modelNotes = new Notes;

            if (!Notes::find()->where(['ads_id' => Yii::$app->request->post('ads_id'), 'user_id' => $currentUser])->exists()) {
                $modelNotes->user_id = $currentUser;
                $modelNotes->ads_id = Yii::$app->request->post('ads_id');
                $modelNotes->note = Yii::$app->request->post('note');

                if ($modelNotes->save()) {
                    return "success";
                } else {
                    return "error";
                }

            } else {
                $updateNotes = Notes::find()->where(['ads_id' => Yii::$app->request->post('ads_id'), 'user_id' => $currentUser])->limit(1)->one();

                if (Yii::$app->request->post('note') === '') {
                    $updateNotes->delete();
                } else {
                    $updateNotes->note = Yii::$app->request->post('note');
                    $updateNotes->at_create = date('Y-m-d H:i:s');

                    if ($updateNotes->save()) {
                        return "success";
                    } else {
                        return "error";
                    }
                }
            }
        }
    }

    public function actionDownloadImages($id)
    {

        $strImages = Rooms::find()->select('images')->asArray()->where(['id' => $id])->column();

        $arrImages = explode(',', $strImages[0]);
        $newArray = [];

        foreach ($arrImages as $item) {
            $newArray[] = trim($item);
        }

        $nameFile = time();

        $zip = new ZipArchive();
        $zip->open('uploads/' . $nameFile . '.zip', ZIPARCHIVE::CREATE);
        $i = 1;
        foreach ($newArray as $link) {
            $file = file_get_contents($link);
            $zip->addFromString($nameFile . '-' . $i . '.jpg', $file);
            $i++;
        }
        $zip->close();

        return Yii::$app->response->sendFile('uploads/' . $nameFile . '.zip')->on(\yii\web\Response::EVENT_AFTER_SEND, function ($event) {
            unlink($event->data);
        }, 'uploads/' . $nameFile . '.zip');


        /* $i = 1;
         $nameFile = time();
         foreach ($newArray as $link ) {
             $file = file_get_contents($link);
             return Yii::$app->response->sendContentAsFile($file, $nameFile . '-' . $i . '.jpg');
         }*/

    }


    /**
     * Содержимое всплывающего окна с полной информацией об объявлении
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewpopup($id)
    {
        return $this->renderAjax('viewpopup', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionHide()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->post();
            $parser_id = $query['object_id'];

            Yii::$app->db->createCommand()->insert('company_rooms', [
                'parser_id' => $parser_id,
                'object_id' => 1,
            ])->execute();

            $result = array(
                "status" => "success",
            );

            Yii::$app->session->setFlash('success', 'Объект удален.');

            return (json_encode($result));
        }

        $result = array(
            "status" => "error",
        );

        return (json_encode($result));
    }


    /**
     * Finds the Rooms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rooms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rooms::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionDistrictChange($id)
    {

        $str = '';
        $districtModel = LocationHelper::cityList($id);

        foreach ($districtModel as $key => $item) {
            $str .= $key . ":" . $item . ",";
        }


            return  $str;



    }
}
