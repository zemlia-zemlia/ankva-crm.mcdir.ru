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
                        <span class="time"> <i class="pl-10 fa fa-tags"></i><a href=" ?id_tag=<?=$model->id_tag?>"><?= \app\controllers\TagController::tagTypeName($model->id_tag) ?></a></span>

                        <h3 class="timeline-header"><a  href="view?id_post=<?=$model->id_post?>"><?= $model['title'] ?></a> </h3>
                        <?php
                        if(isset($model->image) && $model->image!=NULL && file_exists(Yii::getAlias('@webroot', $model->image)))
                        {
                            ?>
                            <img src="<?=Yii::getAlias('@web')?>/web/<?=$model->image?>" style="width: 170px;">
                     <?php
                         }
                        ?>
                        <div class="timeline-body">
                            <?= \yii\helpers\HtmlPurifier::process(mb_strimwidth($model->message, 0, 200, "..."));?>
                        </div>
                        <div class="timeline-footer">

                            <a class="btn btn-default btn-xs" href="view?id_post=<?=$model->id_post?>">Читать далее</a>

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