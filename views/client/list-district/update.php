<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\District */

$this->title = 'Редактировать район: ' . $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Районы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['view', 'id' => $model->login]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="district-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
