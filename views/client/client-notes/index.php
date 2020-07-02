<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModelNotes app\models\client\ClienNotesSearch */
/* @var $dataProviderNotes yii\data\ActiveDataProvider */

?>

<div class="client-notes-index">



    <div class="row">
        <div class="col-lg-8">

<?php if (!empty($dataProviderNotes->models)){?>

            <?= GridView::widget([
                'dataProvider' => $dataProviderNotes,
                'filterModel' => $searchModelNotes,


                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'staff.username',
                    ['attribute' => 'date', 'format' => ['date', 'php:d-m-Y H:i']],

                    'message:ntext'





                ],
            ]); ?>



<?php }
else echo '<p>Комментариев не найдено.</p>';
?>
        </div>
        <div class="col-lg-4">
            <?php

        $model = new \app\models\client\ClientNotes();
            $model->client_id = $user_id;
            $model->staff_id = Yii::$app->user->id;
            $model->date = time();


        ?>







<?= $this->render('_form', ['client_id' => $user_id, 'model' => $model]);?>
        </div>


    </div>




</div>
