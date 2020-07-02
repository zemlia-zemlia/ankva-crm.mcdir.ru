<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RealtyObjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="realty-object-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'property_type') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'district_id') ?>

    <?php // echo $form->field($model, 'metro') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'home') ?>

    <?php // echo $form->field($model, 'cadastral') ?>

    <?php // echo $form->field($model, 'apartment_number') ?>

    <?php // echo $form->field($model, 'class_building') ?>

    <?php // echo $form->field($model, 'type_building') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'total_floor') ?>

    <?php // echo $form->field($model, 'total_area') ?>

    <?php // echo $form->field($model, 'living_area') ?>

    <?php // echo $form->field($model, 'kitchen_area') ?>

    <?php // echo $form->field($model, 'utility') ?>

    <?php // echo $form->field($model, 'pledge') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'phone_2') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'telegram') ?>

    <?php // echo $form->field($model, 'whatsapp') ?>

    <?php // echo $form->field($model, 'viber') ?>

    <?php // echo $form->field($model, 'vk') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'service_info') ?>

    <?php // echo $form->field($model, 'manager') ?>

    <?php // echo $form->field($model, 'stage') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'call_back_time') ?>

    <?php // echo $form->field($model, 'call_back_date') ?>

    <?php // echo $form->field($model, 'images') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'furniture') ?>

    <?php // echo $form->field($model, 'repair') ?>

    <?php // echo $form->field($model, 'moderate') ?>

    <?php // echo $form->field($model, 'date_added') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <?php // echo $form->field($model, 'manager_added') ?>

    <?php // echo $form->field($model, 'manager_update') ?>

    <?php // echo $form->field($model, 'id_company') ?>

    <?php // echo $form->field($model, 'id_c') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'manager_fixed') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
