<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use app\models\client\Payments;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\client\Client */

$this->title = 'Клиент: ' . $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => ''.$model->fullName.' (ID '.$model->id.')' ];
$this->params['breadcrumbs'][] = 'Информация';

?>
<div class="client-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php




  // Pjax::begin();

    //var_dump($dataProvider);
    echo Tabs::widget([
        'items' => [
            (Yii::$app->user->can('viewClientPayment'))?[
                'label' => 'Платежи (' . $dataProviderPayment->count . ')' ,
//                'url' => '/client/payments',
                'content' => $this->render('/client/client-payment/index', ['searchModel' => $searchModelPayment,
                    'dataProvider' => $dataProviderPayment, 'client_id' => $model->id, 'staff_id' => $model->staff_id]),
                'active' => true
            ]:['label' => 'Платежи',
                'content' => 'Вам запрещен доступ!'
            ],
            [
                'label' => 'Отправленные SMS (' . $dataProvider->count . ')',
                'content' => $this->render('/client/user-sms/index', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, 'user_id' => $model->id, 'mobile' => $model->mobile]),

            ],
            [
                'label' => 'Подходящие объекты (' . $RelatedObjectDataProvider->count . ')',
                'content' => $this->render('/client/client/related_object', ['RelatedObjectSearchModel' => $RelatedObjectSearchModel,
                    'RelatedObjectDataProvider' => $RelatedObjectDataProvider]),
            ],
            [
                'label' => 'Комментарии (' . $dataProviderNotes->count . ')',
                'content' => $this->render('/client/client-notes/index', ['searchModelNotes' => $searchModelNotes,
                    'dataProviderNotes' => $dataProviderNotes, 'user_id' => $model->id]),

            ],
            [
                'label' => 'Авторизации (' . $dataProviderLog->count . ')',
                'content' => $this->render('/client/user-log/index', ['dataProviderLog' => $dataProviderLog,
                    'searchModelLog' => $searchModelLog, 'user_id' => $model->id]),

            ],
            [
                'label' => 'Логи событий (' . $dataProviderStaffLog->count . ')',
                'content' => $this->render('/client/staff-log/index', ['dataProviderStaffLog' => $dataProviderStaffLog,
                    'searchModelStaffLog' => $searchModelStaffLog, 'user_id' => $model->id]),

            ],

        ],
    ]);


 //  Pjax::end();


    ?>


</div>
