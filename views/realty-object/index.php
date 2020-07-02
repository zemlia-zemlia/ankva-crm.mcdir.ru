<?php

use app\assets\MultiSelectAsset;
use app\assets\Select2Asset;
use app\helpers\ObjectHelper;
use app\models\RealtyObject;
use app\widgets\ActionColumn;
use kartik\dynagrid\DynaGrid;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $rentResidentalSearchModel app\models\RealtyObjectSearch */
/* @var $rentResidentalDataProvider yii\data\ActiveDataProvider */
/* @var $rentResidentalArchiveSearchModel app\models\RealtyObjectSearch */
/* @var $rentResidentalArchiveDataProvider yii\data\ActiveDataProvider */
/* @var $rentCommercialSearchModel app\models\RealtyObjectSearch */
/* @var $rentCommercialDataProvider yii\data\ActiveDataProvider */
/* @var $rentCommercialArchiveSearchModel app\models\RealtyObjectSearch */
/* @var $rentCommercialArchiveDataProvider yii\data\ActiveDataProvider */
/* @var $sellResidentalSearchModel app\models\RealtyObjectSearch */
/* @var $sellResidentalDataProvider yii\data\ActiveDataProvider */
/* @var $sellResidentalArchiveSearchModel app\models\RealtyObjectSearch */
/* @var $sellResidentalArchiveDataProvider yii\data\ActiveDataProvider */
/* @var $sellCommercialSearchModel app\models\RealtyObjectSearch */
/* @var $sellCommercialDataProvider yii\data\ActiveDataProvider */
/* @var $sellCommercialArchiveSearchModel app\models\RealtyObjectSearch */
/* @var $sellCommercialArchiveDataProvider yii\data\ActiveDataProvider */
/* @var $deletedResidentalSearchModel app\models\RealtyObjectSearch */
/* @var $deletedResidentalDataProvider yii\data\ActiveDataProvider */
/* @var $deletedCommercialSearchModel app\models\RealtyObjectSearch */
/* @var $deletedCommercialDataProvider yii\data\ActiveDataProvider */
/* @var $rentResidentalSearchForm string */
/* @var $rentCommercialSearchForm string */
/* @var $rentResidentalArchiveSearchForm string */
/* @var $rentCommercialArchiveSearchForm string */
/* @var $sellResidentalSearchForm string */
/* @var $sellCommercialSearchForm string */
/* @var $sellResidentalArchiveSearchForm string */
/* @var $sellCommercialArchiveSearchForm string */
/* @var $deletedResidentalSearchForm string */
/* @var $deletedCommercialSearchForm string */
/* @var $is_admin boolean */
/* @var $favorites string[] */
/* @var $blacklists string[] */
/* @var $objectDeleteForm \app\forms\ObjectDeleteForm|null */

$this->title = 'Объекты недвижимости';
$this->params['breadcrumbs'][] = $this->title;

// SuggestionAsset::register($this);
MultiSelectAsset::register($this);
Select2Asset::register($this);
?>


<style>
    .favorite-btn:hover {
        text-decoration: none;    }
</style>

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
            return '' . $data->id_c;
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
            $arrImages = explode(',', $data->images);
            $currentImage = trim( $arrImages[0] );

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
        'attribute' => 'actual_date',
        'label' => 'Дата',
        'width' => '54px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => ['datetime', 'php:d M Y H:i'],
        //'value' =>  //function (RealtyObject $data) {return  $data->actual_date;},//function (RealtyObject $data) {


       //     return '<div id="actual_date_' . $data->id . '">' . date('d M Y H:i', $data->actual_date) . '</div>';
       // },
    ],
    [
        'attribute' => 'districtName',
    ],
    // [
    //     'attribute' => 'district_id',
    //     'filter' => LocationHelper::districtList(),
    //     'value' => function(RealtyObject $data) {
    //         return LocationHelper::districtName($data->district_id);
    //     }
    // ],
    /*
    [
        'attribute' => 'type',
        'label' => 'Тип',
        'filter' => ObjectHelper::typeList(),
        'headerOptions' => ['style' => 'text-align: center'],
        'value' => function(RealtyObject $data) {
            return '<div id="type_' . $data->id . '" data-type="' . ($data->type == RealtyObject::REALTY_OBJECT_TYPE_RENT ? 'rent' : 'sell') . '">' .
                ObjectHelper::typeName($data->type) . '</div>';
        },
        'format' => 'raw',
    ],
    */
    [
        'attribute' => 'phone',
        'label' => 'Тел.',
        'headerOptions' => ['style' => 'text-align: center'],
        'value' => function(RealtyObject $data) use ($is_admin) {
            return $data->name . ($is_admin ? ('<br><a href="tel:+7' . $data->phone . '">+7' . $data->phone . '</a>') :
                    ('<div id="user_phone_btn_' . $data->id . '">' . Html::button('Показать номер', [
                        'class' => 'badge skip-export',
                        'style' => 'margin-left: 0; margin-top: 10px',
                        'onclick' => 'showPhone("' . $data->id . '")',
                    ]))) . '</div>' .
                    '<div id="user_phone_' . $data->id . '" style="display: none"><a href="tel:+7' . $data->phone . '">+7' . $data->phone . '</a></div>';
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'address',
        'headerOptions' => ['style' => 'min-width: 100px; text-align: center'],
        'value' => function(RealtyObject $data) {
            return $data->getAddress() .
                '<br><div id="unavailable_' . $data->id . '" style="margin-top: 10px">' .
                    ($data->isUnavailable() ? '<div class="badge" style="margin-left: 0">НД</div>' : '') .
                '</div>';
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'description',
        'headerOptions' => ['style' => 'min-width: 250px; text-align: center'],
        'format' => 'raw',
        'value' => function(RealtyObject $data) {

            if ( strlen($data->description) > 400 ) {

                $tmpDescription = substr($data->description, 0, 400);
                $lastSpace = strripos($tmpDescription, ' ');
                $shortDescription = substr($data->description, 0, $lastSpace);

                $str = ($data->title ? ("<div class='skip-export' style='font-weight: bold; margin-bottom: 5px'>" .
                    Html::a($data->title, Url::to(['/realty-object/view', 'id' => $data->id]), ['data-pjax' => 0]) . "</div>" .
                        "<div style='font-weight: bold; margin-bottom: 5px; display: none'>" .
                            Html::a($data->title, Url::toRoute(['/realty-object/view', 'id' => $data->id], true), ['target' => '_blank']) . "</div>") : '')  .

                    "<div class='description-body'>" .
                        "<div id='short_description_" . $data->id . "' class='skip-export'>" . $shortDescription . " " .
                            "<button class='description-btn' data-do='open-description' data-id='" . $data->id . "'>" .
                                "<span class='caret' aria-hidden='true'></span> полностью" .
                            "</button>" .
                        "</div>" .
                        "<div class='hidden-description' id='full_description_" . $data->id . "'>" . $data->description .
                            "<button class='description-btn skip-export' data-do='close-description' data-id='" . $data->id . "'>" .
                                "<span class='caret-up' aria-hidden='true'></span> скрыть" .
                            "</button>" .
                        "</div>" .
                    "</div>";
                return $str;

            } else {

                $str = ($data->title ? ("<div class='skip-export' style='font-weight: bold; margin-bottom: 5px'>" .
                    Html::a($data->title, Url::to(['/realty-object/view', 'id' => $data->id]), ['data-pjax' => 0]) . "</div>" .
                        "<div style='font-weight: bold; margin-bottom: 5px; display: none'>" .
                            Html::a($data->title, Url::toRoute(['/realty-object/view', 'id' => $data->id], true), ['target' => '_blank']) . "</div>") : '')  .

                    $data->description;

                return $str;
            }
        },
    ],
    [
        'attribute' => 'price',
        'label' => 'Цена',
        'value' => function (RealtyObject $data) {
            return number_format($data->price, 0, '.', ' ');
        },
        // 'headerOptions' => ['style' => 'text-align: center'],
    ],
    /*
    [
        'attribute' => 'floors',
        'label' => 'Этажн.',
    ],
    [
        'attribute' => 'furniture',
        'filter' => ObjectHelper::furnitureList(),
        'value' => function(RealtyObject $data) {
            return ObjectHelper::furnitureName($data->furniture);
        },
    ],
    [
        'attribute' => 'repair',
        'filter' => ObjectHelper::repairTypeList(),
        'value' => function(RealtyObject $data) {
            return ObjectHelper::repairName($data->repair);
        },
    ],
    */
    [
        'attribute' => 'total_area',
        'label' => 'Пл.',
    ],
    [
        'class' => ActionColumn::class,
        'order' => DynaGrid::ORDER_FIX_RIGHT,
        'header'=>'Действия',
        'template' => Yii::$app->user->isGuest ? '{actual} {update} {unavailable} {archive} {delete} {mapview}' :
            '{actual} {favorites} {update} {unavailable} {archive} {delete} {blacklist} {mapview} {pdf}',
        'headerOptions' => ['class' => 'skip-export', 'style' => 'text-align: center; color: #000; width: 20.2% !important;'],
        'contentOptions' => ['class' => 'skip-export'],
        'buttons' => [

            // 'view' => function ($url, $model, $key) {
            //     return Html::a('<span class="fa fa-eye"></span>' . ' Просмотр', Url::to(['/realty-object/view', 'id' => $model->id]),
            //         [
            //             'class' => 'btn btn-warning btn-block btn-sm-listing favorite-btn',
            //             'title' => 'Просмотр',
            //             'data-pjax' => 0,
            //             // 'value' => '/realty-object/view-modal?id=' . $key,
            //             // 'data-title' => $model->title ? $model->title : ('Объект #' . $key),
            //         ]);
            // },


            'actual' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-default btn-sm-listing favorite-btn"><i class="fa fa-refresh"></i></span>',
                    'javascript:objectActual("' . $key . '")', [
                        'title' => 'Обновить актуальность', 'data-toggle' => 'tooltip',
                    ]);
            },


            'update' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-default  btn-sm-listing favorite-btn"><i class="fa fa-edit"></i> </span>',
                    ['/realty-object/view', 'id' => $key], [
                        'title' => 'Редактировать', 'data-toggle' => 'tooltip',
                        'data-pjax' => 0,
                    ]);
            },


            'unavailable' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-default btn-sm-listing favorite-btn"><!--<i class="fa fa-user-times"></i>--> НД</span>',
                    'javascript:objectUnavailable("' . $key . '")', [
                        'title' => 'Недоступен', 'data-toggle' => 'tooltip',
                    ]);
            },


            'archive' => function ($url, $model, $key) {
                if ($model->isArchive()) {
                    return Html::a('<span class="btn btn-warning btn-sm-listing favorite-btn"><i class="fa fa-times"></i></span>',
                        'javascript:objectRestore("' . $key . '")', [
                            'class' => 'restore-btn',
                            'title' => 'В актуальные', 'data-toggle' => 'tooltip',
                        ]);
                } else {
                    return Html::a('<span class="btn btn-warning  btn-sm-listing favorite-btn"><i class="fa fa-times"></i></span>',
                        'javascript:objectArchive("' . $key . '")', [
                            'class' => 'archive-btn',
                            'title' => 'В архив', 'data-toggle' => 'tooltip',
                        ]);
                }
            },


            // 'restore' => function ($url, $model, $key) {
            //     return Html::a('<span class="btn btn-warning btn-block btn-sm-listing favorite-btn"><!--<i class="fa fa-times"></i>--> В актуальные</span>',
            //         'javascript:objectRestore("' . $key . '")', [
            //             'title' => 'В актуальные',
            //         ]);
            // },


            'delete' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-danger  btn-sm-listing favorite-btn"><i class="fa fa-trash"></i></span>',
                    'javascript:objectDelete("' . $key . '")', [
                        'title' => 'Удалить', 'data-toggle' => 'tooltip',
                    ]);
            },


            'blacklist' => function ($url, $model, $key) use ($blacklists) {

                $is_blacklist = in_array($model->phone, $blacklists);

                if ($is_blacklist) {
                    return Html::a('<span class="btn btn-danger  btn-sm-listing favorite-btn"><i class="fa fa-minus-circle"></i></span>',
                        'javascript:objectBlacklist("' . $key . '", "delete")', [
                            'class' => 'blacklist-btn',
                            'title' => 'Удалить из черного списка', 'data-toggle' => 'tooltip',
                        ]);
                } else {
                    return Html::a('<span class="btn btn-danger  btn-sm-listing favorite-btn"><i class="fa fa-minus-circle"></i></span>',
                        'javascript:objectBlacklist("' . $key . '", "add")', [
                            'class' => 'blacklist-btn',
                            'title' => 'В черный список', 'data-toggle' => 'tooltip',
                        ]);
                }


            },


            'favorites' => function ($url, $model, $key) use ($favorites) {

                $is_favorite = in_array($key, $favorites);

                if ($is_favorite) {
                    return Html::a('<span class="btn btn-success  btn-sm-listing favorite-btn"><i class="glyphicon glyphicon-heart"></i> </span>',
                        'javascript:objectFavorite("' . $key . '", "delete")', [
                            'class' => 'favorite-btn',
                            'title' => 'Удалить из избранного', 'data-toggle' => 'tooltip',
                        ]);
                } else {
                    return Html::a('<span class="btn btn-default  btn-sm-listing favorite-btn"><i class="glyphicon glyphicon-heart"></i> </span>',
                        'javascript:objectFavorite("' . $key . '", "add")', [
                            'class' => 'favorite-btn',
                            'title' => 'Добавить в избранное', 'data-toggle' => 'tooltip',
                        ]);
                }
            },


            'mapview' => function ($url, $model, $key) {
                return Html::a(/*'<span class="fa fa-eye"></span>' .*/ ' На карте', '#',
                    [
                        'class' => 'btn btn-default btn-sm-listing favorite-btn view-popup',
                        'title' => 'Просмотр на карте', 'data-toggle' => 'tooltip',
                        'data-pjax' => 0,
                        'value' => '/realty-object/view-modal?id=' . $key,
                        'data-title' => $model->title ? $model->title : ('Объект #' . $key),
                        'onclick' => 'return false;'
                    ]);
            },

            'pdf' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-default  btn-sm-listing favorite-btn"><i class="fa fa-file-pdf-o"></i> </span>',
                    ['/realty-object/print', 'id' => $key], [
                        'title' => 'PDF презентация', 'data-toggle' => 'tooltip',
                        'data-pjax' => 0,
                        'target' => '_blank',

                    ]);
            },

        ],

    ],
];



$residental_item = [
    [
        'attribute' => 'property_type',
        'label' => 'Тип',
        'filter' => ObjectHelper::propertyTypeList(RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL),
        'value' => function (RealtyObject $data) {
            return ObjectHelper::propertyTypeName($data->category, $data->property_type);
        },
    ]
];

$commercial_item = [
    [
        'attribute' => 'property_type',
        'label' => 'Тип',
        'filter' => ObjectHelper::propertyTypeList(RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL),
        'value' => function (RealtyObject $data) {
            return ObjectHelper::propertyTypeName($data->category, $data->property_type);
        },
    ]
];



$residental_columns = $columns;
array_splice($residental_columns, 6, 0, $residental_item);
$commercial_columns = $columns;
array_splice($commercial_columns, 6, 0, $commercial_item);

$residental_deleted_columns = $residental_columns;
unset($residental_deleted_columns[0]);
unset($residental_deleted_columns[15]);
$commercial_deleted_columns = $commercial_columns;
unset($commercial_deleted_columns[0]);
unset($commercial_deleted_columns[15]);
?>

<div class="realty-object-index">
    <p>
        <?= Html::a('Добавить новый объект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="section" style="padding: 15px 15px; padding-top: 0px;">
        <div class="wrap-container">

            <div class="row">




                <ul id="objects_tab" class="nav nav-tabs">

                    <?php if($this->context->residential_rent=='1' OR  $this->context->commercial_rent=='1'){?>

                    <li class="active"><?= Html::a('Аренда', '#rent_info_tab', [
                            'id' => 'rent_info_tab_link',
                            'data-toggle' => 'tab',
                        ]) ?></li>
                    <?php } ?>

                    <?php if($this->context->residential_sale=='1' OR  $this->context->commercial_sale=='1'){?>
                    <li><?= Html::a('Продажа', '#sell_info_tab', [
                            'id' => 'sell_info_tab_link',
                            'data-toggle' => 'tab',
                        ]) ?></li>

                    <?php } ?>
                    <li><?= Html::a('Удаленные', '#deleted_info_tab', [
                            'id' => 'deleted_info_tab_link',
                            'data-toggle' => 'tab',
                        ]) ?></li>
                </ul>


                <div class="tab-content">

                    <div class="tab-pane fade in active" id="rent_info_tab">

                        <ul id="rent_objects_tab" class="nav nav-tabs">
                            <li class="active">
                                <?php if($this->context->residential_rent=='1'){?>

                                <?= Html::a('Жилые', '#rent_residental_info_tab', [
                                    'id' => 'rent_residental_info_tab_link',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php } ?>
                            <?php if($this->context->commercial_rent=='1'){?>
                            <li>
                                <?= Html::a('Коммерческие', '#rent_commercial_info_tab', [
                                    'id' => 'rent_commercial_info_tab_link',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php } ?>
                            <?php if($this->context->residential_rent=='1'){?>
                            <li>
                                <?= Html::a('Жилые архив', '#rent_residental_archive_info_tab', [
                                    'id' => 'rent_residental_archive_info_tab_link',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php } ?>
                            <?php if($this->context->commercial_rent=='1'){?>
                            <li>
                                <?= Html::a('Коммерческие архив', '#rent_commercial_archive_info_tab', [
                                    'id' => 'rent_commercial_archive_info_tab_link',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php } ?>
                        </ul>


                        <div class="tab-content">

                            <div class="tab-pane fade in active" id="rent_residental_info_tab">


                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#rent_residental_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $rentResidentalSearchModel->index,
                                    'options' => ['data-idx' => $rentResidentalSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="rent_residental_objects_search">
                                    <?= $rentResidentalSearchForm ?>
                                </div>


                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'rent_residental_objects_grid',
                                        'dataProvider' => $rentResidentalDataProvider,
                                        'filterModel' => $rentResidentalSearchModel,

                                        'rowOptions' => function ($model, $key, $index, $grid) use ($favorites) {
                                            $class = in_array($key, $favorites) ? 'favorites-row' : '';
                                            return ['key' => $key, 'index' => $index, 'class' => $class];
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
                                                        'onclick' => 'deleteObjects("rent_residental_objects_grid")',
                                                    ]) . ' ' .
                                                    Html::button( 'В архив', [
                                                        'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                        'onclick' => 'archiveObjects("rent_residental_objects_grid")',
                                                    ]) .
                                                    (!Yii::$app->user->isGuest ? Html::button( 'В избранное', [
                                                        'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                        'onclick' => 'favoriteObjects("rent_residental_objects_grid")',
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
                                    'columns' => $residental_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'rent_residental_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                            <div class="tab-pane fade" id="rent_commercial_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#rent_commercial_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $rentCommercialSearchModel->index,
                                    'options' => ['data-idx' => $rentCommercialSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="rent_commercial_objects_search">
                                    <?= $rentCommercialSearchForm ?>
                                </div>



                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'rent_commercial_objects_grid',
                                        'dataProvider' => $rentCommercialDataProvider,
                                        'filterModel' => $rentCommercialSearchModel,

                                        'rowOptions' => function ($model, $key, $index, $grid) use ($favorites) {
                                            $class = in_array($key, $favorites) ? 'favorites-row' : '';
                                            return ['key' => $key, 'index' => $index, 'class' => $class];
                                        },

                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',

                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Аренда - коммерческие</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                '<span>Выбранные: &nbsp;</span>' .
                                                Html::button('Удалить', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'deleteObjects("rent_commercial_objects_grid")',
                                                ]) . ' ' .
                                                Html::button( 'В архив', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'archiveObjects("rent_commercial_objects_grid")',
                                                ]) .
                                                (!Yii::$app->user->isGuest ? Html::button( 'В избранное', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'favoriteObjects("rent_commercial_objects_grid")',
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
                                    'columns' => $commercial_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'rent_commercial_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                            <div class="tab-pane fade" id="rent_residental_archive_info_tab">


                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#rent_residental_archive_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $rentResidentalArchiveSearchModel->index,
                                    'options' => ['data-idx' => $rentResidentalArchiveSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="rent_residental_archive_objects_search">
                                    <?= $rentResidentalArchiveSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'rent_residental_archive_objects_grid',
                                        'dataProvider' => $rentResidentalArchiveDataProvider,
                                        'filterModel' => $rentResidentalArchiveSearchModel,

                                        'rowOptions' => function ($model, $key, $index, $grid) use ($favorites) {
                                            $class = in_array($key, $favorites) ? 'favorites-row' : '';
                                            return ['key' => $key, 'index' => $index, 'class' => $class];
                                        },

                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',

                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Аренда - жилые (архив)</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                '<span>Выбранные: &nbsp;</span>' .
                                                Html::button('В актуальные', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'restoreObjects("rent_residental_archive_objects_grid")',
                                                ]) .
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
                                    'columns' => $residental_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'rent_residental_archive_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                            <div class="tab-pane fade" id="rent_commercial_archive_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#rent_commercial_archive_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $rentCommercialArchiveSearchModel->index,
                                    'options' => ['data-idx' => $rentCommercialArchiveSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>


                                <div class="collapse full-search-form-container" id="rent_commercial_archive_objects_search">
                                    <?= $rentCommercialArchiveSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'rent_commercial_archive_objects_grid',
                                        'dataProvider' => $rentCommercialArchiveDataProvider,
                                        'filterModel' => $rentCommercialArchiveSearchModel,
                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',
                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Аренда - коммерческие (архив)</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                '<span>Выбранные: &nbsp;</span>' .
                                                Html::button('В актуальные', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'restoreObjects("rent_commercial_archive_objects_grid")',
                                                ]) .
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
                                    'columns' => $commercial_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'rent_commercial_archive_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                        </div>


                    </div>

                    <div class="tab-pane fade" id="sell_info_tab">

                        <ul id="sell_objects_tab" class="nav nav-tabs">
                            <?php if($this->context->residential_sale=='1'){?>

                            <li class="active">
                                <?= Html::a('Жилые', '#sell_residental_info_tab', [
                                    'id' => 'sell_residental_info_tab_link',
                                    // 'class' => 'btn btn-light-gray',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php }?>

                            <?php if($this->context->commercial_rent=='1'){?>

                            <li>
                                <?= Html::a('Коммерческие', '#sell_commercial_info_tab', [
                                    'id' => 'sell_commercial_info_tab_link',
                                    // 'class' => 'btn btn-light-gray',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php }?>
                            <?php if($this->context->residential_sale=='1'){?>

                            <li>
                                <?= Html::a('Жилые архив', '#sell_residental_archive_info_tab', [
                                    'id' => 'sell_residental_archive_info_tab_link',
                                    // 'class' => 'btn btn-light-gray',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php }?>

                            <?php if($this->context->commercial_rent=='1'){?>

                            <li>
                                <?= Html::a('Коммерческие архив', '#sell_commercial_archive_info_tab', [
                                    'id' => 'sell_commercial_archive_info_tab_link',
                                    // 'class' => 'btn btn-light-gray',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php }?>
                        </ul>


                        <div class="tab-content">

                            <div class="tab-pane fade in active" id="sell_residental_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#sell_residental_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $sellResidentalSearchModel->index,
                                    'options' => ['data-idx' => $sellResidentalSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="sell_residental_objects_search">
                                    <?= $sellResidentalSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'sell_residental_objects_grid',
                                        'dataProvider' => $sellResidentalDataProvider,
                                        'filterModel' => $sellResidentalSearchModel,

                                        'rowOptions' => function ($model, $key, $index, $grid) use ($favorites) {
                                            $class = in_array($key, $favorites) ? 'favorites-row' : '';
                                            return ['key' => $key, 'index' => $index, 'class' => $class];
                                        },

                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',

                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Продажа - жилые</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                '<span>Выбранные: &nbsp;</span>' .
                                                Html::button('Удалить', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'deleteObjects("sell_residental_objects_grid")',
                                                ]) . ' ' .
                                                Html::button( 'В архив', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'archiveObjects("sell_residental_objects_grid")',
                                                ]) .
                                                (!Yii::$app->user->isGuest ? Html::button( 'В избранное', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'favoriteObjects("sell_residental_objects_grid")',
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
                                    'columns' => $residental_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'sell_residental_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                            <div class="tab-pane fade" id="sell_commercial_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#sell_commercial_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $sellCommercialSearchModel->index,
                                    'options' => ['data-idx' => $sellCommercialSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="sell_commercial_objects_search">
                                    <?= $sellCommercialSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'sell_commercial_objects_grid',
                                        'dataProvider' => $sellCommercialDataProvider,
                                        'filterModel' => $sellCommercialSearchModel,

                                        'rowOptions' => function ($model, $key, $index, $grid) use ($favorites) {
                                            $class = in_array($key, $favorites) ? 'favorites-row' : '';
                                            return ['key' => $key, 'index' => $index, 'class' => $class];
                                        },

                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',

                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Продажа - коммерческие</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                '<span>Выбранные: &nbsp;</span>' .
                                                Html::button('Удалить', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'deleteObjects("sell_commercial_objects_grid")',
                                                ]) . ' ' .
                                                Html::button( 'В архив', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'archiveObjects("sell_commercial_objects_grid")',
                                                ]) .
                                                (!Yii::$app->user->isGuest ? Html::button( 'В избранное', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'favoriteObjects("sell_commercial_objects_grid")',
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
                                    'columns' => $commercial_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'sell_commercial_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                            <div class="tab-pane fade" id="sell_residental_archive_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#sell_residental_archive_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $sellResidentalArchiveSearchModel->index,
                                    'options' => ['data-idx' => $sellResidentalArchiveSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="sell_residental_archive_objects_search">
                                    <?= $sellResidentalArchiveSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'sell_residental_archive_objects_grid',
                                        'dataProvider' => $sellResidentalArchiveDataProvider,
                                        'filterModel' => $sellResidentalArchiveSearchModel,
                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',
                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Продажа - жилые (архив)</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                '<span>Выбранные: &nbsp;</span>' .
                                                Html::button('В актуальные', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'restoreObjects("sell_residental_archive_objects_grid")',
                                                ]) .
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
                                    'columns' => $residental_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'sell_residental_archive_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                            <div class="tab-pane fade" id="sell_commercial_archive_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#sell_commercial_archive_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $sellCommercialArchiveSearchModel->index,
                                    'options' => ['data-idx' => $sellCommercialArchiveSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="sell_commercial_archive_objects_search">
                                    <?= $sellCommercialArchiveSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'sell_commercial_archive_objects_grid',
                                        'dataProvider' => $sellCommercialArchiveDataProvider,
                                        'filterModel' => $sellCommercialArchiveSearchModel,
                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',
                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Продажа - коммерческие (архив)</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',

                                            'after' =>
                                                '<div>' .
                                                '<span>Выбранные: &nbsp;</span>' .
                                                Html::button('В актуальные', [
                                                    'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                                    'onclick' => 'restoreObjects("sell_commercial_archive_objects_grid")',
                                                ]) .
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
                                    'columns' => $commercial_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'sell_commercial_archive_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                        </div>

                    </div>


                    <div class="tab-pane fade" id="deleted_info_tab">


                        <ul id="deleted_objects_tab" class="nav nav-tabs">
                            <?php if($this->context->residential_rent=='1' OR $this->context->residential_sale=='1'){?>

                            <li class="active">

                                <?= Html::a('Жилые', '#deleted_residental_info_tab', [
                                    'id' => 'deleted_residental_info_tab_link',
                                    // 'class' => 'btn btn-light-gray',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>

                            <?php } ?>
                            <?php if($this->context->commercial_rent=='1' OR $this->context->commercial_sale=='1'){?>

                            <li>
                                <?= Html::a('Коммерческие', '#deleted_commercial_info_tab', [
                                    'id' => 'deleted_commercial_info_tab_link',
                                    // 'class' => 'btn btn-light-gray',
                                    'data-toggle' => 'tab',
                                ]) ?>
                            </li>
                            <?php } ?>

                        </ul>




                        <div class="tab-content">

                            <div class="tab-pane fade in active" id="deleted_residental_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#deleted_residental_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $deletedResidentalSearchModel->index,
                                    'options' => ['data-idx' => $deletedResidentalSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="deleted_residental_objects_search">
                                    <?= $deletedResidentalSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'deleted_residental_objects_grid',
                                        'dataProvider' => $deletedResidentalDataProvider,
                                        'filterModel' => $deletedResidentalSearchModel,
                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',
                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Удаленные - жилые</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',
                                            'after' => false,
                                            // 'after' =>
                                            //     '<div>' .
                                            //         '<span>Выбранные: &nbsp;</span>' .
                                            //         Html::button('В актуальные', [
                                            //             'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                            //             'onclick' => 'restoreObjects("deleted_residental_objects_grid")',
                                            //         ]) .
                                            //     '</div>',
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
                                    'columns' => $residental_deleted_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'deleted_residental_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                            <div class="tab-pane fade" id="deleted_commercial_info_tab">

                                <div class="m-t-2">
                                    <?= Html::button('<i class="fa fa-search"></i> Расширенный поиск &nbsp;&nbsp;<span class="caret"></span>', [
                                        'class' => 'btn btn-default',
                                        'onclick' => '$("#deleted_commercial_objects_search").collapse("toggle")',
                                    ]) ?>
                                </div>


                                <?php Pjax::begin([
                                    'id' => 'info_tab_pjax_' . $deletedCommercialSearchModel->index,
                                    'options' => ['data-idx' => $deletedCommercialSearchModel->index],
                                    'timeout' => 3000,
                                    'enablePushState' => false,
                                    'clientOptions' => ['method' => 'post'],
                                ]) ?>

                                <div class="collapse full-search-form-container" id="deleted_commercial_objects_search">
                                    <?= $deletedCommercialSearchForm ?>
                                </div>

                                <?= DynaGrid::widget([
                                    'gridOptions' => [
                                        'id' => 'deleted_commercial_objects_grid',
                                        'dataProvider' => $deletedCommercialDataProvider,
                                        'filterModel' => $deletedCommercialSearchModel,
                                        'panelBeforeTemplate' => '{before}<div class="clearfix"></div>',
                                        'panel' => [
                                            'heading' => '<h3 class="panel-title">Удаленные - коммерческие</h3>',
                                            'before' => '<div class="pull-right">{dynagrid}{export}</div>',
                                            'after' => false,
                                            // 'after' =>
                                            //     '<div>' .
                                            //         '<span>Выбранные: &nbsp;</span>' .
                                            //         Html::button('В актуальные', [
                                            //             'class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical',
                                            //             'onclick' => 'restoreObjects("deleted_commercial_objects_grid")',
                                            //         ]) .
                                            //     '</div>',
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
                                    'columns' => $commercial_deleted_columns,
                                    'storage' => DynaGrid::TYPE_COOKIE,
                                    'options' => [
                                        'id' => 'deleted_commercial_objects_dynagrid',
                                        'class' => 'm-t-2',
                                    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>

                                <?php Pjax::end() ?>

                            </div>

                        </div>

                    </div>

                    </div>


                </div>

            </div>
        </div>
    </div>



<?php Modal::begin(['options' => ['id' => 'gallery-wrapper']]); Modal::end(); ?>

<?php Modal::begin(['id' => 'view-popup', 'size' => 'modal-lg']);
    echo "<div id='full-view'></div>";
Modal::end(); ?>


<?php if ($objectDeleteForm): ?>

    <?php Modal::begin([
        'id' => 'object_delete_modal',
        'header' => '<h4>Укажите причину</h4>',
        'footer' => Html::button('Удалить', ['id' => 'object_delete_modal_btn', 'class' => 'btn btn-danger']),
    ]); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'object_delete_form',
        'action' => '#'
    ]); ?>

    <?= $form->field($objectDeleteForm, 'object_id', [
        'template' => '{input}',
        'options' => ['tag' => null],
    ])->hiddenInput(['id' => 'object_id'])->label(false) ?>

    <?= $form->field($objectDeleteForm, 'target', [
        'template' => '{input}',
        'options' => ['tag' => null],
    ])->hiddenInput(['id' => 'target'])->label(false) ?>

    <?= $form->field($objectDeleteForm, 'reason_text')->textarea([
        'id' => 'reason_text',
        'class' => 'form-control',
        'rows' => 4,
        'data-id' => 1,
        'style' => [
            'resize' => 'vertical',
            'max-height' => '150px',
            'min-height' => '70px',
        ],
        'maxlength' => true
    ]) ?>

    <?php ActiveForm::end(); ?>

    <?php Modal::end(); ?>

<?php endif; ?>


<div id="popup_message"></div>

<div id="loader"></div>
<div id="fade"></div>

<?php $this->registerJs('

    $(function() {
    
     $(\'[data-toggle="tooltip"]\').tooltip();
    
        // $(".search-selector").select2({
        $("select[id ^= search_][multiple != multiple]").select2({
            width: "100%",
            minimumResultsForSearch: 2
        });
        
        $("[id ^= search_metro_selector_]").multiselect({
            texts: {
                placeholder: "---",
                search: "",
                selectedOptions: " выбрано"
            },
            search: true
        });
        
        $("[id ^= search_property_selector_]").multiselect({
            texts: {
                placeholder: "---",
                search: "",
                selectedOptions: " выбрано"
            },
            search: true
        });
        
        $("[id ^= search_district_selector_]").multiselect({
            texts: {
                placeholder: "---",
                search: "",
                selectedOptions: " выбрано"
            },
            search: true
        });

        $(document.body).on("click", "a[data-toggle=\'tab\']", function(event) {
            location.hash = this.getAttribute("href");
        });

        if (location.hash) {
            if (location.hash !== "#rent_info_tab" && location.hash !== "#sell_info_tab" && location.hash !== "#deleted_info_tab") {
                var hash = location.hash.substr(0, location.hash.indexOf("_")) + "_info_tab";
                $("a[href=\'" + hash + "\']").tab("show");
            }
            $("a[href=\'" + location.hash + "\']").tab("show");
        }

    });

'); ?>

<?php $this->registerJsFile('/js/jquery.bxslider.min.js', ['depends' => 'yii\web\YiiAsset']); ?>
