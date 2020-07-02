<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\client\Office */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="office-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'region_id', [
        'options' => [
            'class' => 'form-group',
        ],
    ])->dropDownList(\app\helpers\LocationHelper::regionList(), [
        'id' => 'region_selector',
        'data-idx' => '0',
        'prompt' => [
            'text' => '---',
            'options' => [
                'value' => '',
            ]
        ],
    ]) ?>
    <?php $city_list = \app\helpers\LocationHelper::cityList($model->region_id) ?>
    <?= $form->field($model, 'city_id')->dropDownList($city_list, [
        'id' => 'city_selector',
        'data-idx' => '0',
        'prompt' => [
            'text' => '---',
            'options' => [
                'value' => '',
            ]
        ],
        'disabled' => count($city_list) == 0,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs("

$('#region_selector').on('change', function () {
    var region = $(this).val();
    var city_selector = $('#city_selector');

        if (region !== '') {

        city_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');


        $.get('/location/region-selector-change', { region: region }, function(data) {

            city_selector.html(data.cities);
            if (data.disabled === 0) {
                city_selector.attr('disabled', null);
            }

        }, 'json');
    } else {
        city_selector.attr('disabled', 'disabled');
    }


});





",$position = $this::POS_READY) ?>