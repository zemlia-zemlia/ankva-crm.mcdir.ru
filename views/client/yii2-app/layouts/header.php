<?php
use yii\helpers\Html;
use app\widgets\Company;

/* @var $this \yii\web\View */
/* @var $content string */
?>


<?php// echo Company::widget();?>


<?php
if(!Yii::$app->user->isGuest){

?>
<header class="main-header">
    <?= Html::a('<span class="logo-mini">'.$this->context->crm_name.'</span>'.$this->context->crm_name.'<span class="logo-lg"></span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    <style>.</style>
    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Навигация</span>
        </a>


        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav hidden-xs" >



                <form class="navbar-form navbar-left js-site-v-form " role="search" action="/site/search" autocomplete="off">
                    <div class="input-group">
                        <input type="text" class="form-control" name="v" placeholder="Поиск контакта" value="" autocomplete="off" maxlength="100">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-sm-search favorite-btn"><i class="glyphicon glyphicon-search"></i></button>
                            <button type="button" class="btn btn-default btn-sm-search favorite-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-plus"></i></button>
                            <ul id="w2" class="dropdown-menu dropdown-menu-right nav"><li><a class="js-site-v-form-btn" href="/clientrealty/contract/create?i=13"><i class="fa fa-suitcase"></i> Добавить клиента</a></li>
                                <li><a class="js-site-v-form-btn" href="/blacklist/blacklist/create?i=8"><i class="fa fa-lock"></i> Добавить номер в Черный список</a></li></ul>									</div>
                    </div>
                </form>

                <!-- Messages: style can be found in dropdown.less-->

                <li class=" ">
                    <a href="http://<?=$this->context->url?>"  target="_blank" class="btn btn-default btn-sm-top">
                    Перейти на сайт

                    </a>
                </li>

                <li class="dropdown notifications-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                        page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>



                <!-- Tasks: style can be found in dropdown.less -->

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background-color: #f7f7f7;">


                        <?php if(Yii::$app->user->identity->staff->image!=''){ ?>
                        <?php echo Html::img('@web/web/'.Yii::$app->user->identity->staff->image.'', ['class'=>'user-image']); ?>
                        <?php }else{
                      echo Html::img('@web/web/images/avatar-large.jpg', ['class'=>'user-image']);

                        } ?>
                        <span class="hidden-xs">



                            <?php
                            if (!Yii::$app->user->isGuest) {
                                if (Yii::$app->user->identity->type == 1)
                                    $user = Yii::$app->user->identity->staff;
                                else
                                    $user = Yii::$app->user->identity->client;



                                echo $user->fullName;

                            }

                            ?>



                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <style>.navbar-nav>.user-menu>.dropdown-menu>li.user-header{
                                    height: 60px;
                                }
                            </style>

                            <p>

                                <?php
                                if ((!Yii::$app->user->isGuest) )
                               echo  Yii::$app->user->identity->position->description
                                ?>
<!--                                <small>Member since Nov. 2012</small>-->
                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <?php $login = Yii::$app->user->isGuest ? 'Вход' : 'Выход'; ?>

                            <div class="pull-right">
                                <?= Html::a(
                                    $login,
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>

                </li>
            </ul>
        </div>
    </nav>
</header>

<?php } ?>