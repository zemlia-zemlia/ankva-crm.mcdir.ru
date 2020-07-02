<?php


use app\helpers\LocationHelper;
use app\helpers\ObjectHelper;

use vova07\imperavi\Widget;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $form yii\widgets\ActiveForm */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDeleteForm \app\forms\ObjectDeleteForm|null */


?>
<div class="client-form">


    <?php

     $form = ActiveForm::begin();
    if ($model->city_id) $region = $model->region_id;
    else $region = "";

    if ($model->district_id) $city = $model->city_id;
    else $city = "";

//    var_dump($model);die;
    ?>



    <div class="row form-crm">

        <div class="col-lg-4">
            <?= $form->field($model, 'name', [
                'options' => [
                    'class' => 'form-group',
                ],
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->widget(MaskedInput::className(), [
                'options' => [
                    'id' => 'contragent_phone',
                    'class' => 'form-control',
                ],
                'mask' => '+7 (999) 999 99 99',
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'phone_2')->textInput(['maxlength' => true])->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99',
            ])->label('Доп. телефон') ?>

        </div>

    </div>



    <div class="row">

        <div class="col-lg-3">
            <?= $form->field($model, 'region_id')
                ->dropDownList(\app\helpers\LocationHelper::regionList(),
                    ['id' => 'client_region_selector'])  ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'city_id')->dropDownList(\app\helpers\LocationHelper::cityList($region),
                ['id' => 'client_city_selector']) ?>
        </div>
        <div class="col-lg-2">

            <?= $form->field($model, 'district_id')->dropDownList(\app\helpers\LocationHelper::districtList($city),
                ['id' => 'client-district']) ?>



        </div>


            <div class="col-lg-3">

            <?= $form->field($model, 'street')->textInput([
                'id' => 'street_address',
                'data-idx' => '0',
                'maxlength' => true,
//                'disabled' => !$model->city && !$model->street,
            ]) ?>
            </div>
            <div class="col-lg-1">

            <?= $form->field($model, 'home')->textInput([
                'id' => 'house_address',
                'data-idx' => '0',
                'maxlength' => true,
//                'disabled' => !$model->street,
            ]) ?>

            </div>
            <div class="col-lg-4">


</div>
        </div>


    <div class="row">

        <div class="col-lg-2">
            <?= $form->field($model, 'property_type', [
                'options' => [
                    'class' => 'form-group',
                ],
            ])->dropDownList(ObjectHelper::propertyTypeList(1), [
                'id' => 'property_type_list',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?>
            </div>
        <div class="col-lg-2">

            <?= $form->field($model, 'floor')->textInput() ?>
            </div>
        <div class="col-lg-2">

            <?= $form->field($model, 'total_floor')->textInput() ?>

</div>


        <div class="col-lg-2">
            <?= $form->field($model, 'total_area')->textInput()->label('Пл. общая') ?>
</div>
        <div class="col-lg-2">
        <?= $form->field($model, 'living_area', [

            'options' => [
                'id' => 'living_area',
                'class' => 'form-group',

            ]
        ])->textInput()->label('Пл. жилая') ?>
</div>
        <div class="col-lg-2">


        <?= $form->field($model, 'kitchen_area', [

            'options' => [
                'id' => 'kitchen_area',
                'class' => 'form-group',

            ]
        ])->textInput()->label('Пл. кухни') ?>


</div>
        </div>
    <div class="row">

        <div class="col-lg-3">


            <?= $form->field($model, 'price')->textInput() ?>
            <br/>

            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <br><br><br><br>

            <?= $form->field($model, 'removeFoto')->checkbox() ?>

</div>



        <div class="col-lg-9">
            <?= $form->field($model, 'description', [
                'options' => [
                    'class' => '',
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


        </div>




    <div class="row">
        <?php




        echo $form->field($file, 'imageFile[]', ['template' => '{input}'])->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*',
                'multiple'=>true
            ],
    'pluginOptions' => [
//    'uploadUrl' => Url::to(['/client/realty-object/upload']),
        'initialPreview'=> ($model->images) ? json_decode($model->images) : '',
        'initialPreviewAsData'=>true,
//        'showRemove' => false,
        'showUpload' => false,
//        'generateFileId' => true,
//    'initialPreviewShowDelete' => false,
//        'overwriteInitial'=>true,




        ]
        ]);




        ?>



        <?php ActiveForm::end() ?>






    </div>






</div>







