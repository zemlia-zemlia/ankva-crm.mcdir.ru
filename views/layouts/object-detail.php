<?php

use app\models\RealtyObject;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var \yii\web\View $this */
/* @var string $content */
?>

<?php
    /** @var RealtyObject $object */
    $object = $this->params['object'];
    $create_log = $object->getCreateLog();
    $last_modify_log = $object->getLastModifyLog();
?>

<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="m-t-2 m-b-4">

    <div class="row">

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="border-right: 1px solid #eee">

            <?= $content ?>

        </div>

        <aside class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

            <div class="bold blue">Добавил:</div>
            <div>
                <?= $create_log ? ($create_log->staff->fullName . ' <br> ' . \Yii::$app->formatter->asTime($create_log->created_at, "php:d F Y H:i" )) : '---' ?>
            </div>

            <div class="bold blue m-t-1">Последние изменения вносил:</div>
            <div>
                <?= $last_modify_log ? ($last_modify_log->staff->fullName . ' <br> ' . \Yii::$app->formatter->asTime($last_modify_log->created_at, "php:d F Y H:i" )) : '---' ?>
            </div>

            <hr>




            <?php if (!$object->isDeleted()): ?>


            <?= Html::button('Обновить актуальность', [
                'id' => 'realty_object_actual_form_btn',
                'class' => 'btn btn-primary btn-block',
                'data-action' => Url::to(['/realty-object/actual', 'id' => $object->id]),
            ]) ?>

            <?php if ($object->inFavorites()): ?>

                <?= Html::button('Удалить из избранного', [
                    'id' => 'realty_object_favorite_form_btn',
                    'class' => 'btn btn-success btn-block',
                    // 'onclick' => 'objectFavorites("' . $object->id . '", "delete")',
                    'data-action' => Url::to(['/realty-object/favorite', 'id' => $object->id, 'action' => 'delete']),
                ]) ?>

            <?php else: ?>

                <?= Html::button('Добавить в избранное', [
                    'id' => 'realty_object_favorite_form_btn',
                    'class' => 'btn btn-success btn-block',
                    // 'onclick' => 'objectFavorite("' . $object->id . '", "add")',
                    'data-action' => Url::to(['/realty-object/favorite', 'id' => $object->id, 'action' => 'add']),
                ]) ?>

            <?php endif; ?>


            <?= Html::button('Редактировать', [
                'id' => 'realty_object_update_form_btn',
                'class' => 'btn btn btn-block',
                'data-action' => Url::to(['/realty-object/view', 'id' => $object->id]),
            ]) ?>

            <?= Html::button('Недоступен', [
                'id' => 'realty_object_unavailable_form_btn',
                'class' => 'btn btn-btn btn-block',
                // 'onclick' => 'objectUnavailable("' . $object->id . '")',
                'data-action' => Url::to(['/realty-object/unavailable', 'id' => $object->id]),
            ]); ?>


            <?php if ($object ->isArchive()): ?>

                <?= Html::button('В актуальные', [
                    'id' => 'realty_object_restore_form_btn',
                    'class' => 'btn btn-warning btn-block',
                    // 'onclick' => 'objectArchive("' . $object->id . '")',
                    'data-action' => Url::to(['/realty-object/restore', 'id' => $object->id]),
                ]); ?>

            <?php else: ?>

                <?= Html::button('В архив', [
                    'id' => 'realty_object_archive_form_btn',
                    'class' => 'btn btn-warning btn-block',
                    // 'onclick' => 'objectArchive("' . $object->id . '")',
                    'data-action' => Url::to(['/realty-object/archive', 'id' => $object->id]),
                ]); ?>

            <?php endif; ?>



            <?= Html::button('Удалить', [
                // 'id' => 'realty_object_delete_form_btn',
                'class' => 'btn btn-danger btn-block',
                'onclick' => 'objectDelete("' . $object->id . '")',
                // 'data-action' => Url::to(['/realty-object/delete', 'id' => $object->id]),
            ]); ?>


            <?php if ($object->inBlacklist()): ?>

                <?= Html::button('Удалить из черн. списка', [
                    'id' => 'realty_object_blacklist_form_btn',
                    'class' => 'btn btn-danger btn-block',
                    // 'onclick' => 'objectFavorites("' . $object->id . '", "delete")',
                    'data-action' => Url::to(['/realty-object/blacklist', 'id' => $object->id, 'action' => 'delete']),
                ]) ?>

            <?php else: ?>

                <?= Html::button('В черный список', [
                    'id' => 'realty_object_blacklist_form_btn',
                    'class' => 'btn btn-danger btn-block',
                    // 'onclick' => 'objectFavorite("' . $object->id . '", "add")',
                    'data-action' => Url::to(['/realty-object/blacklist', 'id' => $object->id, 'action' => 'add']),
                ]) ?>

            <?php endif; ?>

            <?= Html::button('Посмотреть на карте', [
                'class' => 'btn btn-btn btn-block',
                'onclick' => 'objectViewMap("' . $object->id . '")',
            ]); ?>

            <?php endif; ?>


        </aside>

    </div>

</div>

<?php $this->endContent() ?>
