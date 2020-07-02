<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
 $this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="articles-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
