<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usersite */

$this->title = 'Update Usersite: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usersites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usersite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
