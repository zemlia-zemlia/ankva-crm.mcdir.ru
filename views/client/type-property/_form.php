<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TypeProperty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="type-property-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'name', ["template" => "<label> Название </label>{input}"])->textInput() ?>



    <?= $form->field($model, 'reduced', ["template" => "<label> Сокращенно </label>{input}"])->textInput() ?>



    <?= $form->field($model, 'name_href', ["template" => "<label> Винительный падеж </label>{input}"])->textInput() ?>

    <?= $form->field($model, 'name_full', ["template" => "<label> Полное название </label>{input}"])->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
