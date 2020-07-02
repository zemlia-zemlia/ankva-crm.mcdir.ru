<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\LocationHelper;
use vova07\imperavi\Widget;
/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */

if ($model->city_id) $region = $model->region;
else $region = "";



?>



        <div class="company-form">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <h4>Основные настройки</h4>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'crm_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>


            <h4>Регион работы</h4>

            <?= $form->field($model, 'multiregion')->checkbox() ?>


           <?= $form->field($model, 'region', [
                    'options' => [
                        'class' => 'form-group',
                    ],
                ])->dropDownList(LocationHelper::regionList($region), [
                    'id' => 'client_region_selector',
                    'data-idx' => '0',
                    'prompt' => [
                        'text' => '---',
                        'options' => [
                            'value' => '',
                        ]
                    ],
                ]) ?>

            <?= $form->field($model, 'multirayon')->checkbox() ?>

            <?= $form->field($model, 'city_id')->dropDownList(\app\helpers\LocationHelper::cityList($region),
                    ['id' => 'client_city_selector']) ?>


            <h4>Основные модули</h4>

            <?= $form->field($model, 'residential_rent')->checkbox() ?>

            <?= $form->field($model, 'residential_sale')->checkbox() ?>
            <?= $form->field($model, 'commercial_rent')->checkbox() ?>
            <?= $form->field($model, 'commercial_sale')->checkbox() ?>



            <h4>Интеграции</h4>


            <?= $form->field($model, 'smsc_login')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'smsc_password')->textInput(['maxlength' => true]) ?>

            <h4>Аналитика и счетчики сайта</h4>

            <?= $form->field($model, 'ya_metrika_id')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'go_analitics_id')->textInput(['maxlength' => true]) ?>

            <h4>Чат мессенджеры на сайте</h4>

            <?= $form->field($model, 'jivo_id')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'chatra_id')->textInput(['maxlength' => true]) ?>



            <h4>Водный знак на изображениях объектов</h4>

            <?php
            if(isset($model->image) && file_exists(Yii::getAlias('@webroot', $model->image)))
            {
                echo Html::img('@web/web/'.$model->image, ['class'=>'img-responsive']);
                echo $form->field($model,'del_img')->checkBox(['class'=>'span-1']);
            }
            ?>
            <?= $form->field($model, 'file')->fileInput() ?>



            <h4>Логотип для сайта</h4>

            <?php
            if(isset($model->logo) && file_exists(Yii::getAlias('@webroot', $model->logo)))
            {
                echo Html::img('@web/web/'.$model->logo, ['class'=>'img-responsive']);
                echo $form->field($model,'del_img2')->checkBox(['class'=>'span-1']);
            }
            ?>
            <?= $form->field($model, 'file2')->fileInput() ?>

            <h4>Настройка карточки объекта</h4>

            <?= $form->field($model, 'cadastral')->checkbox() ?>

            <?= $form->field($model, 'service_information')->checkbox() ?>
            <?= $form->field($model, 'responsible')->checkbox() ?>
            <?= $form->field($model, 'additional_contact')->checkbox() ?>


            <h4>Сайт</h4>

            <?= $form->field($model, 'name_site')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'subname_site')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description_site')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'keys_site')->textInput(['maxlength' => true]) ?>

            <h4>Контактная информация на сайте</h4>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'vk')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'whatsapp')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'viber')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>


            <h4>Документы</h4>

            <?= $form->field($model, 'politica', [
                'options' => [
                    'class' => 'form-group m-t-2',
                ],
            ])->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,

                    'plugins' => [
                        'table',
                        'fontsize',
                        'fontcolor',
                        'fontfamily',
                        'imagemanager',
                        'fullscreen',
                    ],
                ],
            ]) ?>

            <?= $form->field($model, 'dogovor', [
                'options' => [
                    'class' => 'form-group m-t-2',
                ],
            ])->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,

                    'plugins' => [
                        'table',
                        'fontsize',
                        'fontcolor',
                        'fontfamily',
                        'imagemanager',
                        'fullscreen',
                    ],
                ],
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>



