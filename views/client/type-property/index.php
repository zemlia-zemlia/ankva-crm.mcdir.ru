<?php

use yii\helpers\Html;
use app\widgets\ActionColumn;
use kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\TypePropertySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы недвижимости';
$this->params['breadcrumbs'][] = $this->title;
$columns = [


    [
        'attribute' => 'name',
        'label' => 'Название',

//        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => 'raw',




    ],
    [
        'attribute' => 'reduced',
        'label' => 'Сокращенно',
//        'width' => '84px',
        'format' => 'raw',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'name_href',
        'label' => 'Винительный падеж',
//        'width' => '84px',
        'format' => 'raw',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'name_full',
        'label' => 'Полное наименование',
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



    ]


];


?>
<div class="type-property-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить тип', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'// test
            ],


        ],

        'id' => 'staff_dyna_grid',

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
    ]); ?>
</div>
