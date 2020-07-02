<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rooms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rooms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'avito_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_avito')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_company')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'pledge')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'href')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seller')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rooms')->textInput() ?>

    <?= $form->field($model, 'etazh')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'etazhnost')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'metr')->textInput() ?>

    <?= $form->field($model, 'date_add')->textInput() ?>

    <?= $form->field($model, 'actual')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'source')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'yandex_id')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_parametr3')->textInput() ?>

    <?= $form->field($model, 'sale_parametr4')->textInput() ?>

    <?= $form->field($model, 'sale_parametr5')->textInput() ?>

    <?= $form->field($model, 'sale_parametr6')->textInput() ?>

    <?= $form->field($model, 'rent_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_parametr3')->textInput() ?>

    <?= $form->field($model, 'rent_parametr4')->textInput() ?>

    <?= $form->field($model, 'sale_room_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_room_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_room_parametr3')->textInput() ?>

    <?= $form->field($model, 'sale_room_parametr4')->textInput() ?>

    <?= $form->field($model, 'sale_room_parametr5')->textInput() ?>

    <?= $form->field($model, 'sale_room_parametr6')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_room_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_room_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_room_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_room_parametr4')->textInput() ?>

    <?= $form->field($model, 'rent_room_parametr5')->textInput() ?>

    <?= $form->field($model, 'rent_room_parametr6')->textInput() ?>

    <?= $form->field($model, 'rent_room_parametr7')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_home_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_home_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_home_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_home_parametr4')->textInput() ?>

    <?= $form->field($model, 'sale_home_parametr5')->textInput() ?>

    <?= $form->field($model, 'sale_home_parametr6')->textInput() ?>

    <?= $form->field($model, 'sale_home_parametr7')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_home_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_home_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_home_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_home_parametr4')->textInput() ?>

    <?= $form->field($model, 'rent_home_parametr5')->textInput() ?>

    <?= $form->field($model, 'rent_home_parametr6')->textInput() ?>

    <?= $form->field($model, 'rent_home_parametr7')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_home_parametr8')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_land_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_land_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_land_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_land_parametr4')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_land_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_land_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_land_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_land_parametr4')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_garage_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_garage_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_garage_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_garage_parametr4')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_garage_parametr5')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_garage_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_garage_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_garage_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_garage_parametr4')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_garage_parametr5')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_commerc_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_commerc_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_commerc_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_commerc_parametr4')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rent_commerc_parametr5')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_commerc_parametr1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_commerc_parametr2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_commerc_parametr3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_commerc_parametr4')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sale_commerc_parametr5')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dop')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dop2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_id')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'person_type')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'count_ads_same_phone')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'blackagent')->textInput() ?>

    <?= $form->field($model, 'images')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_task')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
