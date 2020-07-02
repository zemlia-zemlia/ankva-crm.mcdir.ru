<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use app\widgets\ActionColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление ролями';
$this->params['breadcrumbs'][] = $this->title;



$columns = [


    [
        'attribute' => 'description',
        'label' => 'Должность',

        'headerOptions' => ['style' => 'text-align: center'],


    ],

    [
        'class' => ActionColumn::class,
        'order' => DynaGrid::ORDER_FIX_RIGHT,
        'header'=>'Действия',

        'template' => Yii::$app->user->isGuest ? '{update}  {delete} ' :
            '  {update}  {delete} ',



    ]


];
?>
<div class="role-index">



    <p>
        <?= Html::a('Добавить роль', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=  DynaGrid::widget([
        'gridOptions' => [
            'dataProvider' => $dataProvider,

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
