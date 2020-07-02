<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\District */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="district-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'login')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'citys')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'name_href')->textInput(['rows' => 6]) ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
