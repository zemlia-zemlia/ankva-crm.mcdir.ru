<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RoomsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rooms-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'avito_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'date_avito') ?>

    <?= $form->field($model, 'is_company') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'pledge') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'href') ?>

    <?php // echo $form->field($model, 'seller') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'addr') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'type_info') ?>

    <?php // echo $form->field($model, 'rooms') ?>

    <?php // echo $form->field($model, 'etazh') ?>

    <?php // echo $form->field($model, 'etazhnost') ?>

    <?php // echo $form->field($model, 'metr') ?>

    <?php // echo $form->field($model, 'date_add') ?>

    <?php // echo $form->field($model, 'actual') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'yandex_id') ?>

    <?php // echo $form->field($model, 'sale_parametr1') ?>

    <?php // echo $form->field($model, 'sale_parametr2') ?>

    <?php // echo $form->field($model, 'sale_parametr3') ?>

    <?php // echo $form->field($model, 'sale_parametr4') ?>

    <?php // echo $form->field($model, 'sale_parametr5') ?>

    <?php // echo $form->field($model, 'sale_parametr6') ?>

    <?php // echo $form->field($model, 'rent_parametr1') ?>

    <?php // echo $form->field($model, 'rent_parametr2') ?>

    <?php // echo $form->field($model, 'rent_parametr3') ?>

    <?php // echo $form->field($model, 'rent_parametr4') ?>

    <?php // echo $form->field($model, 'sale_room_parametr1') ?>

    <?php // echo $form->field($model, 'sale_room_parametr2') ?>

    <?php // echo $form->field($model, 'sale_room_parametr3') ?>

    <?php // echo $form->field($model, 'sale_room_parametr4') ?>

    <?php // echo $form->field($model, 'sale_room_parametr5') ?>

    <?php // echo $form->field($model, 'sale_room_parametr6') ?>

    <?php // echo $form->field($model, 'rent_room_parametr1') ?>

    <?php // echo $form->field($model, 'rent_room_parametr2') ?>

    <?php // echo $form->field($model, 'rent_room_parametr3') ?>

    <?php // echo $form->field($model, 'rent_room_parametr4') ?>

    <?php // echo $form->field($model, 'rent_room_parametr5') ?>

    <?php // echo $form->field($model, 'rent_room_parametr6') ?>

    <?php // echo $form->field($model, 'rent_room_parametr7') ?>

    <?php // echo $form->field($model, 'sale_home_parametr1') ?>

    <?php // echo $form->field($model, 'sale_home_parametr2') ?>

    <?php // echo $form->field($model, 'sale_home_parametr3') ?>

    <?php // echo $form->field($model, 'sale_home_parametr4') ?>

    <?php // echo $form->field($model, 'sale_home_parametr5') ?>

    <?php // echo $form->field($model, 'sale_home_parametr6') ?>

    <?php // echo $form->field($model, 'sale_home_parametr7') ?>

    <?php // echo $form->field($model, 'rent_home_parametr1') ?>

    <?php // echo $form->field($model, 'rent_home_parametr2') ?>

    <?php // echo $form->field($model, 'rent_home_parametr3') ?>

    <?php // echo $form->field($model, 'rent_home_parametr4') ?>

    <?php // echo $form->field($model, 'rent_home_parametr5') ?>

    <?php // echo $form->field($model, 'rent_home_parametr6') ?>

    <?php // echo $form->field($model, 'rent_home_parametr7') ?>

    <?php // echo $form->field($model, 'rent_home_parametr8') ?>

    <?php // echo $form->field($model, 'sale_land_parametr1') ?>

    <?php // echo $form->field($model, 'sale_land_parametr2') ?>

    <?php // echo $form->field($model, 'sale_land_parametr3') ?>

    <?php // echo $form->field($model, 'sale_land_parametr4') ?>

    <?php // echo $form->field($model, 'rent_land_parametr1') ?>

    <?php // echo $form->field($model, 'rent_land_parametr2') ?>

    <?php // echo $form->field($model, 'rent_land_parametr3') ?>

    <?php // echo $form->field($model, 'rent_land_parametr4') ?>

    <?php // echo $form->field($model, 'sale_garage_parametr1') ?>

    <?php // echo $form->field($model, 'sale_garage_parametr2') ?>

    <?php // echo $form->field($model, 'sale_garage_parametr3') ?>

    <?php // echo $form->field($model, 'sale_garage_parametr4') ?>

    <?php // echo $form->field($model, 'sale_garage_parametr5') ?>

    <?php // echo $form->field($model, 'rent_garage_parametr1') ?>

    <?php // echo $form->field($model, 'rent_garage_parametr2') ?>

    <?php // echo $form->field($model, 'rent_garage_parametr3') ?>

    <?php // echo $form->field($model, 'rent_garage_parametr4') ?>

    <?php // echo $form->field($model, 'rent_garage_parametr5') ?>

    <?php // echo $form->field($model, 'rent_commerc_parametr1') ?>

    <?php // echo $form->field($model, 'rent_commerc_parametr2') ?>

    <?php // echo $form->field($model, 'rent_commerc_parametr3') ?>

    <?php // echo $form->field($model, 'rent_commerc_parametr4') ?>

    <?php // echo $form->field($model, 'rent_commerc_parametr5') ?>

    <?php // echo $form->field($model, 'sale_commerc_parametr1') ?>

    <?php // echo $form->field($model, 'sale_commerc_parametr2') ?>

    <?php // echo $form->field($model, 'sale_commerc_parametr3') ?>

    <?php // echo $form->field($model, 'sale_commerc_parametr4') ?>

    <?php // echo $form->field($model, 'sale_commerc_parametr5') ?>

    <?php // echo $form->field($model, 'dop') ?>

    <?php // echo $form->field($model, 'dop2') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'person_type') ?>

    <?php // echo $form->field($model, 'count_ads_same_phone') ?>

    <?php // echo $form->field($model, 'blackagent') ?>

    <?php // echo $form->field($model, 'images') ?>

    <?php // echo $form->field($model, 'id_task') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
