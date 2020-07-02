<?php

use yii\helpers\Html;
use app\widgets\ActionColumn;
use kartik\dynagrid\DynaGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\OfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Офисы';
$this->params['breadcrumbs'][] = $this->title;

$columns = [

    [
        'attribute' => 'id',
        'label' => '#ID',
        'width' => '24px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'city.name',
        'label' => 'Город',
//        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => 'raw',
        'value' => function($data){
            return $data->city->name;
        }
    

    ],
    [
        'attribute' => 'name',
        'label' => 'Адрес',
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
<div class="office-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить офис', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=  DynaGrid::widget([
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
    ]); ?>
</div>
