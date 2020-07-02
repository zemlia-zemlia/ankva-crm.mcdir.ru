<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Black */

$this->title = 'Добавить номер в черный список';

?>


<div class="black-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
