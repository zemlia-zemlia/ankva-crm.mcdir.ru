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

    <?= $this->render('amenu'); ?>


    <?= $this->render('development'); ?>

<p>
    Если у Вашего АН несколько риэлторов и Вам необходимо пользоваться Сканером Недвижимости, то в целях Вашего удобства и экономии мы рекомендуем, воспользоваться корпоративным доступом.
    <br> <br>
    Все пользователи будут иметь свой личный аккаунт и оплата доступа будет производиться единоразово для созданной корпоративной группы. Причем каждый отдельный пользователь может активировать для себя подписку, не входящую в корпоративную группу, в таком случае, подписки будут суммироваться.
    <hr>
    <div class="table-responsive"><table class="table table-striped"><thead><tr><th>Кол-во пользователей</th><th>Стоимость 1 пользователя</th><th>Ваша экономия</th><th>Скидка</th></tr></thead><tbody><tr><td>2 - 5</td><td>539,1 <i class="fa fa-rub"></i></td><td>120 - 299 <i class="fa fa-rub"></i></td><td>10%</td></tr><tr><td>6 - 10</td><td>509,15 <i class="fa fa-rub"></i></td><td>539 - 898 <i class="fa fa-rub"></i></td><td>15%</td></tr><tr><td>11 - 15</td><td>479,2 <i class="fa fa-rub"></i></td><td>1 317 - 1 797 <i class="fa fa-rub"></i></td><td>20%</td></tr><tr><td>16 - 20</td><td>449,25 <i class="fa fa-rub"></i></td><td>2 396 - 2 995 <i class="fa fa-rub"></i></td><td>25%</td></tr><tr><td>21 - 30</td><td>389,35 <i class="fa fa-rub"></i></td><td>4 402 - 6 290 <i class="fa fa-rub"></i></td><td>35%</td></tr><tr><td>31 - 40</td><td>329,45 <i class="fa fa-rub"></i></td><td>8 356 - 10 782 <i class="fa fa-rub"></i></td><td>45%</td></tr><tr><td>более 40</td><td>269,55 <i class="fa fa-rub"></i></td><td>от 13 500 <i class="fa fa-rub"></i></td><td>55%</td></tr></tbody></table></div>

</p>



<?


    //return $this->redirect('site/login', 301);

} ?>

</div>
</div>
</section>