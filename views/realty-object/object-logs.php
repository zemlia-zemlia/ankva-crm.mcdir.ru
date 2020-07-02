<?php

/* @var $this yii\web\View */
/* @var $model \app\models\RealtyObject */
/* @var $operation_logs \app\models\ObjectLog[] */
/* @var $modification_logs \app\models\ObjectLog[] */
?>

<div class="tabbable tabbable-custom">

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_operation" data-toggle="tab" aria-expanded="true">Логи (<?= count($operation_logs) ?>)</a></li>
        <li><a href="#tab_modification" data-toggle="tab" aria-expanded="false">История изменений (<?= count($modification_logs) ?>)</a></li>
    </ul>

    <div class="tab-content">


        <div class="tab-pane active" id="tab_operation">
            <table class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Время</th>
                        <th>Сотрудник</th>
                        <th>Логи</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($operation_logs as $operation_log): ?>

                        <tr>
                            <th><?= '#' . $operation_log->log_id ?></th>
                            <th><?= Yii::$app->formatter->asDatetime($operation_log->created_at, 'short') //date('d M Y H:i', $operation_log->created_at) ?></th>
                            <th><?= $operation_log->staff->fullName ?></th>
                            <th><?= $operation_log->log_description ?></th>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_modification">
            <table class="table table-bordered table-hover dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Время</th>
                    <th>Сотрудник</th>
                    <th>Логи</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($modification_logs as $modification_log): ?>

                    <tr>
                        <th><?= '#' . $modification_log->log_id ?></th>
                        <th><?=Yii::$app->formatter->asDatetime($modification_log->created_at, 'short') //date('d M Y H:i', $modification_log->created_at) ?></th>
                        <th><?= $modification_log->staff->fullName ?></th>
                        <th><?= $modification_log->log_description ?></th>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>
</div>