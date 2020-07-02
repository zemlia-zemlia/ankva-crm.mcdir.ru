<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BlackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы клиентов';


?>


<div class="reviews-index">


    <p>
        <?= Html::a('Добавить отзыв', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'date', 'format' => ['dateTime', 'php:d M Y H:i']],
            [
                'label' => 'Отображение на сайте',
                'format' => 'text',
                'value' => function($model) {
                    return $model->status ? 'Включен' : 'Выключен';
                }
            ],

            'name',
            'email',
             'phone',
            'text',

            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
