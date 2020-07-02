<?php

use app\assets\MultiSelectAsset;
use app\assets\Select2Asset;
use app\helpers\ObjectHelper;
use app\models\client\Office;
use app\widgets\ActionColumn;
use kartik\dynagrid\DynaGrid;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

use yii\bootstrap\Tabs;


//var_dump($dataProvider);

MultiSelectAsset::register($this);
Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
//    [
//        'class' => CheckboxColumn::class,
//        'order' => DynaGrid::ORDER_FIX_LEFT,
//        'width' => '24px',
//    ],
    [
        'attribute' => 'id',
        'label' => '#ID',
        'width' => '24px',
        'order' => DynaGrid::ORDER_FIX_LEFT,

        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'user.statusName',
        'label' => 'Статус',
        'width' => '84px',
        'format' => 'raw',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'fullName',
        'label' => 'Сотрудник',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => 'raw',
        'value' => function($data){
//    var_dump($data->city->name);die;
            return "<a href='/client/staff/update/?id=".$data->id."'>".$data->fullname."</a><br><span class='user_role'>".$data->roleObj->description."</span>";
        }


    ],
    [
        'attribute' => 'officeName',
        'label' => 'Офис',
        'width' => '54px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'cityName',
        'label' => 'Город',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'class' => ActionColumn::class,
        'order' => DynaGrid::ORDER_FIX_RIGHT,
        'header'=>'Действия',

        'template' => Yii::$app->user->isGuest ? ' {update}   ' :
            ' {update}  ',
        'headerOptions' => ['class' => 'skip-export', 'style' => 'text-align: center; color: #000;'],
        'contentOptions' => [
            'style' => 'white-space: nowrap; text-align: center; width: 50px',
        ],
        'buttons' => [
        'changeStatus' => function ($url, $model, $key) {
            return'<a title="Заблокировать" href="/client/staff/change-status?id='.$model->id.'&status=0">
            <span class="btn btn-action btn-danger"><i class="fa fa-times"></i></span></a>';

        }
        ]


    ],



];
?>
<div class="staff-index">
    <style>
        table th {color:#3c8dbc!important;}

    </style>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить нового сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'rowOptions' =>  function ($model, $key, $index, $grid) {
                return ($model->status) ? ['class' => 'bg-success']: ['class' => 'bg-danger'];
            },
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
