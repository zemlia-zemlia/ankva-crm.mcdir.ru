<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Редактирование: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы сайта', 'url' => ['index']];
 $this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="articles-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
