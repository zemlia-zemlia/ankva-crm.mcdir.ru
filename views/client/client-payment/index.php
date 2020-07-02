<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\client\ClientPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>



<div class="client-payment-index">



    <div class="row">
        <div class="col-lg-8">





            <?php if (!empty($dataProvider->models)){

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' =>  function ($model, $key, $index, $grid) {
            return ($model->status) ? ['class' => 'bg-success']: ['class' => 'bg-danger'];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//
            ['attribute' => 'date', 'format' => ['date', 'php:d-m-Y H:i']],

            'summ',
            [
                'attribute' => 'type',


                'format' => 'raw',

                'value' => function($data){
                    if ($data->type == 1) return 'Расчетный счет';
                    if ($data->type == 2) return 'Кошелек';
                    if ($data->type == 3) return 'Сайт';

                }


            ],
            'comment',
//            'status',

            [

                'label' => 'Действие',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $grid) {
                    if (Yii::$app->user->can('admin')) {

                        return (!$model->status) ?
                            '<a href="/client/client-payment/change-status/?id=' . $model->id . '&status=' . ($model->status + 1) . '"><span class="btn btn-primary btn-block btn-sm favorite-btn">Изменить статус</span></a>' :
                            "";
                    }
                    else return '';
                }

            ]
        ],
    ]);
            }
            else echo '<p>Платежей не найдено.</p>';
            ?>

</div>

    <div class="col-lg-4">
        <?php
        $model = new \app\models\client\ClientPayment();
//        $model->summ = "";

        ?>




        <?= $this->render('_form', ['client_id' => $client_id, 'staff_id' => $staff_id, 'model' => $model]);?>
    </div>
</div>


</div>

