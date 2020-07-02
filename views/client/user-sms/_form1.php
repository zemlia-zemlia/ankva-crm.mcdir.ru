<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\client\UserSms */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-sms-form">
    <?php $form = ActiveForm::begin(['action' => '/client/user-sms/send-anyone']); ?>


    <div class="row">

        <div class="col-lg-6">

            <?= $form->field($model, 'user_id', ['template' => '{input}'])->hiddenInput() ?>

            <?= $form->field($model, 'staff_id', ['template' => '{input}'])->hiddenInput() ?>


            <?= $form->field($model, 'number')->textInput()->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99','clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ]
            ]) ?>
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'date', ['template' => '{input}'])->hiddenInput() ?>

            <?= $form->field($model, 'status', ['template' => '{input}'])->hiddenInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <div class="col-lg-6">




        </div>




    </div>







    <?php ActiveForm::end(); ?>

</div>
