<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">



    <?= $this->render('_form', [
        'model' => $model, 'category' => $category, 'manager_added' => $manager_added,
    ]) ?>

</div>
