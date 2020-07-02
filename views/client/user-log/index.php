<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\client\UserLogfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="user-log-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProviderLog,
        'filterModel' => $searchModelLog,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',],

//            'id',
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d M Y H:i'],
                'label' => 'Дата',
                'headerOptions' => ['style' => 'text-align: center'],

            ],
//            'user.username',
            'browser',
            'ip',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
