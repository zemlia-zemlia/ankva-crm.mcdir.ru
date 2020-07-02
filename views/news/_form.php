<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use app\models\NewsCategory;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'description', [
        'options' => [
            'class' => 'form-group m-t-2',
        ],
    ])->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'imageUpload' => Url::to(['images-upload']),
            'imageManagerJson' => Url::to(['/images-get']),
            'plugins' => [
                'table',
                'fontsize',
                'fontcolor',
                'fontfamily',
                'imagemanager',
                'fullscreen',
            ],
        ],
    ]) ?>

    <?= $form->field($model, 'category')->dropDownList(\app\models\NewsCategory::getCategory()) ?>




    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
