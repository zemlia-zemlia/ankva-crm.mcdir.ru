<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
use app\models\Payments;

use yii\helpers\Html;

$this->title = ' ';
?>
         <div class="container">
            <div class="row">
<?= $this->render('amenu'); ?>
 <h3>Совершенные платежи</h3>

    <table class="table table-striped">
        <thead><tr><th>Дата</th><th>Платеж</th><th>Статус</th></tr></thead>
        <tbody>


<?php

$payments = Payments::find()->where(['id_user' => $this->context->crm_id])->all();

//$payments = Category::find()->where(['=', 'id_company', Yii::$app->user->identity->id_company])->all();

 foreach ($payments as $payment){ ?>

    <tr>
        <td><?=$payment->datetime?></td>
        <td><?=$payment->amount?></td>
        <td><?=$payment->notification_type?></td>

    </tr>
    <?php } ?>
        </tbody>
    </table>


</div>
</div>
</section>