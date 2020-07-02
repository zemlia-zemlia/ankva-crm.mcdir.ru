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




MultiSelectAsset::register($this);
Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
$columns = [
//    [
//        'class' => CheckboxColumn::class,
//        'order' => DynaGrid::ORDER_FIX_LEFT,
//    ],
    [
        'attribute' => 'id',
        'label' => '#ID',
        'width' => '24px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'status',
        'label' => 'Статус',
        'width' => '84px',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => ['datetime', 'php:d M Y H:i'],

    ],
    [
        'attribute' => 'fullname',
        'label' => 'Сотрудник',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'officeName',
        'label' => 'Офис',
        'width' => '54px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],
    [
        'attribute' => 'officeName',
        'label' => 'Город',
        'width' => '154px',
        'headerOptions' => ['style' => 'text-align: center'],


    ],


];
?>
<div class="staff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Staff', ['create'], ['class' => 'btn btn-success']) ?>
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

        'id' => 'staff_dyna_grid',
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => $columns,





        'storage' => DynaGrid::TYPE_COOKIE,
          'options' => [
        'id' => 'deleted_residental_objects_dynagrid',
        'class' => 'm-t-2',
    ],
                                    'allowPageSetting' => false,
                                    'allowThemeSetting' => false,
                                    'allowFilterSetting' => false,
                                    'allowSortSetting' => false,
                                    'theme' => 'panel-primary',
                                ]); ?>
    <?php Pjax::end(); ?>
</div>
