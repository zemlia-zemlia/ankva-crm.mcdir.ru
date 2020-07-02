<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Black */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="black-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation'=>false,
    ]); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titlehref')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'content', [
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

     <?= $form->field($model, 'published')->checkbox() ?>

    <h3>SEO настройки</h3>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>




    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
