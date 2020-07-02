<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RoomsExport */

$this->title = 'Create Rooms Export';
$this->params['breadcrumbs'][] = ['label' => 'Rooms Exports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rooms-export-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
