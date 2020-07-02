<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
use app\validators\PhoneValidator;
use app\helpers\LocationHelper;
/* @var $this yii\web\View */
/* @var $model app\models\client\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin();
    if ($model->city_id) $region = $model->region;
    else $region = "";

    if ($model->district) $city = $model->city_id;
    else $city = "";

    if ($model->mobile) $form_disable = '1';
    else $form_disable = "0";
//    var_dump($model);die;
    ?>
<style>
    .form_info{
        background-color: #FFF;
        padding-top: 15px;
        padding-bottom: 15px;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

</style>


    <div class="col-md-12 form_info">
        <div class="col-md-10">

            <h4>Информация о клиенте</h4>





            <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">
        <div class="col-lg-3"><?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-3"><?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-3"><?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?></div>


            <div class="col-lg-3"><?= $form->field($model, 'mobile')->widget(MaskedInput::className(), [
                    'mask' => '+7 (999) 999 99 99',
                ])->textInput() ?></div>





    </div>

            <h4>Параметры поиска</h4>

            <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">
        <div class="col-lg-3"><?= $form->field($model, 'region', [
                'options' => [
                    'class' => 'form-group',
                ],
            ])->dropDownList(LocationHelper::regionList(), [
                'id' => 'client_region_selector',
                'data-idx' => '0',
                'prompt' => [
                    'text' => '---',
                    'options' => [
                        'value' => '',
                    ]
                ],
            ]) ?></div>


        <div class="col-lg-3"><?= $form->field($model, 'city_id')->dropDownList(\app\helpers\LocationHelper::cityList($region),
                ['id' => 'client_city_selector']) ?></div>
        <div class="col-lg-3">
            <?php  echo $form->field($model, 'district')->label(false)->widget(Select2::className(), [
                'data' => \app\helpers\LocationHelper::districtList($city),
                'size' => Select2::LARGE,
                'theme' => Select2::THEME_DEFAULT,

                'options' => [
                    'multiple' => true,

                    'placeholder' => '',
                    'label' => true
                ],
                'pluginOptions' => [
                    'tags' => true
                ]
            ])->label('Район');
            ?>



        </div>



        <div class="col-lg-3"> <?= $form->field($model, 'dop_tel')->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99',
            ])->textInput() ?></div>




    </div>


            <div class="row" style="background-color: #f7f7f7;
   ">


        <style>
           .field-client-typeproperty .input-lg, .field-client-district .input-lg {
               padding: 0;
               font-size: 21px;

           }

            .select2-selection__choice {
                font-size: small;
            }

        </style>



        <div class="col-lg-3">

            <?php  echo $form->field($model, 'typeproperty')->label(false)->widget(Select2::className(), [
                'data' => \app\models\TypeProperty::getList(),
                'size' => Select2::LARGE,
                'theme' => Select2::THEME_DEFAULT,

                'options' => [
                    'multiple' => true,

                    'placeholder' => '',
                    'label' => true
                ],
                'pluginOptions' => [
                    'tags' => true
                ]
            ])->label('Тип недвижимости');
            ?>


        </div>
        <div class="col-lg-2"><?= $form->field($model, 'price_from')->textInput() ?></div>
        <div class="col-lg-2"><?= $form->field($model, 'price_to')->textInput() ?></div>

    </div>

            <h4>Параметры автоподбора</h4>
            <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

                <div class="col-lg-3"><?= $form->field($model, 'parser_bd')->checkbox([
                        'label' => 'Автодобавление из парсера в БД',
                    ]); ?></div>
                <div class="col-lg-3"><?= $form->field($model, 'parser_sms')->checkbox([
                        'label' => 'Автодобавление из парсера в СМС',
                    ]); ?></div>

                <div class="col-lg-3"><?= $form->field($model, 'sms_login')->checkbox([
                        'label' => 'Отправить данные для входа в СМС',
                    ]); ?></div>

<?php
/*
                <?php if($model->sms_login=='1'){ ?>
                    <div class="col-lg-3"><?= $form->field($model, 'sms_login')->checkbox([
                            'label' => 'Отправить данные для входа в СМС',  'disabled' => true
                        ]); ?></div>
                    <?php }else{ ?>
                    <div class="col-lg-3"><?= $form->field($model, 'sms_login')->checkbox([
                            'label' => 'Отправить данные для входа в СМС',
                        ]); ?></div>
                    <?php }?>

*/
?>
            </div>

            <h4>Параметры доступа</h4>
            <div class="row" style="background-color: #f7f7f7;
    padding-top: 10px;
    padding-bottom: 3px;">

            <?php    if (!$model->id){ ?>
                <div class="col-lg-2"><?= $form->field($model, 'access_days')->textInput(['value' => '30']) ?></div>

                <div class="col-lg-2"><?= $form->field($model, 'sms_send')->textInput(['value' => '50']) ?></div>


            <?php }else{ ?>
                <div class="col-lg-2"><?= $form->field($model, 'access_days')->textInput() ?></div>

                <div class="col-lg-2"><?= $form->field($model, 'sms_send')->textInput() ?></div>


            <?php } ?>


                <div class="col-lg-3"><?= $form->field($model, 'status')->dropDownList(\app\models\client\Client::getClientStatus()) ?></div>

                <div class="col-lg-3"><?= $form->field($model, 'client_type')->dropDownList($model->clientTypeName) ?></div>


            </div>

    <div class="row">


<!--        --><?php //var_dump($model);die ?>


        <div class="col-lg-3"><?= $form->field($model, 'staff_id')->dropDownList(\app\models\client\Staff::getList()) ?></div>


        <div class="col-lg-3"><?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-3">  <div class="form-group">
                <br/>
            </div>
        </div>


    </div>
        </div>

        <div class="col-md-2">


        <?= Html::submitButton(' Сохранить', ['class' => 'btn btn-success']) ?>

        </div>

    <?php ActiveForm::end(); ?>
    </div>

    <?php
    $date_registration = $model->date_registration;
    $password_view = $model->password_view;

    if($date_registration){

        $access = $model->access_days;

        $now = $date_registration + (86400*$access);


        $date_actual = Yii::$app->formatter->format($now, 'datetime');

    }


    ?>

    <p>
        <?php
        if($password_view){ ?>
    <div class="callout" style="border-left: 3px solid #3c8dbc;">
        <h4>Данные для входа в личный кабинет</h4>
        Логин: <?=substr(preg_replace('/[^0-9]/', '', $model->mobile), 1)?> <br>
        Пароль: <b><?=$password_view;?></b><br>
        Сайт: <b><a href="http://ankva-site.mcdir.ru/" style="color: #3c8dbc;">ankva-site.mcdir.ru</a> </b>



</div>
<?php      } ?>
     <?php
            if($date_registration){ ?>
    <div class="callout">
               Доступ к сайту до: <?=$date_actual;?>

        <?php if($model->sms){ ?>

           <br>    SMS отправлено: <?=$model->sms;?> / <?=$model->sms_send;?>


        <?php      } ?>
    </div>
            <?php      } ?>

    </p>
</div>
<?php


?>



    <div id="loader"></div>
    <div id="fade"></div>

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
            token: "ce84cf57c3f0608fa62c6cff354ec3ed29c21b1b",
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
            token: "ce84cf57c3f0608fa62c6cff354ec3ed29c21b1b",
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
