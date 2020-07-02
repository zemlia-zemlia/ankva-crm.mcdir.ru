<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */

$this->title = 'Новый объект';
$this->params['breadcrumbs'][] = ['label' => 'Мои объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>






<div class="client-object-create">





            <?= $this->render('_form', [
                'model' => $model,
                'file' => $file




            ]) ?>




</div>






