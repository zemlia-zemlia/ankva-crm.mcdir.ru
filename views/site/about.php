<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Пополнение баланса';
if (Yii::$app->user->isGuest) {
    //$this->redirect('site/login', 301);
    $form = ActiveForm::begin([
        'action' => 'site/login'
    ]);
}else{
?>

     <div class="container">
        <div class="row">
            <?= $this->render('@app/views/site/amenu'); ?>

            <div class="site-error">

                <h4>Пополнение баланса</h4>
                <h3>Ваш индификатор в системе <?=$this->context->crm_id?></h3>

                <iframe src="https://money.yandex.ru/quickpay/shop-widget?writer=seller&targets=%D0%9F%D0%BE%D0%BF%D0%BE%D0%BB%D0%BD%D0%B5%D0%BD%D0%B8%D1%8F%20%D0%B1%D0%B0%D0%BB%D0%B0%D0%BD%D1%81%D0%B0%20-%20%D0%A1%D0%BA%D0%B0%D0%BD%D0%B5%D1%80%20%D0%BD%D0%B5%D0%B4%D0%B2%D0%B8%D0%B6%D0%B8%D0%BC%D0%BE%D1%81%D1%82%D0%B8&targets-hint=&default-sum=5000&button-text=12&payment-type-choice=on&mobile-payment-type-choice=on&hint=&successURL=&label=<?=$this->context->crm_id?>&quickpay=shop&account=4100115535177507" width="100%" height="250" frameborder="0" allowtransparency="true" scrolling="no"></iframe>


            </div>
            <?php
            //return $this->redirect('site/login', 301);

            } ?>

        </div>
    </div>
