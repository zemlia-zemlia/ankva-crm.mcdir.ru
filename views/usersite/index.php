<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usersites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usersite-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Usersite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username:ntext',
            'auth_key:ntext',
            'password_hash:ntext',
            'password_reset_token:ntext',
            //'email:ntext',
            //'status',
            //'created_at',
            //'updated_at',
            //'balance',
            //'access_from',
            //'access_to',
            //'demo',
            //'id_company',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
