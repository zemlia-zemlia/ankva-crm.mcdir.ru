<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
if (Yii::$app->user->isGuest) {

$this->title = 'Вход в личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
    <section id="intro" class="section">
        <div class="container">
            <div class="row">
<div class="site-login">

    <p>Для доступа в личный кабинет, введите ваш логин и пароль.</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->label('Запомнить меня') ?>





    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div></div></div></section>
<?php
}
?>
