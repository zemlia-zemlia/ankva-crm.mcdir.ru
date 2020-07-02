<?php

use yii\helpers\Html;
use integready\smsc\SMSCenter;
/* @var $this yii\web\View */
/* @var $model app\models\client\UserSms */

$this->title = 'Create User Sms';
$this->params['breadcrumbs'][] = ['label' => 'User Sms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-sms-create">





    <?php






    ?>







    <?= $this->render('_form', [
        'model' => $model,
        'client_id' =>$client_id
    ]) ?>

</div>
