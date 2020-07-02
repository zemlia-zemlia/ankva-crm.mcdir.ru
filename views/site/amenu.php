<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

?>
     <?php

    echo Yii::$app->session->getFlash('success'); ?>

    <div class="col-md-8"><div class="box-style-1 white-bg object-non-visible animated object-visible fadeInUpSmall main-container gray-bg" data-animation-effect="fadeInUpSmall" data-effect-delay="200"><h3>Личный кабинет</h3>

            Ваш ID: <?=$this->context->crm_id?> <br>
            Ваш баланс: <?=$this->context->crm_balance?>  руб. <br>
            Ваш тариф: <?=$this->context->crm_tariff?> <br><br>

            <?= Html::a('Пополнить баланс', ['/site/about'], ['class' => 'btn btn-success btn-sm']); ?>
        <?= Html::a('Продлить подписку', ['site/tariff'] , ['class' => 'btn  btn-sm']); ?>
    </div>

    </div>
    <div class="col-md-4">
        <div class="box-style-1 white-bg object-non-visible animated object-visible fadeInUpSmall main-container gray-bg" data-animation-effect="fadeInUpSmall" data-effect-delay="200">
            <?php

            if($this->context->crm_access_to > time()){
                ?>
                Оплачен до: <?=Yii::$app->formatter->asDate($access_to) ?>
                <?php
            }else { ?>
                <p>
                    У вас закрыт доступ к CRM <br>
                    Выберите тариф или воспользуйтесь <?= Html::a('демо - доступом', ['site/demo']); ?>
                </p>


            <?php }
?>


        </div>

    </div>

</div>


    <?php

NavBar::begin();

$menuItems = [
    ['label' => 'Совершенные платежи', 'url' => ['/site/payments']],
    ['label' => 'Пополнить баланс', 'url' => ['/site/about']],
    ['label' => 'Партнерская программа', 'url' => ['/site/partners']],
    ['label' => 'Техническая поддержка', 'url' => ['/site/users']],
    ['label' => 'Новости CRM', 'url' => ['/newscrm/list']],

];

echo Nav::widget([
    'options' => ['class' => 'nav nav-tabs'],
    'items' => $menuItems,
]);
NavBar::end();

?>
