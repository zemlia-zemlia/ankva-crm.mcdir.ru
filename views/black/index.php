<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BlackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Черный список';


?>


<div class="black-index">


    <p>
        <?= Html::a('Добавить номер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'date2', 'format' => ['dateTime', 'php:d M Y H:i']],
            'name',
            'description',

             'phone',

            ['class' => 'yii\grid\ActionColumn','template' => '{delete}' ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
