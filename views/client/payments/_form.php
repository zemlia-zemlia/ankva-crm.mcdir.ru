<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'operation_id')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'amount')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'withdraw_amount')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'currency')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'datetime')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sender')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_company')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'label')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sha1_hash')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'notification_type')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
