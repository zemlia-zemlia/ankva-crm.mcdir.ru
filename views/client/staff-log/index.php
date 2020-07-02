<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModelStaffLog app\models\client\StaffLogSearch */
/* @var $dataProviderStaffLog yii\data\ActiveDataProvider */


?>
<div class="staff-log-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProviderStaffLog,
        'filterModel' => $searchModelStaffLog,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user_id',
            'ip',
//            'url:url',
//            'type',
        [
            'attribute' => 'staff_id',
            'value' => function($data){
                $staff  = \app\models\client\Staff::find()->where(['user_id' => $data->staff_id])->one();
                return ($staff) ? $staff->fullName : '';
            }

        ]
         ,
            [
                'attribute' =>   'created_at',
                'format' =>  ['date', 'php:d M Y H:i'],
            ],

            'data',
//            'cookie',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
