<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usersite */

$this->title = 'Create Usersite';
$this->params['breadcrumbs'][] = ['label' => 'Usersites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usersite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
