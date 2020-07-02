<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\client\Office */

$this->title = 'Редактировать офис: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Офисы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="office-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
