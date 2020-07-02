<?php

use yii\helpers\Html;
use app\widgets\ActionColumn;
use kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регионы';
$this->params['breadcrumbs'][] = $this->title;
$columns = [

    [
        'attribute' => 'id',
        'label' => '#ID',
        'width' => '24px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'country_id',
        'label' => 'Страна',
//        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => 'raw',
        'value' => function($data){
             return $data->country->name;
        }


    ],
    [
        'attribute' => 'name',

//        'width' => '84px',
        'format' => 'raw',
        'headerOptions' => ['style' => 'text-align: center'],


    ],

    [
        'class' => ActionColumn::class,
        'order' => DynaGrid::ORDER_FIX_RIGHT,
        'header'=>'Действия',
//        'width' => '54px',
        'template' => Yii::$app->user->isGuest ? '' :
            '  {update}  {delete} ',
//        'headerOptions' => ['class' => 'skip-export', 'style' => 'text-align: center; color: #000;'],
//        'contentOptions' => ['class' => 'skip-export'],


    ]


];
?>


<div class="region-index">




    <p>
        <?= Html::a('Добавить регион', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'tableOptions' => [
                'class' => 'table table-striped table-bordered'// test
            ],

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
//                                    'theme' => 'panel-default',
    ]);

    ?>
</div>
