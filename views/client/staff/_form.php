<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\client\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin();

//    var_dump($model);die;
    ?>



    <div class="row">
        <div class="col-lg-3"><?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-3"><?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-3"><?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-3"><?= $form->field($model, 'mobile')->textInput()->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99',
            ]) ?></div>

        <div class="col-lg-3"><?= $form->field($model, 'mobile_dop')->textInput()->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99',
            ]) ?></div>
        <div class="col-lg-3"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>

    </div>
    <div class="row">
        <div class="col-lg-4">


            <?php
           // echo $model->image;

             if($model->image!='')
            {
                echo Html::img('@web/web/'.$model->image, ['class'=>'img-responsive']);
                echo $form->field($model,'del_img')->checkBox(['class'=>'span-1']);
            }else{
                echo Html::img('@web/web/images/avatar-large.jpg', ['class'=>'img-responsive']);

            }
            ?>
            <?= $form->field($model, 'file')->fileInput() ?>


            <?= $form->field($model, 'birthday')->widget(DatePicker::className(),[
                'name' => 'check_issue_date',
                'value' => date('d-M-Y', strtotime('+2 days')),
                'options' => ['placeholder' => 'Выберите дату рождения ...'],
                'pluginOptions' => [
                    'format' => 'dd-M-yyyy',
                    'todayHighlight' => true
                ]
            ]);
            ?>

            <?= $form->field($model, 'passport')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'parent_info')->textarea(['rows' => 6]) ?>



        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'role')->dropDownList(\app\models\Role::getRoleList()) ?>
            <?= $form->field($model, 'office')->dropDownList(\app\models\client\Office::getOfficeList()) ?>


            <?php                  echo $form->field($model,'site_view')->checkBox(['class'=>'span-1']);
            ?>
            <?= $form->field($model, 'site_role')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'site_info', [
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

        </div>
        <div class="col-lg-4">

            <?= $form->field($model, 'status')->dropDownList(\app\models\client\Staff::getStatusList()) ?>
            <div class="form-group"><br>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

        </div>



    </div>



    <?php ActiveForm::end(); ?>

</div>
