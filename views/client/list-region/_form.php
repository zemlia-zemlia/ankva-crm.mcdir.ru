<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\LocationHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Region */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="region-form">
<div class="col-lg-6">
    <?php $form = ActiveForm::begin(); ?>





    <?= $form->field($model, 'country_id')->dropDownList(LocationHelper::countryList(), [
        'id' => 'country_id',

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
</div>
    <div class="col-lg-6">


    <?php ActiveForm::end(); ?>
</div>
</div>
