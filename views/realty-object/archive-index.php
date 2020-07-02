<?php

use app\helpers\LocationHelper;
use app\helpers\ObjectHelper;
use app\models\RealtyObject;
use app\widgets\ActionColumn;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RealtyObjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Архив объектов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realty-object-index">

    <div class="section">
        <div class="container">
            <div class="row">

                <h1><?= Html::encode($this->title) ?></h1>

                <?= GridView::widget([
                    'summary' => '',
                    'dataProvider' => $dataProvider,
                    // 'filterModel' => $searchModel,
                    // 'filterModel' => false,
                    'columns' => [

                        [
                            'attribute'=> 'id',
                            'label'=> 'Id',
                            'headerOptions' => ['style' => 'width: 85px; padding: 5px 3px; text-align: center'],
                            'contentOptions' => ['style' => 'width: 85px; text-align: center'],
                        ],
                        [
                            'label' => 'Фото',
                            'headerOptions' => ['style' => 'width: 90px; padding: 5px 21px; text-align: center; color: #000;'],
                            'contentOptions' => ['style' => 'padding: 10px 3px; text-align: center'],
                            'format'=> 'raw',
                            'value' =>  function($data) {
                                $arrImages = explode(',', $data->images);
                                $countImages = count($arrImages);
                                $currentImage = trim( $arrImages[0] );


                                $str = $currentImage ? Html::button('<img src="' . $currentImage . '">', ['class' => 'rooms-img-btn', 'onclick' => 'galleryShow("' . $data->images . '")']) : '';
                                return $str;
                            }
                        ],
                        [
                            'attribute' => 'description',
                            'headerOptions' => ['style' => 'text-align: center'],
                            'format' => 'raw',
                            'value' => function($data) {
                                if ( strlen($data->description) > 400 ) {

                                    $tmpDescription = substr($data->description, 0, 400);
                                    $lastSpace = strripos($tmpDescription, ' ');
                                    $firstDescription = substr($data->description, 0, $lastSpace);
                                    $secondDescription = substr($data->description, $lastSpace);

                                    $str = "<div class='description-body'>" . $firstDescription . " <button class='btn-discription' data-do='open-description'><span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span> ещё</button><span class='hidden-description'>" . $secondDescription . "<button class='btn-discription' data-do='close-description'><span class='glyphicon glyphicon-triangle-top' aria-hidden='true'></span> скрыть</button></span></div>";

                                    return $str;

                                } else {

                                    return $data->description;
                                }
                            }
                        ],
                        [
                            'attribute' => 'type',
                            'headerOptions' => ['style' => 'text-align: center'],
                            'value' => function(RealtyObject $data) {
                                return ObjectHelper::typeName($data->type);
                            }
                        ],
                        [
                            'attribute' => 'created_at',
                            'headerOptions' => ['style' => 'text-align: center'],
                            'format' => ['datetime', 'php:d M Y H:i']
                        ],
                        [
                            'attribute' => 'price',
                            'headerOptions' => ['style' => 'text-align: center'],
                        ],
                        [
                            'attribute' => 'phone',
                            'headerOptions' => ['style' => 'text-align: center'],
                            'content'=>function(RealtyObject $data){
                                return "".$data->name." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>";
                            }
                        ],
                        [
                            'label' => 'Адрес',
                            'headerOptions' => ['style' => 'text-align: center'],
                            'value' => function(RealtyObject $data) {
                                return LocationHelper::regionName($data->region) . ', ' . LocationHelper::cityName($data->city);
                            }
                        ],

                        [
                            'class' => ActionColumn::className(),
                            'template' => '{view} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-eye"></span>', /*$customurl*/'#',
                                        [
                                            'class' => 'btn btn-action btn-primary view-popup',
                                            'title' => 'Просмотреть',
                                            'data-pjax' => '0',
                                            'value' => '/realty-object/view-modal?id=' . $model->id,
                                            'data-title' => 'Объект #' . $model->id,
                                        ]);
                                },
                                // 'update' => function ($url, $model) {
                                //     // $customurl = Yii::$app->getUrlManager()->createUrl(['realty-object/update-modal', 'id' => $model['id']]);
                                //     return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', /*$customurl*/'#',
                                //         [
                                //             'class' => 'realty-object-update-modal',
                                //             'title' => 'Редактирование',
                                //             'data-pjax' => '0',
                                //             'value' => '/realty-object/update-modal?id=' . $model->id,
                                //             'data-title' => $model->id . '# - редактирование',
                                //         ]);
                                // }
                            ],
                            // 'urlCreator' => function ($action, $model, $key, $index) {
                            //     if ($action === 'view') {
                            //         return Url::to(['/realty-object/view-modal', 'id' => $model->id]);
                            //     }
                            //     return Url::to([$action, 'id' => $model->id]);
                            // }
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>


</div>

<?php Modal::begin([
    'options' => [
        'id' => 'gallery-wrapper',
    ]
]);

Modal::end(); ?>

<?php Modal::begin([
    'id' => 'view-popup',
    'size' => 'modal-lg',
]);

echo "<div id='full-view'></div>";

Modal::end(); ?>

<?php $this->registerJsFile('/js/jquery.bxslider.min.js', ['depends' => 'yii\web\YiiAsset']); ?>

