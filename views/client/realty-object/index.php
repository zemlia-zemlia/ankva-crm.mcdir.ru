<?php


use app\models\client\RealtyObject;
use app\widgets\ActionColumn;
use kartik\dynagrid\DynaGrid;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;

use yii\helpers\Html;
use yii\helpers\Url;




$this->title = 'База объектов для экспорта';
$this->params['breadcrumbs'][] = $this->title;


?>

<?php

$columns = [
    [
        'class' => CheckboxColumn::class,
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],
    [
        'attribute'=> 'id',
        'label'=> 'ID',
        'width' => '42px',
        'headerOptions' => ['style' => 'text-align: center'],
        'contentOptions' => ['style' => 'text-align: center'],
        'value' => function (RealtyObject $data) {
            return '#' . $data->id;
        },
        'order' => DynaGrid::ORDER_FIX_LEFT,
    ],
    [
        'label' => 'Фото',
        'width' => '90px',
        'headerOptions' => ['style' => 'text-align: center; color: #000;'],
        'contentOptions' => ['style' => 'padding: 10px 3px; text-align: center'],
        'format'=> 'raw',
        'value' =>  function(RealtyObject $data) {
            $arrImages = json_decode($data->images);
            ($arrImages != []) ? $currentImage = trim( $arrImages[0] ): $currentImage = '';

            $str =
            '<div class="skip-export">' .
                ($currentImage ? Html::button('<img src="' . $currentImage . '">', ['class' => 'rooms-img-btn', 'onclick' => 'galleryShow("' . $data->images . '")']) : '') .
            '</div>' .
            '<div class="skip-export-xls skip-export-txt skip-export-csv" style="display: none">' .
                ($currentImage ? Html::img(Url::toRoute($currentImage, true), ['width' => '120px']) : '') .
            '</div>' .
            '<div class="skip-export-html skip-export-pdf skip-export-txt skip-export-csv" style="display: none">' .
                ($currentImage ? Html::a(Url::toRoute($currentImage, true), Url::toRoute($currentImage, true)) : '') .
            '</div>' .
            '<div class="skip-export-html skip-export-pdf skip-export-xls" style="display: none">' .
                ($currentImage ? Url::toRoute($currentImage, true) : '') .
            '</div>';

            return $str;
        }
    ],
    [
        'attribute' => 'created_at',
        'label' => 'Дата',
        'width' => '94px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => ['datetime', 'php:d M Y'],
        //'value' =>  //function (RealtyObject $data) {return  $data->actual_date;},//function (RealtyObject $data) {


       //     return '<div id="actual_date_' . $data->id . '">' . date('d M Y H:i', $data->actual_date) . '</div>';
       // },
    ],
    [
        'attribute' => 'districtName',
    ],



    [
        'attribute' => 'address',
        'headerOptions' => ['style' => 'min-width: 100px; text-align: center'],
        'value' => function(RealtyObject $data) {
            return $data->getAddress() .
                '<br><div id="unavailable_' . $data->id . '" style="margin-top: 10px">' .

                '</div>';
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'staffname',
        'label' => 'Ответственный пользователь',
        'value' => function($data){
    return $data->staffname ? $data->staffname : '----';
        }
    ],


    [
        'class' => ActionColumn::class,
        'order' => DynaGrid::ORDER_FIX_RIGHT,
        'header'=>'Действия',
        'template' => Yii::$app->user->isGuest ? '{update}' :
            '{update}{delete}',
        'headerOptions' => ['class' => 'skip-export', 'width' => '100px', 'style' => 'text-align:  center; color: #000;'],
        'contentOptions' => ['class' => 'skip-export'],
        'buttons' => [











        ],

    ],
];









?>

<div class="client-realty-object-index">
    <p>
    <?= Html::a('Добавить объект', ['create'], ['class' => 'btn btn-success']) ?>
       </p>





                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'objects',
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'rowOptions' =>  function ($model, $key, $index, $grid) {
                                            return ($model->status) ? ['class' => 'bg-success']: ['class' => ''];
                                        },



                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',

                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Аренда - жилые</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                    '<span>Выбранные: &nbsp;</span>' .
                                                    Html::button('Удалить', [
                                                        'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                        'id' => 'deleteObjects',
                                                    ]) . ' ' .
                                                    Html::button( 'Добавить в выгрузку', [
                                                        'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                        'id' => 'updateObjects',
                                                    ]) . ' ' .
                                                    (!Yii::$app->user->isGuest ? Html::button( 'Удалить из выгрузки', [
                                                        'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                        'id' => 'updateAll',
                                                    ]) : '') .
                                                '</div>',
                                        ],

                                        'export' => [
                                            'target' => GridView::TARGET_SELF,
                                            // 'skipExportElements' => ['button'],
                                            'showConfirmAlert' => false,
                                            'label' => 'Экспорт',

                                        ],
                                        'exportConfig' => [
                                            GridView::HTML => [],
                                            GridView::CSV => [],
                                            GridView::TEXT => [],
                                            GridView::EXCEL => [],
                                            GridView::PDF => [],
                                        ],
                                        'exportConversions' => [
                                            [
                                                'from' => 'display: none',
                                                'to' => 'display: block',
                                            ],
                                            [
                                                'from_pdf' => 'width="120px"',
                                                'to' => 'width="65px"',
                                            ],
                                        ],

                                    ],
                                    'columns' => $columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>


<p>Адрес файла:  <a target="_blank" href="http://ankva-crm.mcdir.ru/client/realty-object/xml">http://ankva-crm.mcdir.ru/client/realty-object/xml</a></p>

    </div>







