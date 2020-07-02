<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\client\UserSms */

$this->title = 'Update User Sms: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Sms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-sms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
