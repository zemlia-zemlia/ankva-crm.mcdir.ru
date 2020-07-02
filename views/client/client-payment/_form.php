<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\client\ClientPayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-payment-form">
    <?php
    $model->client_id = $client_id;
    $model->staff_id = $staff_id;
    $model->status = 1;
    ?>



    <?php $form = ActiveForm::begin(['action' => '/client/client-payment/create/?client_id='.
        $client_id.'&staff_id='.$staff_id]); ?>

    <?= $form->field($model, 'client_id', ['template' => '{input}'])->hiddenInput() ?>


    <?= $form->field($model, 'type')->dropDownList([1 => 'Расчетный счет',2 => 'Кошелек',3 =>'Сайт']) ?>
    <?= $form->field($model, 'staff_id', ['template' => '{input}'])->hiddenInput() ?>



    <?= $form->field($model, 'status', ['template' => '{input}'])->hiddenInput() ?>

    <?= $form->field($model, 'summ')->textInput() ?>


    <?= $form->field($model, 'comment')->textarea() ?>

    <div class="form-group">

        <?= Html::submitButton('Создать платеж', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
