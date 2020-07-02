<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\client\TypePropertySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="type-property-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'reduced') ?>

    <?= $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'rang') ?>

    <?php // echo $form->field($model, 'name_href') ?>

    <?php // echo $form->field($model, 'name_full') ?>

    <?php // echo $form->field($model, 'id_company') ?>

    <?php // echo $form->field($model, 'feed_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
