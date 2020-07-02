<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\City;
use app\widgets\ActionColumn;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    [
        'attribute' => 'id',
        'label' => '#ID',
        'width' => '24px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'userObj.created_at',
        'label' => 'Дата',
        'width' => '84px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => ['date', 'php:d M Y H:i'],



    ],



    [
        'attribute' => 'fullName',
        'label' => 'ФИО',
        'width' => '154px',
        'format' => 'raw',
        'headerOptions' => ['style' => 'text-align: center'],
        'value' => function($data){
            $payments = \app\models\client\Client::getPaymentList($data->id);
            if (count($payments) > 0){
                $_status = 1;
                foreach ($payments as $payment) if ($payment->status == 0) $_status = 0;
                if ($_status == 0) $status = '<span style="color:#ffc107">Ожидание платежа</span>';
                else $status = '<span style="color:#0000ee">Платеж проведен</span>';
            }
            if (count($payments) == 0) $status = '<span style="color: #9e0505">Платеж не проведен ?</span>';
            return "<a href='/client/client/update/?id=".$data->id."'>".$data->fullname.
            "</a><br>".$status;
        }


    ],
    [
        'attribute' => 'mobile',
        'label' => 'Телефон',
        'width' => '54px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'cityAndRegion',
        'label' => 'Регион / Город',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],
//        'value' => function($data){
////var_dump($data->cityObj);die;
//            return $data->regionObj->name. ' / '. $data->cityObj->name ;
//        }


    ],
    [
        'attribute' => 'typeproperty',
        'label' => 'Тип недвижимости',
        'width' => '154px',
        'filter' => false,
        'headerOptions' => ['style' => 'text-align: center'],
        'value' => function($data){
            if ($data->typeproperty) {
                $types = \app\models\TypeProperty::getList();
                $str = '';
                $typeAsArray = json_decode($data->typeproperty);
//            var_dump($types, $typeAsArray);die;
                foreach ($typeAsArray as $type) {
//                var_dump($type);die;
                    $str .= $types[$type] . " ";

                }
                return $str;
            }
            else return 'Не задан';
        },
//        'filter' => \app\models\TypeProperty::getList(),


    ],
    [
        'attribute' => 'staffname',
        'label' => 'Ответственный пользователь',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'source',
        'label' => 'Источник',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
    'class' => ActionColumn::class,
    'order' => DynaGrid::ORDER_FIX_RIGHT,
    'header'=>'Действия',
    'template' => Yii::$app->user->isGuest ? '{actual} {inArhive} {update}  {delete} ' :
        '{actual} {inArhive} {update}  {delete} ',
    'headerOptions' => ['class' => 'skip-export',
        'style' => 'text-align: center; color: #000;',
        'width' => '120px'],
    'contentOptions' => ['class' => 'skip-export'],
    'buttons' => [



        'actual' => function ($url, $model, $key) {
            return'<a href="/client/client/change-status?id='.$model->id.'&status=2">
            <span class="btn btn-primary btn-block btn-sm favorite-btn"><i class="glyphicon glyphicon-ok"></i> Заселен</span></a>';

        },
        'inArhive' => function ($url, $model, $key) {
    return'<a href="/client/client/change-status?id='.$model->id.'&status=3">
            <span class="btn btn-primary btn-block btn-sm favorite-btn"><i class="glyphicon glyphicon-download-alt"></i> В архив</span></a>';

}


    ],

],

];


?>
<div class="client-index">

<!---->
<!--    --><?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Все клиенты',
//
                'active' => $active[0],
                'url' => '/client/client',
            ],
            [
                'label' => 'Мои клиенты',
                'url' => '/client/client/my',
                'active' => $active[1],


        ],
        [
            'label' => 'Потенциальные клиенты',
            'url' => '/client/client/pot',
            'active' => $active[2],
        ],
        [
            'label' => 'Заселенные клиенты',
            'url' => '/client/client/success',
            'active' => $active[3],
        ],
            [
                'label' => 'Архив',
                'url' => '/client/client/arhiv',
                'active' => $active[4],
            ],
    ],
]);

    ?>





    <?= DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
//            'showPageSummary' => true,
//            'tableOptions' => [
//                'class' => 'table1 table-striped table-bordered'// test
//            ],
            'rowOptions' =>  function ($model, $key, $index, $grid) {
                return ($model->status) ? ['class' => 'bg-success']: ['class' => 'bg-danger'];
            },

//            'panel'=>[
//
//                'before'=>'{dynagrid}' . Html::a('Custom Button', '#', ['class'=>'btn btn-secondary'])
//            ],
        ],

        'id' => 'staff_dyna_grid',
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => $columns,





        'storage' => DynaGrid::TYPE_COOKIE,
        'options' => [
            'id' => 'staff_dyna_grid',
            'class' => 'm-t-2',
        ],
        'allowPageSetting' => false,
        'allowThemeSetting' => false,
        'allowFilterSetting' => false,
        'allowSortSetting' => false,
        //'theme' => 'panel-default',
    ]); ?>





<!--    --><?php //Pjax::end(); ?>
</div>
