<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TypeProperty */

$this->title = 'Добавить тип недвижимости';
$this->params['breadcrumbs'][] = ['label' => 'Типы недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-property-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
