<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

$this->title = 'Тарифы';


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
            background-image: url(http://xn--d1aacodqbkfbc.xn--p1ai/images/b3.svg);border: 2px solid #dfdfdf; border-radius: 10px;

        }
    </style>

 




    <h1>Тарифы пользования сервисом</h1>


        <div class="alert alert-warning">
            <p>
                Оплатить подписку и пополнить счет Вы можете в <?= Html::a('личном кабинете', ['site/account']); ?> <br>
            </p>
        </div>
 
    <div class="shortcode-html">
    <div class="row no-gutters align-items-center">



<div class="col-lg-4 col-md-4">

    <div class="property shadow-hover tariff" style="">
        <div class="property-content">
            <center>  <div class="property-title">
                  <h2>24 часа</h2>
                  <h4>Все регионы РФ, все категории недвижимости</h4>
                  <h4>Выгрузка (Excel, pdf, xls)</h4>

                    <h3>99 руб</h3>
                </div>


        </center>
            <br>

        </div>

    </div>
</div>

    <div class="col-lg-4 col-md-4">

        <div class="property shadow-hover tariff" style="">
            <div class="property-content">
                <center>  <div class="property-title">
                        <h2>1 неделя</h2>
                                      <h4>Все регионы РФ, все категории недвижимости</h4>
                  <h4>Выгрузка (Excel, pdf, xls)</h4>

                        <h3>249 руб</h3>
                        <p> (35 руб в день) </p>
                    </div>
    

                </center>
                <br>

            </div>

        </div>
    </div>


    <div class="col-lg-4 col-md-4">

        <div class="property shadow-hover tariff" style="">
            <div class="property-content">
                <center>  <div class="property-title">
                        <h2>1 месяц</h2>
                                                              <h4>Все регионы РФ, все категории недвижимости</h4>
                  <h4>Выгрузка (Excel, pdf, xls)</h4>
                        <h3>600 руб</h3>
                      <p> (20 руб в день) </p>
                    </div>
  

                </center>
                <br>

            </div>

        </div>
    </div>







</div>
</div>
</section>