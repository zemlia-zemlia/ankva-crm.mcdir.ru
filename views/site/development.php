<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;

$this->title = 'Пользователи';
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


<div class="alert alert-danger">
    <p>
       Приносим свои извинения. Данный раздел находится в стадии разработки. <br> По всем вопросам обращайтесь в техническую поддержку.

    </p>
</div>
<?


    //return $this->redirect('site/login', 301);

} ?>

</div>
</div>
</section>