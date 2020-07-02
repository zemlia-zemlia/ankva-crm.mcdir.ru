<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">




    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
