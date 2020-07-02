<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rooms2 */

$this->title = 'Update Rooms2: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Rooms2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rooms2-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
