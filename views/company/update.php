<?php

use yii\helpers\Html;
use app\controllers\SiteController;
/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = 'Настройки приложения ';

?>
<div class="company-update">


    <?php
    $id_company = Yii::$app->user->identity->id_company;

    $_GET['id'] = Yii::$app->user->identity->id_company;

    //  $id_company_= $model->id;
    if($model->id == $id_company) {


    ?>


    <?= $this->render('_form', [
        'model' => $model, 'id' => Yii::$app->user->identity->id_company,
    ]) ?>



        <?php
    }else {


    }
    ?>


</div>
