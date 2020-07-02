<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\City;

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    [
        'attribute' => 'id',
        'label' => '#ID',
        'width' => '24px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'created_at',
        'label' => 'Дата',
        'width' => '84px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => ['datetime', 'php:d M Y H:i'],

    ],
    [
        'attribute' => 'fullname',
        'label' => 'ФИО',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'mobile',
        'label' => 'Телефон',
        'width' => '54px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'city',
        'label' => 'Регион / Город',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'typeproperty',
        'label' => 'Тип недвижимости',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'staff_id',
        'label' => 'Ответственный пользователь',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'source',
        'label' => 'Источник',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ]

];


?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
//            'panel'=>[
//
//                'before'=>'{dynagrid}' . Html::a('Custom Button', '#', ['class'=>'btn btn-secondary'])
//            ],
        ],

        'id' => 'client_dyna_grid',
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => $columns,

    ]); ?>
    <?php Pjax::end(); ?>
</div>
