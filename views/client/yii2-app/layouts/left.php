<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->




<?php


if (!Yii::$app->user->isGuest) {
        ?>





        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                     ['label' => 'База объектов', 'icon' => 'building-o', 'url' => '/realty-object',
                    'items' => [
        ['label' => 'Аренда - Жилая',  'url' => '/realty-object',],
        ['label' => 'Продажа - Жилая', 'url' => ['/realty-object#sell_info_tab'],],
        ['label' => 'Аренда - Коммерческая',  'url' => ['/realty-object#rent_commercial_info_tab'],],
        ['label' => 'Продажа - Коммерческая', 'url' => ['/realty-object#sell_commercial_info_tab'],],


                    ],

],
                    ['label' => 'Новые объекты', 'icon' => 'building-o', 'url' => ['/rooms']],

                    ['label' => 'Контакты', 'icon' => 'users', 'url' => ['/client/client']],
                    ['label' => 'Сделки', 'icon' => 'users', 'url' => ['/client/client']],


                    ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/client/client']],
                    ['label' => 'Сотрудники', 'icon' => 'user-o', 'url' => ['/client/staff']],


                    ['label' => 'Черный список', 'icon' => 'circle-o', 'url' => '/black',],
                    ['label' => 'Статистика', 'icon' => 'bar-chart', 'url' => ['/client/staff/stat'],],
                    ['label' => 'Информация', 'icon' => 'bar-chart', 'url' => ['/articles/list'],],
                    [
                        'label' => 'Модули',
                        'icon' => 'pages',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Отправка SMS', 'icon' => 'paper-plane', 'url' => ['/client/user-sms/send-anyone'],],
                            ['label' => 'Экспорт рекламы', 'icon' => 'share', 'url' => ['/client/realty-object'],],


                        ],
                    ],


                    [
                        'label' => 'Сайт',
                        'icon' => 'globe',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Заявки с сайта', 'icon' => 'paper-plane', 'url' => ['/client/role'],],
                            ['label' => 'Новости', 'icon' => 'circle-o', 'url' => ['/news/list'],],
                            ['label' => 'Страницы сайта', 'icon' => 'circle-o', 'url' => ['/sitepages'],],
                            ['label' => 'Отзывы', 'icon' => 'circle-o', 'url' => ['/reviews'],],

                        ],
                    ],

                    [
                        'label' => 'Настройки',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Основные настройки', 'icon' => 'circle-o', 'url' => ['/company/update'],],

                            ['label' => 'Роли пользователей', 'icon' => 'circle-o', 'url' => ['/client/role'],],
                            ['label' => 'Регионы', 'icon' => 'circle-o', 'url' => '/client/list-region',],
                            ['label' => 'Города', 'icon' => 'circle-o', 'url' => '/client/list-city',],
                            ['label' => 'Районы', 'icon' => 'circle-o', 'url' => '/client/list-district',],
                            ['label' => 'Типы недвижимости', 'icon' => 'circle-o', 'url' => '/client/type-property',],
                            ['label' => 'Офисы', 'icon' => 'circle-o', 'url' => '/client/office',],

                            ],
                        ],


                ],
                ]

        ) ; }?>

    </section>

</aside>
