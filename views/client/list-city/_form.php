<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\LocationHelper;

/* @var $this yii\web\View */
/* @var $model app\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region_id')->dropDownList(LocationHelper::regionList(), [
        'id' => 'redion_id',

        'prompt' => [
            'text' => '---',
            'options' => [
                'value' => '',
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
