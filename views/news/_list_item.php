<?

use yii\helpers\Html;

?>



<section class="content">

    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <ul class="timeline">
                <!-- timeline time label -->
                <li class="time-label">
                  <span class="bg-gray">
                      <?php echo Yii::$app->formatter->format($model['date'], 'datetime');  ?>

                  </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-envelope bg-gray"></i>

                    <div class="timeline-item">
                        <span class="time"> <i class="pl-10 fa fa-tags"></i><a href=" ?id_category=<?=$model->category?>"><?= \app\controllers\NewscategoryController::categoryTypeName($model->category) ?></a></span>

                        <h3 class="timeline-header"><a  href="view?id=<?=$model->id?>"><?= $model['title'] ?></a> </h3>

                        <div class="timeline-body">
                            <?= \yii\helpers\HtmlPurifier::process(mb_strimwidth($model->description, 0, 200, "..."));?>
                        </div>
                        <div class="timeline-footer">

                            <a class="btn btn-default btn-xs" href="view?id=<?=$model->id?>">Читать далее</a>

                        </div>
                    </div>
                </li>

            </ul>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


    <!-- /.row -->

</section>