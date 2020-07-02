<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

if (Yii::$app->user->isGuest) {
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
    <section id="intro" class="section">
        <div class="container">
            <div class="row">
<div class="site-signup">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Создание учетной записи откроет для вас все контакты собственников предоставленных на сайте. Вы также сможете добавлять объекты в избранное.
    </p>
    <p>Пожалуйста заполните следующие поля:</p>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Телефон')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+7 (999) 999 99 99',
            ]) ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->label('Придумайте пароль')->passwordInput() ?>
            <?= $form->field($model, 'verifyCode')->label('Проверочный код')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>

            <?= $form->field($model, 'checkbox')->checkbox()->label('Настоящим подтверждаю, что я ознакомлен с условиями  <a href="/site/policy">политики конфиденциальности</a> и даю согласие на обработку моих персональных данных') ;?>

            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?=Html::a('Уже зарегистрированы?', ['site/login']) ?>


            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<? }?>
</div></div></section>