<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use vova07\imperavi\Widget;
use app\models\Tag;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<?php  if(Yii::$app->user->identity->isAdminCRM=='1'){ ?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>



    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'message', [
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

    <?php
    if(isset($model->image) && file_exists(Yii::getAlias('@webroot', $model->image)))
    {
        echo Html::img('@web/web/'.$model->image, ['class'=>'img-responsive']);
        echo $form->field($model,'del_img')->checkBox(['class'=>'span-1']);
    }
    ?>
    <?= $form->field($model, 'file')->fileInput() ?>


    <?= $form->field($model, 'id_tag')->dropDownList(\app\models\Tag::getTag()) ?>


   <?= $form->field($model, 'activ')->dropDownList([
    '0' => 'Отклонен',
    '1' => 'Активен'
    ])?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php } ?>