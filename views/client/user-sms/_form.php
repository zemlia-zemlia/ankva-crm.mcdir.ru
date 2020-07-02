<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\client\UserSms */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-sms-form">

    <?php $form = ActiveForm::begin(['action' => '/client/user-sms/create/?user_id='.$user_id]); ?>

    <?= $form->field($model, 'user_id', ['template' => '{input}'])->hiddenInput() ?>

    <?= $form->field($model, 'staff_id', ['template' => '{input}'])->hiddenInput() ?>

    <?= $form->field($model, 'number' , ['template' => '{input}'])->hiddenInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message', ['template' => '{input}'])->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date', ['template' => '{input}'])->hiddenInput() ?>

    <?= $form->field($model, 'status', ['template' => '{input}'])->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
