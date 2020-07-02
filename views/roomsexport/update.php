<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RoomsExport */

$this->title = 'Update Rooms Export: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Rooms Exports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rooms-export-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
