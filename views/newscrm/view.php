<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\CategoryController;
/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости CRM', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articles-view">




    <?php
    if(isset($model->image) && $model->image!=NULL && file_exists(Yii::getAlias('@webroot', $model->image)))
    {
        ?>
        <img src="<?=Yii::getAlias('@web')?>/web/<?=$model->image?>"  >
   <hr>
        <?php


    }
    ?>


    <?php echo $model->message; ?>



            <hr>
            Категория: <?= \app\controllers\TagController::tagTypeName($model->id_tag) ?>
            <br>
            Дата публикации:  <?php echo $model->date; ?>
            <br>




     <?php
     if(Yii::$app->user->identity->isAdminCRM=='1'){
    ?>    <p>
                <?= Html::a('Редактировать', ['update', 'id_post' => $model->id_post], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id_post' => $model->id_post], [
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

