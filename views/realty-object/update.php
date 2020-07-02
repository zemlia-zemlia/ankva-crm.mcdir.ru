<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */

$this->title = 'Объект #' . $model->id . ' - редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Мои объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Объект #' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="container">

    <div class="row m-b-4">
        <div class="col-xs-10 col-xs-offset-1">

            <h2 class="m-b-4"><?= Html::encode($this->title) ?></h2>

            <?= $this->render('_form', [
                'model' => $model,
                'managers' => $managers,
                'parserDataProvider' => $parserDataProvider,
                'objectDataProvider' => $objectDataProvider,
            ]) ?>


            <hr>

            <div class="row m-t-2">
                <div class="col-xs-12">

                    <div class="form-group text-right">

                        <?= Html::button($model->id ? 'Сохранить' : 'Добавить', [
                            'id' => 'realty_object_update_form_btn',
                            'class' => 'btn btn-success',
                            'data-action' => '/realty-object/' . Yii::$app->controller->action->id .
                                ($model->copy_id ? ('?copy_id=' . $model->copy_id) : '') . ($model->id ? ('?id=' . $model->id) : ''),
                        ]) ?>

                        <?= Html::button($model->id ? 'Сохранить в архив' : 'Добавить в архив', [
                            'id' => 'realty_object_form_archive_btn',
                            'class' => 'btn btn-warning',
                            'data-action' => Yii::$app->controller->action->id .
                                ($model->copy_id ? ('?copy_id=' . $model->copy_id) : '') . ($model->id ? ('?id=' . $model->id) : ''),
                        ]) ?>

                        <?php if ($model->copy_id): ?>

                            <?= Html::button('Не дозвонились', [
                                'id' => 'room_object_nocall_btn',
                                'class' => 'btn btn-secondary',
                                'data-room_object_id' => $model->copy_id,
                            ]) ?>

                            <?php if (!Yii::$app->user->isGuest): ?>

                                <?= Html::button('В черный список', [
                                    'id' => 'room_object_blacklist_btn',
                                    'class' => 'btn btn-secondary',
                                    'data-room_object_phone' => $model->room_object->phone,
                                ]) ?>

                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                </div>
            </div>


        </div>
    </div>



</div>
