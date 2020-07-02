<?php
/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
?>

<div class="realty-object-create">

    <div class="section">
        <div class="row">

            <?= $this->render('_form', [
                'model' => $model,
                'managers' => $managers,
            ]) ?>

        </div>
    </div>

</div>
