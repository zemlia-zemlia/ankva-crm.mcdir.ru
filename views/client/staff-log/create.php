<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\client\StaffLog */

$this->title = 'Create Staff Log';
$this->params['breadcrumbs'][] = ['label' => 'Staff Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
