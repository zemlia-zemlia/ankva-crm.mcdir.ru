<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usersite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usersite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'auth_key')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'password_hash')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'password_reset_token')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'email')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'balance')->textInput() ?>

    <?= $form->field($model, 'access_from')->textInput() ?>

    <?= $form->field($model, 'access_to')->textInput() ?>

    <?= $form->field($model, 'demo')->textInput() ?>

    <?= $form->field($model, 'id_company')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
