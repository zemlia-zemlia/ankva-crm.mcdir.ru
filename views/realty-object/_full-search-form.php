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
?>

<?php $form = ActiveForm::begin([
    'options' => [
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

    <div class="col-md-3">

        <?= $form->field($model, 'date_from')->widget(DateTimePicker::className(), [
            'readonly' => true,
            'removeButton' => false,
            'pickerIcon' => '<i class="fa fa-calendar"></i>',
            'options' => ['placeholder' => 'с', 'autocomplete' => 'off'],
            'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
        ])->label(false) ?>

    </div>

    <div class="col-md-3">

        <?= $form->field($model, 'date_to')->widget(DateTimePicker::className(), [
            'readonly' => true,
            'removeButton' => false,
            'pickerIcon' => '<i class="fa fa-calendar"></i>',
            'options' => ['placeholder' => 'по', 'autocomplete' => 'off'],
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
            'id' => 'search_region_selector_' . $model->count,
            'class' => 'form-control search-selector',
            'data-idx' => $model->count,
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
            'id' => 'search_city_selector_' . $model->count,
            'class' => 'form-control search-selector',
            'data-idx' => $model->count,
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'districtName')->textInput() ?>
    </div>

    <div id="metro_selector" class="form-group">
        <div class="col-md-3">

            <label class="control-label">
                Метро
            </label>

            <div>

                <select id="search_metro_selector_<?= $model->count ?>" data-idx="<?= $model->count ?>" name="metro[]" multiple="multiple" title="Метро">
                    <?//= LocationHelper::metroList($model->city, $model->metro) ?>
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

</div>

<hr>

<div class="row">

    <div class="col-md-4">
        <?= $form->field($model, 'property_type')->dropDownList(ObjectHelper::propertyTypeList(RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL), [
            'class' => 'form-control search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'repair')->dropDownList(ObjectHelper::repairTypeList(), [
            'class' => 'form-control search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'furniture')->dropDownList(ObjectHelper::furnitureList(), [
            'class' => 'form-control search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>

</div>


<div class="row control-label">
    <div class="col-xs-4">
        Общая площадь
    </div>
</div>

<div class="row">

    <div class="col-xs-3">
        <?= $form->field($model, 'total_area_from')->textInput(['placeholder' => 'с'])->label(false) ?>
    </div>
    <div class="col-xs-3">
        <?= $form->field($model, 'total_area_to')->textInput(['placeholder' => 'по'])->label(false) ?>
    </div>

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


    <div class="col-xs-3">

        <?= $form->field($model, 'floor_from')->textInput(['placeholder' => 'с'])->label(false) ?>

    </div>
    <div class="col-xs-3">

        <?= $form->field($model, 'floor_to')->textInput(['placeholder' => 'по'])->label(false) ?>

    </div>

    <div class="col-xs-3">

        <?= $form->field($model, 'total_floor_from')->textInput(['placeholder' => 'с'])->label(false) ?>

    </div>
    <div class="col-xs-3">

        <?= $form->field($model, 'total_floor_to')->textInput(['placeholder' => 'по'])->label(false) ?>

    </div>
</div>

<hr>

<div class="row control-label">
    <div class="col-xs-6">

        Стоимость

    </div>
    <div class="col-xs-6">

        Залог

    </div>
</div>

<div class="row">

    <div class="col-xs-3">
        <?= $form->field($model, 'price_from')->textInput(['placeholder' => 'с'])->label(false) ?>
    </div>

    <div class="col-xs-3">
        <?= $form->field($model, 'price_to')->textInput(['placeholder' => 'по'])->label(false) ?>
    </div>

    <div class="col-xs-3">
        <?= $form->field($model, 'pledge_from')->textInput(['placeholder' => 'с'])->label(false) ?>
    </div>

    <div class="col-xs-3">
        <?= $form->field($model, 'pledge_to')->textInput(['placeholder' => 'по'])->label(false) ?>
    </div>

</div>


<div class="row">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
        <?= $form->field($model, 'utility')->dropDownList(ObjectHelper::utilityTypeList(), [
            'class' => 'form-control search-selector',
            'prompt' => [
                'text' => '---',
                'options' => [
                    'value' => '',
                ]
            ],
        ]) ?>
    </div>


    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

        <?= $form->field($model, 'trade')->dropDownList(ObjectHelper::tradeList(), [
            'class' => 'form-control search-selector',
            // 'prompt' => [
            //     'text' => '---',
            //     'options' => [
            //         'value' => '',
            //     ]
            // ],
        ]) ?>

    </div>


    <div class="col-xs-6">

        <div class="row control-label">

            <div class="col-xs-12">
                Освобождается
            </div>

        </div>

        <div class="row">

            <div class="col-xs-6">

                <?= $form->field($model, 'release_date_from')->widget(DateTimePicker::className(), [
                    'readonly' => true,
                    'removeButton' => false,
                    'pickerIcon' => '<i class="fa fa-calendar"></i>',
                    'options' => ['placeholder' => 'с', 'autocomplete' => 'off'],
                    'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
                ])->label(false) ?>

            </div>

            <div class="col-xs-6">

                <?= $form->field($model, 'release_date_to')->widget(DateTimePicker::className(), [
                    'readonly' => true,
                    'removeButton' => false,
                    'pickerIcon' => '<i class="fa fa-calendar"></i>',
                    'options' => ['placeholder' => 'по', 'autocomplete' => 'off'],
                    'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true, 'format' => 'dd.mm.yyyy HH:ii'],
                ])->label(false) ?>

            </div>

        </div>

    </div>

</div>


<hr>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'cadastral')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'manager', [
            'options' => [
                'class' => 'form-group',
            ],
        ])->dropDownList($managers, [
            'class' => 'form-control search-selector',
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
            'class' => 'form-control search-selector',
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
            'class' => 'form-control search-selector',
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
    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
</div>


<?php ActiveForm::end(); ?>
