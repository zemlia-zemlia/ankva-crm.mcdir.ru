<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\client\Staff */
/* @var $user app\models\User */

$this->title = 'Добавить нового сотрудника';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-create">



    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
