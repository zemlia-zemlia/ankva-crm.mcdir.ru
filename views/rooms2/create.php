<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rooms2 */

$this->title = 'Create Rooms2';
$this->params['breadcrumbs'][] = ['label' => 'Rooms2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rooms2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
