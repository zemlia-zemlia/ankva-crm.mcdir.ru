<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\client\Client */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username:ntext',
            'auth_key:ntext',
            'password_hash:ntext',
            'password_reset_token:ntext',
            'email:ntext',
            'status',
            'created_at',
            'updated_at',
            'balance',
            'access_from',
            'access_to',
            'demo',
            'id_company',
            'role',
            'mobile',
            'firstname',
            'lastname',
            'middlename',
            'dop_tel',
            'region',
            'district',
            'city_id',
            'typeproperty',
            'price_from',
            'price_to',
            'client_type',
            'staff_id',
            'source',
        ],
    ]) ?>

</div>
