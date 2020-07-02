<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Редактирование: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id_post]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="articles-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
