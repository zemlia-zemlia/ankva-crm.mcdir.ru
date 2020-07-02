<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

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
    <style>
        .tariff{
            height: 100%;
            background-size: cover;
            background-position: bottom;
            background-size: auto 100px;
            background-repeat: no-repeat;
            background-image: url(https://сканер-недвижимости.рф/images/b3.svg);border: 2px solid #dfdfdf; border-radius: 10px;

        }
    </style>

    <?= $this->render('amenu'); ?>




    <h1>Выберите вариант подписки</h1>

                <?php
                if($this->context->crm_balance=='0'){
      ?>

        <div class="alert alert-warning">
            <p>
                У вас недостаточно денежных средств на вашем  балансе, чтобы воспользоваться подпиской. <br>
                Пополните счет в <?= Html::a('данном разделе', ['site/about']); ?>
            </p>
        </div>
                    <?php
    }
    ?>
    <div class="shortcode-html">
    <div class="row no-gutters align-items-center">

        <div class="" style="opacity: 0;">
            <div class="">
                <center>  <div class="">

                    </div>
                    <?php
                    Modal::begin([
                        'header' => 'Потвердите действие',
                        'toggleButton' => [
                            'label' => 'Выбрать',
                            'tag' => 'button3',
                            'class' => ' ',
                        ],
                        'footer' => 'Оформляя подписку Вы автоматически принимаете публичную оферту пользования интернет-сервисом',
                    ]);




                    echo Html::a('Продлить подписку', ['site/add-balance', 'new'=>'600'], ['class' => 'btn btn-default']);
                    ?>
                    <?php Modal::end(); ?>

                </center>
                <br>

            </div>

        </div>


    <div class="col-lg-4 col-md-4">

        <div class="property shadow-hover tariff" style="">
            <div class="property-content">
                <center>  <div class="property-title">
                        <h2>База</h2>
                        <h4>1 сотрудник</h4>
                        <h4>До 100 объектов</h4>
                        <h4>XML - Выгрузка</h4>

                        <h3>990 руб</h3>
                    </div>
                    <?php
                    Modal::begin([
                        'header' => 'Потвердите действие',
                        'toggleButton' => [
                            'label' => 'Выбрать',
                            'tag' => 'button',
                            'class' => 'btn btn-default',
                        ],
                        'footer' => 'Оформляя подписку Вы автоматически принимаете публичную оферту пользования интернет-сервисом',
                    ]);

                    echo '<h3>Доступ на 1 месяц.</h3>';
                    echo '<h4>1 сотрудник.</h4>';

                    echo '<h4>С основного баланса спишется: 990 руб</h4>';


                    echo Html::a('Продлить подписку', ['site/add-balance', 'new'=>'990'], ['class' => 'btn btn-default']);
                    ?>
                    <?php Modal::end(); ?>

                </center>
                <br>

            </div>

        </div>
    </div>





<?php



    //return $this->redirect('site/login', 301);

} ?>


</div>
</div>
</section>