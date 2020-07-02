<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\NewscategoryController;
/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articles-view">





    <?php echo $model->description; ?>



            <hr>
            Категория: <?= \app\controllers\NewscategoryController::categoryTypeName($model->category) ?>
            <br>
            Дата публикации:  <?php echo $model->date; ?>





    <?php
    if(Yii::$app->user->identity->isAdmin=='1'){

    ?>    <p>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы действительно хотите удалить запись?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

    <?php }?>
        </div>
        <!-- /.box-body -->

