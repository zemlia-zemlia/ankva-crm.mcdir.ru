<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */

$this->title = 'Новый объект';
$this->params['breadcrumbs'][] = ['label' => 'Объекты недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">

    <div class="row m-b-4">
        <div class="content">

            <?php if ($model->copy_id): ?>

                <div class="m-y-2">
                    <?= Html::a('<i class="fa fa-angle-double-left"></i> назад к списку объектов', '#', ['onclick' => 'goBack(); return false;']) ?>
                </div>

                <h2 class="m-b-2">Объявление: <?= $model->room_object->title ?></h2>

                <div class="m-b-4">
                    <div style="margin-bottom: 10px">
                        Дата подачи: <?= date('d.m.Y H:i', strtotime($model->room_object->date_avito)) ?>
                    </div>
                    <div>
                        Ссылка на объявление:
                <div class="panel-body" style="background-color: #FAFAFA;border-radius: 8px;">
Вы можете попробовать получить дополнительную информацию об этом объявлении - <b><?= Html::a('ссылке', $model->room_object->href, ['target' => '_blank']) ?></b>, если объявление еще не удалено.
</div>    </div>
                </div>




            <?php endif; ?>


            <?= $this->render('_form', [
                'model' => $model,
                'managers' => $managers,
                'parserDataProvider' => $parserDataProvider,
                'objectDataProvider' => $objectDataProvider,
                'objectDeleteForm' => null,
            ]) ?>


            <hr>

            <div class="row m-t-2 parser-menu">
                <div class="col-xs-12">

                    <div class="form-group text-right">

                        <?= Html::button('Добавить', [
                            'id' => 'realty_object_create_form_btn',
                            'class' => 'btn btn-success',
                            'data-action' => '/realty-object/create' . ($model->copy_id ? ('?copy_id=' . $model->copy_id) : ''),
                        ]) ?>

                        <?= Html::button('Добавить в архив', [
                            'id' => 'realty_object_create_archive_form_btn',
                            'class' => 'btn btn-warning',
                            'data-action' => '/realty-object/create' . ($model->copy_id ? ('?copy_id=' . $model->copy_id) : ''),
                        ]) ?>

                        <?php if ($model->copy_id): ?>

                            <?= Html::button('Не доступен', [
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
