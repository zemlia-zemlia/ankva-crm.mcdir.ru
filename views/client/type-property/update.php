<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TypeProperty */

$this->title = 'Редактировать тип: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'редактировать';
?>
<div class="type-property-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
