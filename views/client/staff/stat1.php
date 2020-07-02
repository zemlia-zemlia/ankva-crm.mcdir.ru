<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\client\Staff */

//$this->title = $staff->id;
//$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="staff-stat">

<div class="row">

    <div class="col-lg-2">Менеджер</div>
    <div class="col-lg-2">Новые клиенты</div>
    <div class="col-lg-2">Редактирование клиентов</div>
    <div class="col-lg-2">Добавление платежа</div>
    <div class="col-lg-2">Изменение статуса</div>
    <div class="col-lg-2">Добавление объекта</div>
</div>
<?php

$period = 3600;

foreach ($staff as $st){

    $newPayment = \app\models\client\StaffLog::find()
        ->where(['type' => 2 ])
        ->andWhere(['staff_id' => $st->user_id])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();



    $newClient = \app\models\client\StaffLog::find()
        ->where(['type' => 2 ])
        ->andWhere(['staff_id' => $st->user_id])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();

    $editClient = \app\models\client\StaffLog::find()
        ->where(['type' => 2 ])
        ->andWhere(['staff_id' => $st->user_id])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();

    $changeStatus = \app\models\client\StaffLog::find()
        ->where(['type' => 2 ])
        ->andWhere(['staff_id' => $st->user_id])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();

?>
    <div class="row">

    <div class="col-lg-2"><?= $st->fullName ?></div>
    <div class="col-lg-2"><?= $newClient ?></div>
    <div class="col-lg-2"><?= $editClient  ?></div>
    <div class="col-lg-2"><?= $newPayment ?></div>
    <div class="col-lg-2"><?=  $changeStatus ?></div>
    <div class="col-lg-2"></div>


</div>








    <?php
}





?>








</div>
