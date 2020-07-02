<?php

use app\helpers\ObjectHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */
/* @var $logs string */
/* @var $objectDeleteForm \app\forms\ObjectDeleteForm */

$this->title = $model->title ? ' #' . $model->id . ' - ' . $model->title : 'Объект #' . $model->id_c;
$this->params['breadcrumbs'][] = ['label' => 'Объекты недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['object'] = $model->object;
?>

<div class="m-b-4">

    <div class="row flex">
        <div class="col-md-9">
            <div class="text-title"><?= $model->street ? $model->street : 'Объект #' . $model->id_c ?></div>
        </div>
        <div class="col-md-3">
            <?= ObjectHelper::statusLabel($model->object) ?>

            <?php if ($model->object->isUnavailable()): ?>
                <div class="label label-primary" style="margin-top: 2px">Недоступен</div>
            <?php endif; ?>


        </div>
    </div>



</div>

<?php if ($model->object->isDeleted()): ?>

<div class="control-label">Причина удаления</div>

<div class="text-control border-danger m-b-2">
    <?= nl2br($model->object->del_reason) ?>
</div>

<hr>


<?php endif; ?>

<?= $this->render('_form', [
    'model' => $model,
    'managers' => $managers,

    'parserDataProvider' => $parserDataProvider,
    'objectDataProvider' => $objectDataProvider,
    'objectDeleteForm' => $objectDeleteForm,
]) ?>


<hr>

<?= $logs ?>