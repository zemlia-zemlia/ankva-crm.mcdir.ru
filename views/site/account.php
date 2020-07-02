<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;

$this->title = 'Личный кабинет';

if (Yii::$app->user->isGuest) {
   //$this->redirect('site/login', 301);
    $form = ActiveForm::begin([
        'action' => 'site/login'
    ]);
}else{
?>

    <section id="intro" class="section">
        <div class="container">
            <div class="row">

    <?= $this->render('amenu'); ?>



<?
    //return $this->redirect('site/login', 301);

} ?>

</div>
</div>
</section>