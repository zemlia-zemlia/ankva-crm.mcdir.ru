<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Black */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="black-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation'=>false,
    ]); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'phone')->textInput()->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+7 (999) 999 99 99','clientOptions' => [
            'removeMaskOnSubmit' => true,
        ]
    ]) ?>
    <?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>


    <?= $form->field($model, 'status')->checkbox() ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
