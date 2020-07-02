<?php

use app\helpers\LocationHelper;
use app\helpers\ObjectHelper;
use app\helpers\StageHelper;
use app\models\Adwords;
use app\models\RealtyObject;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RealtyObjectSearch */
/* @var $managers array */
/* @var $type integer */
/* @var $category integer */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'search_form_' . $model->index,
        'class' => 'full-search-form',
        'data-pjax' => true,
        // 'style' => [
        //     'margin-bottom' => '0',
        // ]
    ],
]); ?>

<div class="row control-label">
    <div class="col-xs-12">
        Дата
    </div>
</div>

<div class="row">

    <div class="col-md-3 p-r-1">

        <?= $form->field($model, 'date_from')->widget(DateTimePicker::class, [
            'readonly' => true,
            'removeButton' => false,
            'pickerIcon' => '<i class="fa fa-calendar"></i>',
            'options' => ['placeholder' => 'с', 'autocomplete' => 'off', 'id' => 'date_from_' . $model->index],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'dd.mm.yyyy HH:ii'
            ],
        ])->label(false) ?>

    </div>

    <div class="col-md-3 p-l-1">

        <?= $form->field($model, 'date_to')->widget(DateTimePicker::class, [
            'readonly' => true,
            'removeButton' => false,
            'pickerIcon' => '<i class="fa fa-calendar"></i>',
            'options' => ['placeholder' => 'по', 'autocomplete' => 'off', 'id' => 'date_to_' . $model->index],
            'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
        ])->label(false) ?>

    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-3">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'phone_2')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>

</div>


<div class="row">

    <div class="col-md-3">
        <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'whatsapp')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'viber')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'vk')->textInput(['maxlength' => true]) ?>
    </div>

</div>

<hr>

<div class="row">

    <div class="col-md-3">
        <?= $form->field($model, 'region')->dropDownList(LocationHelper::regionList(), [
            'id' => 'search_region_selector_' . $model->index,
            // 'class' => 'form-control search-selector',
            'data-idx' => $model->index,
            // 'data-selector' => 'search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>


    <div class="col-md-3">
        <?= $form->field($model, 'city')->dropDownList(LocationHelper::cityList($model->region), [
            'id' => 'search_city_selector_' . $model->index,
            // 'class' => 'form-control search-selector',
            'data-idx' => $model->index,
            // 'data-selector' => 'search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>

    <?php $district_list = LocationHelper::districtList($model->city) ?>





    <?= $form->field($model, 'district2', [
        'template' => "<div class='col-lg-3 col-md-3 col-sm-6 col-xs-6'>{label}\n{input}</div>",
        'options' => [
            'id' => 'district_selector_' . $model->index,
            'data-idx' => $model->index,
            'class' => 'form-group',
            'style' => [
                'display' => count($district_list) > 0 ? 'inherit' : 'none',
            ],
        ]
    ])->dropDownList($district_list, [
        'id' => 'search_district_selector_' . $model->index,
        'data-idx' => $model->index,
        'disabled' => count($district_list) == 0,
        'multiple' => 'multiple',
    ]) ?>

    <?php $metro_list = LocationHelper::metroList($model->city, $model->metro) ?>

    <div id="metro_selector_<?= $model->index ?>" data-idx="<?= $model->index ?>" class="form-group" style="display: <?= $metro_list == '' ? 'none' : 'inherit' ?>">
        <div class="col-md-3">

            <label class="control-label">
                Метро
            </label>

            <div>

                <select id="search_metro_selector_<?= $model->index ?>" data-idx="<?= $model->index ?>" name="RealtyObjectSearch[metro][]" multiple="multiple"<?= $metro_list == '' ? ' disabled' : '' ?> title="Метро">
                    <?= $metro_list ?>
                </select>

            </div>

        </div>
    </div>

</div>


<div class="row">

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= $form->field($model, 'home')->textInput(['maxlength' => true]) ?>
    </div>

    <?php if ($category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL): ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= $form->field($model, 'apartment_number')->textInput() ?>
        </div>
    <?php endif; ?>

</div>

<hr>

<div class="row">

    <div class="col-md-5th">
        <?= $form->field($model, 'prop_type')->dropDownList(ObjectHelper::propertyTypeList($category), [
            'id' => 'search_property_selector_' . $model->index,
            'multiple' => 'multiple',
        ]) ?>
    </div>

    <div class="col-md-5th">
        <?= $form->field($model, 'repair')->dropDownList(ObjectHelper::repairTypeList(), [
            'id' => 'search_repair_' . $model->index,
            // 'class' => 'form-control search-selector',
            // 'data-selector' => 'search-selector',
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
            'id' => 'search_furniture_' . $model->index,
            // 'class' => 'form-control search-selector',
            // 'data-selector' => 'search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>


    <?php if ($category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL): ?>
        <div class="col-md-5th">

            <?= $form->field($model, 'class_building')->dropDownList(ObjectHelper::classTypeList(), [
                'id' => 'search_class_building_' . $model->index,
                // 'class' => 'form-control search-selector',
                // 'data-selector' => 'search-selector',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>

        </div>

        <div class="col-md-5th">

            <?= $form->field($model, 'type_building')->dropDownList(ObjectHelper::buildTypeList(), [
                'id' => 'search_type_building_' . $model->index,
                // 'class' => 'form-control search-selector',
                // 'data-selector' => 'search-selector',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>

        </div>
    <?php endif; ?>

</div>


<div class="row control-label">
    <div class="col-xs-4">
        Общая площадь
    </div>
    <?php if ($category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL): ?>
        <div class="col-xs-4">
            Жилая площадь
        </div>
        <div class="col-xs-4">
            Площадь кухни
        </div>
    <?php endif; ?>
</div>

<div class="row">

    <div class="col-xs-2 p-r-1">
        <?= $form->field($model, 'total_area_from')->textInput(['placeholder' => 'с'])->label(false) ?>
    </div>
    <div class="col-xs-2 p-l-1">
        <?= $form->field($model, 'total_area_to')->textInput(['placeholder' => 'по'])->label(false) ?>
    </div>

    <?php if ($category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL): ?>
        <div class="col-xs-2 p-r-1">
            <?= $form->field($model, 'living_area_from')->textInput(['placeholder' => 'с'])->label(false) ?>
        </div>
        <div class="col-xs-2 p-l-1">
            <?= $form->field($model, 'living_area_to')->textInput(['placeholder' => 'по'])->label(false) ?>
        </div>
        <div class="col-xs-2 p-r-1">
            <?= $form->field($model, 'kitchen_area_from')->textInput(['placeholder' => 'с'])->label(false) ?>
        </div>
        <div class="col-xs-2 p-l-1">
            <?= $form->field($model, 'kitchen_area_to')->textInput(['placeholder' => 'по'])->label(false) ?>
        </div>
    <?php endif; ?>

</div>




<div class="row control-label">
    <div class="col-xs-6">

        Этаж

    </div>
    <div class="col-xs-6">

        Всего этажей

    </div>
</div>


<div class="row">


    <div class="col-xs-3 p-r-1">

        <?= $form->field($model, 'floor_from')->textInput(['placeholder' => 'с'])->label(false) ?>

    </div>
    <div class="col-xs-3 p-l-1">

        <?= $form->field($model, 'floor_to')->textInput(['placeholder' => 'по'])->label(false) ?>

    </div>

    <div class="col-xs-3 p-r-1">

        <?= $form->field($model, 'total_floor_from')->textInput(['placeholder' => 'с'])->label(false) ?>

    </div>
    <div class="col-xs-3 p-l-1">

        <?= $form->field($model, 'total_floor_to')->textInput(['placeholder' => 'по'])->label(false) ?>

    </div>
</div>

<hr>

<div class="row">

    <div class="col-md-3 p-r-1">
        <?= $form->field($model, 'price_from')->textInput(['placeholder' => 'с'])/*->label(false)*/ ?>
    </div>

    <div class="col-md-3 p-l-1">
        <?= $form->field($model, 'price_to')->textInput(['placeholder' => 'по'])->label('&nbsp;') ?>
    </div>

    <?php if ($type == RealtyObject::REALTY_OBJECT_TYPE_RENT): ?>
        <div class="col-md-3 p-r-1">
            <?= $form->field($model, 'pledge_from')->textInput(['placeholder' => 'с'])/*->label(false)*/ ?>
        </div>

        <div class="col-md-3 p-l-1">
            <?= $form->field($model, 'pledge_to')->textInput(['placeholder' => 'по'])->label('&nbsp;') ?>
        </div>
    <?php endif; ?>

<!--</div>-->


<!--<div class="row">-->

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
        <?= $form->field($model, 'utility')->dropDownList(ObjectHelper::utilityTypeList(), [
            'id' => 'search_utility_' . $model->index,
            // 'class' => 'form-control search-selector',
            // 'data-selector' => 'search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>


    <?php if ($type == RealtyObject::REALTY_OBJECT_TYPE_RENT): ?>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

            <?= $form->field($model, 'trade')->dropDownList(ObjectHelper::tradeList(), [
                'id' => 'search_trade_' . $model->index,
                // 'class' => 'form-control search-selector',
                // 'data-selector' => 'search-selector',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>

        </div>

        <div class="col-md-3 p-r-1">

            <?= $form->field($model, 'release_date_from')->widget(DateTimePicker::class, [
                'readonly' => true,
                'removeButton' => false,
                'pickerIcon' => '<i class="fa fa-calendar"></i>',
                'options' => ['placeholder' => 'с', 'autocomplete' => 'off', 'id' => 'release_date_from_' . $model->index],
                'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
            ])/*->label(false)*/ ?>

        </div>

        <div class="col-md-3 p-l-1">

            <?= $form->field($model, 'release_date_to')->widget(DateTimePicker::class, [
                'readonly' => true,
                'removeButton' => false,
                'pickerIcon' => '<i class="fa fa-calendar"></i>',
                'options' => ['placeholder' => 'по', 'autocomplete' => 'off', 'id' => 'release_date_to_' . $model->index],
                'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
            ])->label('&nbsp;') ?>

        </div>

<!--            </div>-->

<!--        </div>-->
    <?php endif; ?>

</div>


<hr>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'cadastral')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'manager')->dropDownList($managers, [
            'id' => 'search_manager_' . $model->index,
            // 'class' => 'form-control search-selector',
            // 'data-selector' => 'search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'stage')->dropDownList(StageHelper::stageList(), [
            'id' => 'search_stage_' . $model->index,
            // 'class' => 'form-control search-selector',
            // 'data-selector' => 'search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'source')->dropDownList(Adwords::adwordList(), [
            'id' => 'search_source_' . $model->index,
            // 'class' => 'form-control search-selector',
            // 'data-selector' => 'search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>
</div>

<hr>


<div class="text-right">
    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary search_form_btn', 'data-idx' => $model->index]) ?>
    <?= Html::button('Очистить', ['class' => 'btn btn-primary', 'onclick' => 'resetSearchForm("' . $model->index . '")']) ?>
</div>


<?php ActiveForm::end(); ?>
