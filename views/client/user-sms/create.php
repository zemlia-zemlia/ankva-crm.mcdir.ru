<?php

use yii\helpers\Html;
use integready\smsc\SMSCenter;
/* @var $this yii\web\View */
/* @var $model app\models\client\UserSms */

$this->title = 'Отправить SMS';
$this->params['breadcrumbs'][] = ['label' => 'SMS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-sms-create">






    <?php






    ?>







    <?= $this->render('_form1', [
        'model' => $model, 'user_id' => $user_id
    ]) ?>


    <?=
    $this->render('index1', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'user_id' => 1
    ])

    ?>




</div>
