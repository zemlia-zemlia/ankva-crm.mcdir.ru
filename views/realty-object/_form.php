<?php

use app\assets\CropAsset;
use app\assets\MultiSelectAsset;
use app\assets\Select2Asset;
use app\assets\SortableAsset;
use app\assets\SuggestionAsset;
use app\helpers\LocationHelper;
use app\helpers\ObjectHelper;
use app\helpers\StageHelper;
use app\models\Adwords;
use app\models\RealtyObject;
use kartik\datetime\DateTimePicker;
use vova07\imperavi\Widget;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $form yii\widgets\ActiveForm */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDeleteForm \app\forms\ObjectDeleteForm|null */

SuggestionAsset::register($this);
MultiSelectAsset::register($this);
Select2Asset::register($this);
SortableAsset::register($this);
CropAsset::register($this);
?>

    <style>
        .redactor-box>.redactor-box {display: none}
    </style>

<div class="realty-object-form">

    <?php $form = ActiveForm::begin([
        'id' => 'realty_object_form',
        'action' => '',
    ]); ?>


    <?= Html::hiddenInput('form_action', '', ['id' => 'form_action']) ?>

    <?= $form->field($model, 'id', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput(['id' => 'obj_id'])->label(false) ?>

    <?= $form->field($model, 'copy_id', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput(['id' => 'copy_id'])->label(false) ?>

    <?= $form->field($model, 'images', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'nd', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput()->label(false) ?>






    <?= $form->field($model, 'status', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput(['id' => 'status'])->label(false) ?>

    <?= $form->field($model, 'images_order', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput(['id' => 'images_order'])->label(false) ?>

    <?= $form->field($model, 'id_company', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput(['id' => 'id_company','value' => ''.Yii::$app->user->identity->id_company.'' ])->label(false) ?>




<?php $region = $this->context->region;  $city_id = $this->context->city_id; ?>




<?php if($this->context->multiregion =='0'){ ?>

    <?= $form->field($model, 'region', [
        'template' => "{input}",
        'options' => ['class' => '']
    ])->hiddenInput(['id' => 'region','value' => ''.$region.'' ])->label(false) ?>

    <?php if($this->context->multirayon =='0'){ ?>

        <?= $form->field($model, 'city', [
            'template' => "{input}",
            'options' => ['class' => '']
        ])->hiddenInput(['id' => 'city','value' => ''.$city_id.'' ])->label(false) ?>


    <?php } ?>
    <?php } ?>

    <h4>Категория недвижимости</h4>

    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'category')->dropDownList(ObjectHelper::categoryList(), [
                'id' => 'category_list',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'type')->dropDownList(ObjectHelper::typeList(), [
                'id' => 'type_list',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

    </div>



    <h4>Собственник</h4>
    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">
<div class="col-md-12" style="    padding: 0px;">

        <div class="col-md-8" style="    padding: 0px;">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <?= $form->field($model, 'name', [
                    'options' => [
                        'class' => 'form-group',
                    ],
                ])->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->widget(MaskedInput::className(), [
                    'options' => [
                        'id' => 'contragent_phone',
                        'class' => 'form-control',
                    ],
                    'mask' => '+7 (999) 999 99 99',
                ]) ?>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <?= $form->field($model, 'phone_2')->textInput(['maxlength' => true])->widget(MaskedInput::className(), [
                    'mask' => '+7 (999) 999 99 99',
                ])->label('Доп. телефон') ?>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>




<?php if($this->context->additional_contact=='1'){ ?>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'use_telegram', [
                'template' => "{label}\n{input}",
            ])->checkbox([
                'id' => 'telegram_checkbox',
                'value' => 1,
                'uncheckValue' => 0
            ]) ?>
            <?= $form->field($model, 'telegram', [
                'template' => "{input}\n{error}",
            ])->textInput([
                'id' => 'telegram_input',
                'disabled' => !$model->use_telegram,
                'maxlength' => true,
            ])->label(false) ?>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'use_whatsapp', [
                'template' => "{label}\n{input}",
            ])->checkbox([
                'id' => 'whatsapp_checkbox',
                'value' => 1,
                'uncheckValue' => 0
            ]) ?>
            <?= $form->field($model, 'whatsapp', [
                'template' => "{input}\n{error}",
            ])->textInput([
                'maxlength' => true,
            ])->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99',
                'options' => [
                    'id' => 'whatsapp_input',
                    'class' => 'form-control',
                    'disabled' => !$model->use_whatsapp,
                ],
            ])->label(false) ?>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'use_viber', [
                'template' => "{label}\n{input}",
            ])->checkbox([
                'id' => 'viber_checkbox',
                'value' => 1,
                'uncheckValue' => 0
            ]) ?>
            <?= $form->field($model, 'viber', [
                'template' => "{input}\n{error}",
            ])->textInput([
                'maxlength' => true,
            ])->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99',
                'options' => [
                    'id' => 'viber_input',
                    'class' => 'form-control',
                    'disabled' => !$model->use_viber,
                ],
            ])->label(false) ?>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'use_vk', [
                'template' => "{label}\n{input}",
            ])->checkbox([
                'id' => 'vk_checkbox',
                'value' => 1,
                'uncheckValue' => 0
            ]) ?>
            <?= $form->field($model, 'vk', [
                'template' => "{input}\n{error}",
            ])->textInput([
                'id' => 'vk_input',
                'disabled' => !$model->use_vk,
                'maxlength' => true,
            ])->label(false) ?>
        </div>

<?php }?>
        </div>


    <div class="col-md-4" style="    padding: 0px;">



    <?php if ($parserDataProvider || $objectDataProvider): ?>

        <div class="control-label m-b-2" style="margin-bottom: 5px!important;">
            <p style="padding-left:15px;margin-bottom: 0px !important; ">Совпадения в базе</p>
        </div>


            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 m-b-1">

                <?= MaskedInput::widget([
                    'name' => 'search_phone',
                    'mask' => '+7 (999) 999 99 99',
                    'value' => $model->phone,
                    'options' => [
                        'id' => 'dublication_search_phone',
                        'class' => 'form-control',
                    ],
                ]) ?>

            </div>


            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 m-b-1">

                <?= Html::button('Поиск', [
                    'id' => 'dublication_search_btn',
                    'class' => 'btn dublication-search-btn',
                    'data-obj_id' => $model->id,
                    'data-copy_id' => $model->copy_id,
                ]) ?>

            </div>

        </div>




            <div class="col-xs-12">

                <div id="dublication_info" class="dublication-info">

                    <div id="dublication_info_heading" class="dublication-info-heading">
                        <?= 'Совпадения &nbsp;(' . (($parserDataProvider ? $parserDataProvider->count : 0) + ($objectDataProvider ? $objectDataProvider->count : 0)) . ')' ?>
                    </div>

                    <div class="collapse" id="dublications">

                        <hr>

                        <div class="m-y-2">
                            Парсер: найдено <?= $parserDataProvider ? $parserDataProvider->count : 0 ?> совп.
                        </div>

                        <?php if ($parserDataProvider && $parserDataProvider->count > 0): ?>

                            <?= GridView::widget([
                                'summary' => '',
                                'dataProvider' => $parserDataProvider,
                                'columns' => [
                                    [
                                        'label' => 'Фото',
                                        'headerOptions' => ['style' => 'width: 90px; text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'contentOptions' => ['style' => 'padding: 10px 3px; text-align: center'],
                                        'format'=> 'raw',
                                        'value' =>  function($data) {
                                            $arrImages = explode(',', $data->images);
                                            $currentImage = trim( $arrImages[0] );
                                            $str = Html::img($currentImage, [
                                                'class' => 'view-popup-img img-responsive',
                                                // 'id' => 'view_popup_img',
                                                'value' => '/rooms/viewpopup?id=' . $data->id,
                                                'data-title' => $data->title,
                                                'title' => 'Посмотреть',
                                                'style' => [
                                                    'cursor' => 'pointer',
                                                ],
                                            ]);
                                            return $str;
                                        }
                                    ],
                                    [
                                        "attribute" => 'date_avito',
                                        'label' => 'Дата',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'format' => ['datetime', 'php:d M Y H:i']
                                    ],
                                    [
                                        'attribute' => 'type',
                                        'label' => 'Тип',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                    ],
                                    [
                                        'attribute' => 'addr',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'description',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'format' => 'raw',
                                        'value' => function($data) {
                                            if ( strlen($data->description) > 400 ) {

                                                $tmpDescription = substr($data->description, 0, 400);
                                                $lastSpace = strripos($tmpDescription, ' ');
                                                $firstDescription = substr($data->description, 0, $lastSpace);
                                                return $firstDescription . ' ...';

                                            } else {

                                                return $data->description;
                                            }
                                        }
                                    ],
                                    // [
                                    //     'attribute' => 'title',
                                    //     'headerOptions' => ['style' => 'text-align: center'],
                                    // ],
                                    // [
                                    //     'attribute' => 'price',
                                    //     'headerOptions' => ['style' => 'text-align: center'],
                                    // ],
                                    // [
                                    //     'attribute' => 'phone',
                                    //     'headerOptions' => ['style' => 'text-align: center'],
                                    //     'content'=>function($data){
                                    //         return "".$data->seller." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>";
                                    //     }
                                    // ],
                                    // [
                                    //     'attribute' => 'city',
                                    //     'headerOptions' => ['style' => 'text-align: center'],
                                    // ],
                                ],
                            ]); ?>

                        <?php endif; ?>

                        <hr>

                        <div class="m-y-2">
                            База: найдено <?= $objectDataProvider ? $objectDataProvider->count : 0 ?> совп.
                        </div>

                        <?php if ($objectDataProvider && $objectDataProvider->count > 0): ?>

                            <?= GridView::widget([
                                'summary' => '',
                                'dataProvider' => $objectDataProvider,
                                'columns' => [
                                    [
                                        'label' => 'Фото',
                                        'headerOptions' => ['style' => 'width: 90px; text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'contentOptions' => ['style' => 'padding: 10px 3px; text-align: center'],
                                        'format'=> 'raw',
                                        'value' =>  function($data) {
                                            $arrImages = explode(',', $data->images);
                                            $currentImage = trim( $arrImages[0] );
                                            $str = Html::img($currentImage, [
                                                'class' => 'view-popup-img img-responsive',
                                                'value' => '/realty-object/view-modal?id=' . $data->id,
                                                'data-title' => 'Объект #' . $data->id,
                                                'title' => 'Посмотреть',
                                                'style' => [
                                                    'cursor' => 'pointer',
                                                ],
                                            ]);
                                            return $str;
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'label' => 'Дата',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'format' => ['datetime', 'php:d M Y H:i']
                                    ],
                                    [
                                        'attribute' => 'type',
                                        'label' => 'Тип',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'value' => function(RealtyObject $data) {
                                            return ObjectHelper::typeName($data->type);
                                        }
                                    ],
                                    [
                                        'label' => 'Адрес',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'value' => function(RealtyObject $data) {
                                            return LocationHelper::regionName($data->region) . ', ' . LocationHelper::cityName($data->city);
                                        }
                                    ],
                                    [
                                        'attribute' => 'description',
                                        'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                                        'format' => 'raw',
                                        'value' => function($data) {
                                            if ( strlen($data->description) > 400 ) {

                                                $tmpDescription = substr($data->description, 0, 400);
                                                $lastSpace = strripos($tmpDescription, ' ');
                                                $firstDescription = substr($data->description, 0, $lastSpace);
                                                return $firstDescription . ' ...';

                                            } else {

                                                return $data->description;
                                            }
                                        }
                                    ],
                                    // [
                                    //     'attribute' => 'price',
                                    //     'headerOptions' => ['style' => 'text-align: center'],
                                    // ],
                                    // [
                                    //     'attribute' => 'phone',
                                    //     'headerOptions' => ['style' => 'text-align: center'],
                                    //     'content'=>function(RealtyObject $data){
                                    //         return "".$data->name." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>";
                                    //     }
                                    // ],
                                ],
                            ]); ?>

                        <?php endif; ?>

                    </div>

                </div>








    <?php else: ?>

        <div class="control-label m-b-2" style="margin-bottom: 5px!important;">
            <p style="padding-left:15px;margin-bottom: 0px !important; ">Совпадения в базе</p>
        </div>



            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 m-b-1">

                <?= MaskedInput::widget([
                    'name' => 'search_phone',
                    'mask' => '+7 (999) 999 99 99',
                    'value' => $model->phone,
                    'options' => [
                        'id' => 'dublication_search_phone',
                        'class' => 'form-control',
                    ],
                ]) ?>

            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 m-b-1">

                <?= Html::button('Поиск', [
                    'id' => 'dublication_search_btn',
                    'class' => 'btn dublication-search-btn',
                    'data-obj_id' => $model->id,
                ]) ?>

            </div>





            <div class="col-xs-12">

                <div id="dublication_info" class="dublication-info">

                    <div id="dublication_info_heading" class="dublication-info-heading">
                        Совпадения &nbsp;(0)
                    </div>

                    <div class="collapse" id="dublications">

                        <hr>

                        <div class="m-y-2">
                            Парсер: найдено 0 совп.
                        </div>

                        <hr>

                        <div class="m-y-2">
                            База: найдено 0 совп.
                        </div>

                    </div>

                </div>

            </div>



    <?php endif; ?>

    <div class="clearfix"></div>
    </div>
    </div>
</div>


    <h4>Местоположение</h4>

    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

        <?php $region = $this->context->region;  $city_id = $this->context->city_id; ?>




        <?php if($this->context->multiregion =='1'){ ?>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'region', [
                'options' => [
                    'class' => 'form-group',
                ],
            ])->dropDownList(LocationHelper::regionList(), [
                'id' => 'location_region_selector',
                'data-idx' => '0',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

        <?php $city_list = LocationHelper::cityList($model->region) ?>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <?= $form->field($model, 'city')->dropDownList($city_list, [
                    'id' => 'location_city_selector',
                    'data-idx' => '0',
                    'prompt' => [
                        'text' => '---',
                        'options' => [
                            'value' => '',
                        ]
                    ],
                    'disabled' => count($city_list) == 0,
                ]) ?>
            </div>

    <?php }else{ ?>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <label class="control-label" for="street_address">Регион</label>
                <h5>  <?php echo LocationHelper::regionName($this->context->region); ?> </h5>
            </div>



            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">

                <?php $city_list = LocationHelper::cityList($model->region) ?>

               <?php if( $this->context->multirayon =='1'){ ?>

                   <?php $city_list = LocationHelper::cityList($this->context->region) ?>

                <?= $form->field($model, 'city')->dropDownList($city_list, [
                    'id' => 'location_city_selector',
                    'data-idx' => '0',
                    'prompt' => [
                        'text' => '---',
                        'options' => [
                            'value' => '',
                        ]
                    ],

                ]) ?>
                <?php }else{?>
                   <label class="control-label" for="street_address">Город</label>

                   <h5>  <?php $city_name=LocationHelper::cityName($this->context->city_id); echo $city_name; ?> </h5>

        <?php }?>




            </div>




    <?php }?>

        <?php
        if($this->context->city_id){
        $city_name=LocationHelper::cityName($this->context->city_id); }

        ?>

        <?php if($this->context->multiregion =='1'){ $district_list = LocationHelper::districtList($model->city); }
        else { $district_list = LocationHelper::districtList($city_id); } ?>

        <?= $form->field($model, 'district_id', [
            'template' => "<div class='col-lg-3 col-md-3 col-sm-6 col-xs-6'>{label}\n{input}</div>",
            'options' => [
                'id' => 'district_selector',
                'data-idx' => '0',

                   'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                  ],
                'class' => 'form-group',
                'style' => [
                    'display' => count($district_list) > 0 ? 'inherit' : 'none',
                ],


            ]
        ])->dropDownList($district_list, [
            'id' => 'location_district_selector',
            'data-idx' => '0',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
            'disabled' => count($district_list) == 0,
        ]) ?>

        <?php $metro_list = LocationHelper::metroList($model->city, $model->metro) ?>


        <div id="metro_selector" data-idx="0" class="form-group" style="display: <?= $metro_list == '' ? 'none' : 'inherit' ?>">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">

                <label class="control-label">
                    Метро
                </label>

                <div>

                    <select id="location_metro_selector" data-idx="0" name="metro[]" multiple="multiple"<?= $metro_list == '' ? ' disabled' : '' ?> title="Метро">
                        <?= $metro_list ?>
                    </select>

                </div>

            </div>
        </div>

    </div>


    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

        <?php if($this->context->multiregion =='0' ){ ?>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <?= $form->field($model, 'street')->textInput([
                    'id' => 'street_address',
                    'data-idx' => '0',
                    'maxlength' => true,
                    'disabled' => !$city_name && !$model->street,
                ]) ?>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <?= $form->field($model, 'home')->textInput([
                    'id' => 'house_address',
                    'data-idx' => '0',
                    'maxlength' => true,
                    'disabled' => !$model->street,
                ]) ?>
            </div>

            <?= $form->field($model, 'apartment_number', [
                'template' => "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>{label}\n{input}</div>",
                'options' => [
                    'id' => 'apartment_number',
                    'data-idx' => '0',
                    'class' => 'form-group',
                    'style' => [
                        'display' => $model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL ? 'inherit' : 'none',
                    ],
                ],
            ])->textInput([
                'id' => 'apartment',
                'data-idx' => '0',
                'disabled' => !$model->home,
            ]) ?>


    <?php }else{ ?>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <?= $form->field($model, 'street')->textInput([
                    'id' => 'street_address',
                    'data-idx' => '0',
                    'maxlength' => true,
                    'disabled' => !$model->city && !$model->street,
                ]) ?>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <?= $form->field($model, 'home')->textInput([
                    'id' => 'house_address',
                    'data-idx' => '0',
                    'maxlength' => true,
                    'disabled' => !$model->street,
                ]) ?>
            </div>

            <?= $form->field($model, 'apartment_number', [
                'template' => "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>{label}\n{input}</div>",
                'options' => [
                    'id' => 'apartment_number',
                    'data-idx' => '0',
                    'class' => 'form-group',
                    'style' => [
                        'display' => $model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL ? 'inherit' : 'none',
                    ],
                ],
            ])->textInput([
                'id' => 'apartment',
                'data-idx' => '0',
                'disabled' => !$model->home,
            ]) ?>





    <?php } ?>



    </div>


    <h4>Характеристики</h4>


    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

        <div class="col-md-5th">
            <?= $form->field($model, 'property_type', [
                'options' => [
                    'class' => 'form-group',
                ],
            ])->dropDownList(ObjectHelper::propertyTypeList($model->category), [
                'id' => 'property_type_list',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

        <div class="col-md-5th">
            <?= $form->field($model, 'repair')->dropDownList(ObjectHelper::repairTypeList(), [
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

        <div class="col-md-5th">
            <?= $form->field($model, 'furniture')->dropDownList(ObjectHelper::furnitureList(), [
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

        <div class="col-md-5th">
            <?= $form->field($model, 'floor')->textInput() ?>
        </div>

        <div class="col-md-5th">
            <?= $form->field($model, 'total_floor')->textInput() ?>
        </div>

    </div>


    <h4>Площадь</h4>


    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

        <?= $form->field($model, 'class_building', [
            'template' => "<div class='col-md-5th'>{label}\n{input}</div>",
            'options' => [
                'id' => 'class_building',
                'class' => 'form-group',
                'style' => [
                    'display' => $model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL ? 'inherit' : 'none',
                ],
            ]
        ])->dropDownList(ObjectHelper::classTypeList(), [
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>

        <?= $form->field($model, 'type_building', [
            'template' => "<div class='col-md-5th'>{label}\n{input}</div>",
            'options' => [
                'id' => 'type_building',
                'class' => 'form-group',
                'style' => [
                    'display' => $model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL ? 'inherit' : 'none',
                ],
            ]
        ])->dropDownList(ObjectHelper::buildTypeList(), [
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>

        <div class="col-md-5th">
            <?= $form->field($model, 'total_area')->textInput()->label('Пл. общая') ?>
        </div>

        <?= $form->field($model, 'living_area', [
            'template' => "<div class='col-md-5th'>{label}\n{input}</div>",
            'options' => [
                'id' => 'living_area',
                'class' => 'form-group',
                'style' => [
                    'display' => $model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL ? 'inherit' : 'none',
                ],
            ]
        ])->textInput()->label('Пл. жилая') ?>

        <?= $form->field($model, 'kitchen_area', [
            'template' => "<div class='col-md-5th'>{label}\n{input}</div>",
            'options' => [
                'id' => 'kitchen_area',
                'class' => 'form-group',
                'style' => [
                    'display' => $model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL ? 'inherit' : 'none',
                ],
            ]
        ])->textInput()->label('Пл. кухни') ?>

    </div>


    <h4>Цена</h4>


    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>

        <?= $form->field($model, 'pledge', [
            'template' => "<div class='col-lg-3 col-md-3 col-sm-6 col-xs-6'>{label}\n{input}</div>",
            'options' => [
                'id' => 'pledge',
                'class' => 'form-group',
                'style' => [
                    'display' => $model->type == RealtyObject::REALTY_OBJECT_TYPE_RENT ? 'inherit' : 'none',
                ],
            ]
        ])->textInput() ?>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'utility')->dropDownList(ObjectHelper::utilityTypeList(), [
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>
<?php if($this->context->cadastral=='1'){ ?>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <?= $form->field($model, 'cadastral', [
                'options' => [
                    'class' => 'form-group',
                ],
            ])->textInput(['maxlength' => true]) ?>
        </div>
<?php }?>
    </div>


    <div id="rent" style="display: <?= $model->type == RealtyObject::REALTY_OBJECT_TYPE_RENT ? 'inherit' : 'none' ?>">
        <div class="row m-t-1" style="margin-bottom: 2px">

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

                <?= $form->field($model, 'trade', [
                    'template' => "{label}\n{input}",
                ])->checkbox([
                    'labelOptions' => ['style' => ['margin-top' => '10px']],
                    'value' => 1,
                    'uncheckValue' => 0
                ]) ?>

            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-right">

                <?= $form->field($model, 'release', [
                    'template' => "{label}\n{input}",
                ])->checkbox([
                    'labelOptions' => ['style' => ['margin-top' => '10px']],
                    'id' => 'release_date_checkbox',
                    'value' => 1,
                    'uncheckValue' => 0
                ]) ?>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <?= $form->field($model, 'release_date')->widget(DateTimePicker::className(), [
                    'readonly' => true,
                    'removeButton' => false,
                    'pickerIcon' => '<i class="fa fa-calendar"></i>',
                    'options' => ['id' => 'release_date', 'placeholder' => 'Дата ...', 'autocomplete' => 'off', 'disabled' => !$model->release],
                    'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
                ])->label(false) ?>
            </div>


        </div>

    </div>

    <h4>Информация</h4>

    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

        <div class="col-xs-12">

            <?= $form->field($model, 'description', [
                'options' => [
                    'class' => 'form-group m-t-2',
                ],
            ])->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'plugins' => [
                        'fullscreen',
                    ],
                ],
            ]) ?>

        </div>
<?php if($this->context->service_information=='1'){ ?>

        <div class="col-xs-12 m-t-2">

            <?= $form->field($model, 'service_info')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'plugins' => [
                        'fullscreen',
                    ],
                ],
            ]) ?>

        </div>
<?php } ?>
    </div>

<?php if($this->context->responsible=='1'){ ?>

    <h4>Ответственный и воронка</h4>


    <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">




        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'manager', [
                'options' => [
                    'class' => 'form-group',
                ],
            ])->dropDownList(\app\models\client\Staff::getList())
             ?>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'stage')->dropDownList(StageHelper::stageList(), [
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'source')->dropDownList(Adwords::adwordList(), [
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
        </div>

    </div>
<?php }?>

    <div class="row m-t-1">

        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-lg-4 col-md-4 col-sm-4 col-xs-6 text-right">
            <?= $form->field($model, 'call_back', [
                'template' => "{label}\n<div class='col-xs-12'>{input}</div>",
            ])->checkbox([
                'labelOptions' => ['style' => ['margin-top' => '10px']],
                'id' => 'call_back_checkbox',
                'value' => 1,
                'uncheckValue' => 0
            ]) ?>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'call_back_date')->widget(DateTimePicker::className(), [
                'readonly' => true,
                'removeButton' => false,
                'pickerIcon' => '<i class="fa fa-calendar"></i>',
                'options' => ['id' => 'call_back_date', 'placeholder' => 'Дата ...', 'autocomplete' => 'off', 'disabled' => !$model->call_back],
                'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
            ])->label(false) ?>
        </div>

    </div>


    <div class="clearfix"></div>


    <hr>

    <?php

        $image_list = '';

        if ($model->images) {

            $images = explode(',', $model->images);

            foreach ($images as $key => $image) {

                $image_list .=
                    '<div data-image="' . basename($image) . '" class="filestyler__item filestyler__item_is-image filestyler__item_image-png">
                        <input name="old_images[]" value="' . $image . '" type="hidden">
                        <input type="hidden" class="filestyler__sort-helper" value="' . $key . '">
                        <div class="filestyler__figure" style="background-image: url(' . $image . ')">
                            <img class="filestyler__image" src="' . $image . '">
                        </div>' .
                        (($model->object && !$model->object->isDeleted()) ?
                            (($model->id ? '<button type="button" class="filestyler__crop"><i class="fa fa-cut"></i></button>' : '') .
                                '<button type="button" class="filestyler__remove"><i class="fa fa-times"></i></button>') : '') .
                        // (($model->id && !$model->object->isDeleted()) ? '<button type="button" class="filestyler__crop"><i class="fa fa-cut"></i></button>' : '') .
                        // '<button type="button" class="filestyler__remove"><i class="fa fa-times"></i></button>' .
                    '</div>';
            }
        }

    ?>

    <?php if (!$model->id || ($model->object && !$model->object->isDeleted())): ?>

        <?= $form->field($model, 'image_files[]', [
            'options' => [
                'class' => 'fprm-group',
            ],
            'template' => "{label}\n
                <div class='filestyler_board_form'>
                    <div class='filestyler filestyler_uninitialized filestyler_image'>
                        <div id='sortable' class='filestyler__list'>" .
                            $image_list .
                            "<label class='filestyler__file filestyler__plus'>{input}</label>
                        </div>
                    </div>
                </div>",
            'labelOptions' => ['class' => 'control-label m-b-2'],
        ])->fileInput([
            'id' => 'realty_object_fileinput',
            'class' => 'filestyler__input',
            'accept' => 'image/*',
            'multiple' => true,
        ]) ?>

    <?php else: ?>

        <div class="control-label m-b-2">Фотографии</div>

        <div class='filestyler_board_form'>
            <div class='filestyler filestyler_uninitialized filestyler_image'>
                <div class='filestyler__list'>
                    <?= $image_list ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="clearfix"></div>

    <?php if ($model->id): ?>

        <?= Html::button('Скачать фотографии', [
            'class' => 'btn m-t-2',
            'onclick' => 'location.href="' . Url::to(['/realty-object/download-images', 'id' => $model->id]) . '"',
        ]) ?>

    <?php endif; ?>



    <?php ActiveForm::end(); ?>

</div>



<?php Modal::begin([
    'id' => 'view-popup',
    'size' => 'modal-lg',
]);

echo "<div id='full-view'></div>";

Modal::end(); ?>



<?php Modal::begin([
    'id' => 'crop_image_modal',
    'size' => 'modal-lg',
    'header' => '<h4>Выберите область изображения</h4>',
    'footer' => '<div class="cropper-footer"></div>',
]); ?>

<?= Html::hiddenInput('image_src', '', ['id' => 'image_src']) ?>
<?//= Html::hiddenInput('crop_object_id', $model->object->id, ['id' => 'crop_object_id']) ?>

<div class="row">

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="modal_crop_image">
        <div class="cropper-container"></div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="modal_crop_preview" style="padding-right: 27px">
        <div id="preview1" class="cropper-preview modal-image-cropper-preview"></div>
    </div>

</div>

<?php Modal::end(); ?>



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


    <?php $token = 'ce84cf57c3f0608fa62c6cff354ec3ed29c21b1b'; ?>

<div id="loader"></div>
<div id="fade"></div>



<?php if($this->context->multiregion =='1' OR $this->context->multirayon =='1'){ ?>

<?php $this->registerJs('
    $(function() {
        $("select[multiple != multiple]").select2({
            width: "100%",
            minimumResultsForSearch: 2
        });
        
        $("#location_metro_selector").multiselect({
            texts: {
                placeholder: "---",
                search: "",
                selectedOptions: " выбрано"
            },
            search: true
        });
        
        $("#street_address").suggestions({
            token: "'.$token.'",
            type: "ADDRESS",
            geoLocation: false,
            bounds: "street",
            hint: false,
            constraints: {
                label: false,
                locations: { city: $("#location_city_selector").find(":selected").text() }
            },
            restrict_value: true,

            onSelect: function(suggestion) {

                var house_address = $("#house_address");
                var stg_house_address = house_address.suggestions();

                house_address.attr("disabled", null);

                stg_house_address.clear();
                stg_house_address.setOptions({
                    constraints: {
                        label: false,
                        locations: {
                            city: $("#location_city_selector").find(":selected").text(),
                            street: suggestion.data.street
                        }
                    },
                    restrict_value: true
                });

            }
        });

        $("#house_address").suggestions({
            token:  "'.$token.'",
            type: "ADDRESS",
            geoLocation: false,
            bounds: "house",
            hint: false,
            constraints: {
                label: false,
                locations: {
                    city: $("#location_city_selector").find(":selected").text(),
                    street: $("#street_address").val()
                }
            },
            restrict_value: true,

            onSelect: function(suggestion) {
                $("#apartment").attr("disabled", null);
            }
        });
        
        
        new Sortable(sortable, {
            animation: 150,
            ghostClass: "sortable-ghost-item",
            dataIdAttr: "data-image",
            filter: ".filestyler__file filestyler__plus",
            
            
            // store: {
            //     /**
            //      * Get the order of elements. Called once during initialization.
            //      * @param   {Sortable}  sortable
            //      * @returns {Array}
            //      */
            //     // get: function (sortable) {
            //     //     var order = localStorage.getItem(sortable.options.group.name);
            //     //     return order ? order.split("|") : [];
            //     // },
            //
            //     /**
            //      * Save the order of elements. Called onEnd (when the item is dropped).
            //      * @param {Sortable}  sortable
            //      */
            //     set: function (sortable) {
            //         // var order = sortable.toArray();
            //         // localStorage.setItem(sortable.options.group.name, order.join("|"));
            //         sortImages(' . $model->id . ');
            //     }
            // },
            
            onMove: function (evt) {
                return evt.related.className !== "filestyler__file filestyler__plus";
            }
        });
    });
') ?>


<?php }else{ ?>



 <?php $this->registerJs('
    $(function() {
        $("select[multiple != multiple]").select2({
            width: "100%",
            minimumResultsForSearch: 2
        });
        
        $("#location_metro_selector").multiselect({
            texts: {
                placeholder: "---",
                search: "",
                selectedOptions: " выбрано"
            },
            search: true
        });
        
        $("#street_address").suggestions({
            token: "'.$token.'",
            type: "ADDRESS",
            geoLocation: false,
            bounds: "street",
            hint: false,
            constraints: {
                label: false,
                locations: { city: "'.$city_name.'" }
            },
            restrict_value: true,

            onSelect: function(suggestion) {

                var house_address = $("#house_address");
                var stg_house_address = house_address.suggestions();

                house_address.attr("disabled", null);

                stg_house_address.clear();
                stg_house_address.setOptions({
                    constraints: {
                        label: false,
                        locations: {
                            city: "'.$city_name.'",
                            street: suggestion.data.street
                        }
                    },
                    restrict_value: true
                });

            }
        });

        $("#house_address").suggestions({
            token:  "'.$token.'",
            type: "ADDRESS",
            geoLocation: false,
            bounds: "house",
            hint: false,
            constraints: {
                label: false,
                locations: {
                    city: "'.$city_name.'",
                    street: $("#street_address").val()
                }
            },
            restrict_value: true,

            onSelect: function(suggestion) {
                $("#apartment").attr("disabled", null);
            }
        });
        
        
        new Sortable(sortable, {
            animation: 150,
            ghostClass: "sortable-ghost-item",
            dataIdAttr: "data-image",
            filter: ".filestyler__file filestyler__plus",
            
            
            // store: {
            //     /**
            //      * Get the order of elements. Called once during initialization.
            //      * @param   {Sortable}  sortable
            //      * @returns {Array}
            //      */
            //     // get: function (sortable) {
            //     //     var order = localStorage.getItem(sortable.options.group.name);
            //     //     return order ? order.split("|") : [];
            //     // },
            //
            //     /**
            //      * Save the order of elements. Called onEnd (when the item is dropped).
            //      * @param {Sortable}  sortable
            //      */
            //     set: function (sortable) {
            //         // var order = sortable.toArray();
            //         // localStorage.setItem(sortable.options.group.name, order.join("|"));
            //         sortImages(' . $model->id . ');
            //     }
            // },
            
            onMove: function (evt) {
                return evt.related.className !== "filestyler__file filestyler__plus";
            }
        });
    });
') ?>


    <?php } ?>




<?php
$this->registerJsFile('js/jquery.magnific-popup.min.js', ['depends' => 'yii\web\YiiAsset']);

$openMagnific = <<<JS
    $('.filestyler__list').magnificPopup({
        delegate: 'img',
        type: 'image',
        gallery: {
            enabled: true,
            preload: [0, 1]
        },
        callbacks: {
            elementParse: function(item) {
                item.src = $(item.el).attr('src');
            }
        }
    });
JS;

$this->registerJs($openMagnific);
