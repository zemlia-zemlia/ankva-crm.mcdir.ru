<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
        />
    <meta name="yandex-verification" content="3601685f3a8423a9" />
    <meta name="msapplication-tap-highlight" content="no">
    <?php $this->registerCsrfMetaTags() ?>



    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

<style>
    .colorline {
        color: white;
        height: 5px;
        background: repeating-radial-gradient(circle, #
    .colorline {
        color: white;225e9b, #2265a1 10px, #2383c6 10px, #2386c8 20px);    }
</style>
 
</head>


<body>
<!-- Yandex.Metrika counter -->
 
 <!-- /Yandex.Metrika counter -->
    
<div class="main-navigation animated">

    <!-- navbar start -->
    <!-- ================ -->

    <!-- navbar end -->

</div>
<main>


    <? /*
    <header  class="header fixed clearfix">
        <div class="container">
            <div class="main-navigation animated">

            <?php

NavBar::begin([
    'brandLabel' => 'Сканер - Недвижимости',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default',
    ],
]);
?>

                <!-- Responsive Toggle Button -->


<div class="collapse navbar-collapse" id="navBar">

<?
$menuItems = [
    ['label' => 'Главная', 'url' => ['/site/index'], 'options' => ['class' => 'nav-item g-mx-10--lg g-mx-15--xl'],'linkOptions'=>['class'=>'nav-link g-py-7 g-px-0']],
    ['label' => 'Объявления', 'url' => ['/site/index'], 'options' => ['class' => 'nav-item g-mx-10--lg g-mx-15--xl'],'linkOptions'=>['class'=>'nav-link g-py-7 g-px-0']],

     ['label' => 'Контакты', 'url' => ['/site/contact'], 'options' => ['class' => 'nav-item g-mx-10--lg g-mx-15--xl'],'linkOptions'=>['class'=>'nav-link g-py-7 g-px-0']],

];

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup'], 'options' => ['class' => 'nav-item g-mx-10--lg g-mx-15--xl'],'linkOptions'=>['class'=>'nav-link g-py-7 g-px-0']];
    $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login'], 'options' => ['class' => 'nav-item g-mx-10--lg g-mx-15--xl'],'linkOptions'=>['class'=>'nav-link g-py-7 g-px-0']];
} else {
    $menuItems[] = ['label' => 'Избранное', 'url' => ['/site/favorites'], 'options' => ['class' => 'nav-item g-mx-10--lg g-mx-15--xl'],'linkOptions'=>['class'=>'nav-link g-py-7 g-px-0']];
    $menuItems[] = ['label' => 'Личный кабинет', 'url' => ['/site/account'], 'options' => ['class' => 'nav-item g-mx-10--lg g-mx-15--xl'],'linkOptions'=>['class'=>'nav-link g-py-7 g-px-0'],
];


    $menuItems[] = '<li class="nav-item g-mx-10--lg g-mx-15--xl">'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Выход (' . Yii::$app->user->identity->email . ')',
            ['class' => 'btn u-btn-outline-primary g-font-size-13 text-uppercase g-py-10 g-px-15']
        )
        . Html::endForm()
        . '</li>';
}

echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => $menuItems,
]);
?>
</div>
    <?
NavBar::end();
?>
            </div></div>
            </div>
    </header>

 */


 ?>
    <header class="header fixed clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-3">

                    <!-- header-left start -->
                    <!-- ================ -->
                    <div class="header-left clearfix">

                        <!-- logo -->

                        <div class="logo"  >
     <h3><?= Html::a('TestCRM', ['/']) ?></h3>

                        </div>

                        <!-- name-and-slogan -->
                        <div class="site-slogan">

                        </div>

                    </div>
                    <!-- header-left end -->

                </div>
                <div class="col-md-9 h_menu">

                    <!-- header-right start -->
                    <!-- ================ -->
                    <div class="header-right clearfix">

                        <!-- main-navigation start -->
                        <!-- ================ -->
                        <div class="main-navigation animated">

                            <!-- navbar start -->
                            <!-- ================ -->
                            <nav class="navbar navbar-default" role="navigation">
                                <div class="container-fluid">

                                    <!-- Toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                            <span class="sr-only">Навигация</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>




                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                        <ul class="nav navbar-nav navbar-right">
                                            <?= Html::a('База', ['/rooms/'], ['class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical']) ?>
                                            <?= Html::a('Мои объекты', ['/realty-object/'], ['class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical']) ?>
                                        </ul>


                                    </div>

                                </div>
                            </nav>
                            <!-- navbar end -->

                        </div>
                        <!-- main-navigation end -->

                    </div>
                    <!-- header-right end -->

                </div>
            </div>
        </div>
    </header>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
//
//    echo Yii::$app->user->isGuest ?  Html::a(['label' => 'Login', 'url' => ['/site/login']]) :
//        Html::beginForm(['/site/logout'], 'post');
//         Html::submitButton(
//            'Logout (' . Yii::$app->user->username . ')',
//            ['class' => 'btn btn-link logout']
//        );
//         Html::endForm();








       NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();

    ?>



        <div class="container">
            <div class="row">

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>

            </div>
        </div>

        <?= $content ?>
  



    <footer id="footer" class="light">
 

		 
 
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
