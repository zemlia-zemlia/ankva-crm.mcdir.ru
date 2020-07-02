<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\client\ClientNotes */
/* @var $form yii\widgets\ActiveForm */
//var_dump($client_id);die;
?>

<div class="client-notes-form">

    <?php $form = ActiveForm::begin(['action' => '/client/client-notes/create/?client_id='.$client_id]); ?>

    <?= $form->field($model, 'client_id', ['template' => '{input}'])->hiddenInput() ?>

    <?= $form->field($model, 'staff_id', ['template' => '{input}'])->hiddenInput() ?>



    <?= $form->field($model, 'message', ['template' => '{input}'])->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date', ['template' => '{input}'])->hiddenInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
