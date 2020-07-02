<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\client\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Платежи клиентов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить платеж', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'id_user',
            'operation_id:ntext',
            'amount:ntext',
//            'withdraw_amount:ntext',
            //'currency:ntext',
            'datetime:ntext',
            //'sender:ntext',
            //'id_company:ntext',
            'label:ntext',
            //'sha1_hash:ntext',
            'notification_type:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
