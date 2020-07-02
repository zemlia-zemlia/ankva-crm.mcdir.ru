<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\client\Staff */

$this->title = 'Редактировать сотрудника: ' . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="staff-update">



    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>







</div>


<div class="staff-log">

    <p><b>Логи авторизации</b></p>
    <?= $this->render('/client/user-log/index', [
        'dataProviderLog' => $dataProviderLog,
        'searchModelLog' => $searchModelLog

    ]) ?>
</div>