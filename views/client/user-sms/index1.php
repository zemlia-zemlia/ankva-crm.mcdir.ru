<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\controllers\client\UserSmsController;

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\UserSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */




?>

<div class="user-sms-index">



    <div class="row">
        <div class="col-lg-8">
            <?php if (!empty($dataProvider->models)){?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' =>  function ($model, $key, $index, $grid) {
                    return ($model->status) ? ['class' => 'bg-success']: ['class' => 'bg-danger'];
                },


                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'staff.username',
                        'value' => function($data){
                            return ($data->staff) ? $data->staff->fullName : 'Система';
                        }
                        ],
                    ['attribute' => 'date', 'format' => ['date', 'php:d-m-Y H:i']],
                    'number',
                    'message:ntext',
                    'statusName'
//                    ['attribute' =>  'statusName' , 'filter' => ['Отправлено', 'Доставлено']],



//            ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php }
            else echo '<p>SMS не найдено.</p>';?>


        </div>
        <div class="col-lg-4">

        </div>


    </div>




</div>
