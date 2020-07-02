<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\client\Office */

$this->title = 'Добавить офис';
$this->params['breadcrumbs'][] = ['label' => 'Офисы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
