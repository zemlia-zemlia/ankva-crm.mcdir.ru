<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\client\Staff */

$this->title = 'Статистика сотрудников';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);



echo Tabs::widget([
    'items' => [
        [
            'label' => 'По сотрудникам',
//

            'url' => '/client/staff/stat',
        ],
        [
            'label' => 'По офисам',
            'url' => '#',

            'active' => true,

        ],

    ],
]);







?>






<div class="staff-stat">


    <div style="margin: 20px" class="btn-group btn-group-sm" role="group" aria-label="Выбор периода">
        <button type="button" class="btn btn-secondary"><a href="/client/staff/stat-office?period=86400">Сегодня</a></button>
        <button type="button" class="btn btn-secondary"><a href="/client/staff/stat-office?period=259200">3 дня</a></button>
        <button type="button" class="btn btn-secondary"><a href="/client/staff/stat-office?period=604800">Неделя</a></button>
        <button type="button" class="btn btn-secondary"><a href="/client/staff/stat-office?period=2592000">Месяц</a></button>
        <button type="button" class="btn btn-secondary"><a href="/client/staff/stat-office?period=31536000">Год</a></button>

    </div>

    <div class="row">
        <div class="col-lg-12">
        <p>


            период с <b><?= \Yii::$app->formatter->asTime(time() - $period, "php:d F Y") . '</b> по <b>' . \Yii::$app->formatter->asTime(time() , "php:d F Y") . '</b>' ?>
        </p>

    </div>
    </div>



    <table class="table table-striped table-bordered table-hover">


        <thead>
        <tr>
            <th scope="col" style="padding: 20px;">Офис</th>
            <th scope="col" style="
    padding: 17px;
    background-color: rgba(173, 240, 67, 0.35);
    /* width: 62px; */
">Новые клиенты</th>
            <th scope="col" style="
    padding: 17px;
    background-color: rgba(123, 255, 93, 0.35);
">Редактирование клиентов</th>
            <th scope="col" style="
    background-color: rgba(83, 244, 137, 0.35);
    padding: 17px;
">Добавление платежа</th>
            <th scope="col" style="
    padding: 17px;
    background-color: rgba(70, 164, 229, 0.35);
">Изменение статуса</th>
            <th scope="col" style="
    padding: 17px;
    background-color: rgba(64, 211, 186, 0.35);
">Добавление объектов</th>
        </tr>
        </thead>
        <tbody>



<?php



foreach ($office as $off){

    $staffs =  \app\models\client\Staff::find()->select('user_id')->where(['office' => $off->id])->asArray()->all();
    $staff = [];
    foreach ($staffs as $st) $staff[] = (int)$st['user_id'];

    $newPayment = \app\models\client\StaffLog::find()
        ->where(['type' => 3 ])
        ->andWhere(['in', 'staff_id' , $staff])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();


    $newClient = \app\models\client\StaffLog::find()
        ->where(['type' => 2 ])
        ->andWhere(['in', 'staff_id' , $staff])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();

    $editClient = \app\models\client\StaffLog::find()
        ->where(['type' => 1 ])
        ->andWhere(['in', 'staff_id' , $staff])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();

    $changeStatus = \app\models\client\StaffLog::find()
        ->where(['type' => 6 ])
        ->andWhere(['in', 'staff_id' , $staff])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();

    $addObject = \app\models\ObjectLog::find()
        ->where(['log_description' => 'Добавление объекта' ])
        ->andWhere(['in', 'log_user_id' , $staff])
        ->andWhere([ '>', 'created_at', time() - $period ])
        ->count();

?>

    <tr>
        <td style="padding: 20px;"><?= $off->officeCity . ' / ' . $off->name?></td>
        <td style="padding: 15px;
    background-color: rgba(173, 240, 67, 0.278431);"><?= $newClient ?></td>
        <td style="padding: 15px; background-color: rgba(123, 255, 93, 0.278431);"><?= $editClient  ?></td>
        <td style="padding: 15px; background-color: rgba(83, 244, 137, 0.278431);"><?= $newPayment ?></td>
        <td style="padding: 15px; background-color: rgba(70, 164, 229, 0.278431);"><?=  $changeStatus ?></td>
        <td style="padding: 15px; background-color: rgba(64, 211, 186, 0.278431);"><?=  $addObject ?></td>


    </tr>












    <?php

}





?>



        </tbody>
    </table>




</div>
