<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Платежи';
?>

<h1>Совершенные платежи</h1>

    <table class="table table-striped">
        <thead><tr><th>Дата</th><th>Платеж</th><th>Статус</th></tr></thead>
        <tbody>
<? foreach ($payments as $payment){ ?>

    <tr>
        <td><?=$payment->datetime?></td>
        <td><?=$payment->amount?></td>
        <td><?=$payment->notification_type?></td>

    </tr>
    <? } ?>
        </tbody>
    </table>


