<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\client\ClientPayment */

$this->title = 'Create Client Payment';
$this->params['breadcrumbs'][] = ['label' => 'Client Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
