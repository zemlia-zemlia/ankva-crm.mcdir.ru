<?php

use app\helpers\ObjectHelper;
use yii\helpers\Html;
use app\helpers\LocationHelper;
use app\helpers\StageHelper;
use app\helpers\StrHelper;
use app\models\User;
use app\models\RealtyObject;
use app\models\client\Staff;
/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */
/* @var $logs string */
/* @var $objectDeleteForm \app\forms\ObjectDeleteForm */

$this->title = $model->title ? ' #' . $model->id . ' - ' . $model->title : 'Объект #' . $model->id_c;
$this->params['breadcrumbs'][] = ['label' => 'Объекты недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['object'] = $model->object;
?>
<table width="100%" >
    <tr>
        <td width="50%" >
            <h3 style=""> <?= ObjectHelper::categoryName($model->category) ?>   </h3>
            <h4>
                <?= ObjectHelper::propertyPrintTypeName($model->category, $model->type) ?>
                <?= ObjectHelper::typeNamePrint($model->type) ?>
            </h4> <br>
            <?= LocationHelper::regionName($model->region) ?>
            <br>
            <b> г. <?= LocationHelper::cityName($model->city) ?></b>
            <br>
            <?= $model->street ?>
            <?= $model->home ?>
            <br>
             <?php if(isset($model->district_id)){
                echo '<b>'. LocationHelper::districtName($model->district_id). '</b> — р-он <br>'; } ?>
 <?php  $metro_if = implode(',',$model->metro);


 ?>

            <?php if(isset($metro_if) ){
                 $items_list = '';
                // echo $model->metro;
                 foreach ($model->metro as $item) {
                     if(LocationHelper::cityName($model->city) == 'Санкт-Петербург'){
                         $item2 = \app\models\SpbMetro::find()->where(['id' => $item])->one();
                         $item3 = \app\models\SpbMetroLine::find()->where(['id' => $item2->loc_metro_line_id])->one();
                     }

                     if(LocationHelper::cityName($model->city) == 'Москва'){
                         $item2 = \app\models\MoscowMetro::find()->where(['id' => $item])->one();
                         $item3 = \app\models\MoscowMetroLine::find()->where(['id' => $item2->loc_metro_line_id])->one();
                     }

                     if(LocationHelper::cityName($model->city) != 'Москва' AND LocationHelper::cityName($model->city) != 'Санкт-Петербург'){
                         $item2 = \app\models\MetroStation::find()->where(['id' => $item])->one();
                         $item3->color = $item2->color;
                     }


                    $items_list .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill="'.$item3->color.'" fill-rule="evenodd" d="M11.154 4L8 9.53 4.845 4 1.1 13.466H0v1.428h5.657v-1.428H4.81l.824-2.36L8 15l2.365-3.893.824 2.36h-.85v1.427H16v-1.428h-1.1z"></path></svg> '. $item2->title .'<br>';
                }
                echo $items_list;

            }?>
        </td>
        <td width="50%" style="text-align: right; vertical-align: top;">
            <?php if(isset($this->context->image)){ ?>
                <img class="filestyler__image"  style="width:100px;" src="><?=$this->context->image?>"> <br><br>
            <?php }?>

            <?php if(isset($this->context->name)){ ?>

                <b><?=$this->context->name?> </b> <br>
            <?php  } ?>

            <?php if(isset($this->context->url)){ ?>
                <b><a href="<?=$this->context->url?>"><?=$this->context->url?></a></b> <br>
            <?php  } ?>

            <?php if(isset($this->context->address)){ ?>
                <u><?=$this->context->address?></u> <br>
            <?php  } ?>

            <?php if(isset($this->context->phone)){ ?>
                <?=$this->context->phone?><br>
            <?php  } ?>

            <?php if(isset($model->id_c)){ ?>
                Объект в базе №: <b><?=$model->id_c?></b> <br>
            <?php }?>

            <?php if(isset($model->manager)){ ?>
                <?php  $manager = Staff::find()->where(['id' => $model->manager])->one(); ?>

                Ваш менеджер:     <?= $manager->lastname ?>   <?= $manager->firstname ?> <br>
                <?php if(isset($manager->mobile)){ ?>
                    Телефон:    <?= $manager->mobile ?> <br>
                <?php  } ?>
                <?php if(isset($manager->email)){ ?>
                    <?= $manager->email ?> <br>
                <?php  } ?>

            <?php  } ?>

        </td>
    </tr>
</table>




 <h3> Характеристики: </h3>

<b>Тип недвижимости:</b> <?= ObjectHelper::propertyTypeName($model->category, $model->type) ?> <br>

<?php if(isset($model->repair)){ ?>

<b>Ремонт:</b>                 <?= ObjectHelper::repairName($model->repair) ?> <br>
<?php  } ?>
<?php if(isset($model->furniture)){ ?>

<b>Мебель:</b>                    <?= ObjectHelper::furnitureName($model->furniture) ?> <br>
<?php  } ?>

<?php if(isset($model->total_floor)){ ?>

<b>Этаж:</b>                   <?= $model->floor ?> /  <?= $model->total_floor ?> <br>
<?php  } ?>

<?php if(isset($model->repair)){ ?>

<b>Ремонт:</b>                 <?= ObjectHelper::repairName($model->repair) ?> <br>

<?php  } ?>

<?php if ($model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL): ?>
    <?php if(isset($model->class_building)){ ?>
     <b>Тип жилья:    </b><?= ObjectHelper::classTypeName($model->class_building) ?> <br>
    <?php  } ?>
    <?php if(isset($model->type_building)){ ?>
<b> Тип дома:</b>        <?= ObjectHelper::buildTypeName($model->type_building) ?> <br>
    <?php  } ?>
    <?php if(isset($model->total_area)){ ?>
    <b>  Пл. общая:</b>      <?= $model->total_area?> <br>
    <?php  } ?>
    <?php if(isset($model->living_area)){ ?>
        <b>   Пл. жилая: </b>     <?=$model->living_area ?> <br>
    <?php  } ?>
    <?php if(isset($model->kitchen_area)){ ?>
            <b>  Пл. кухни: </b>     <?=$model->kitchen_area ?> <br>
    <?php  } ?>
<?php else: ?>
    <?php if(isset($model->total_area)){ ?>

    <b>Плошадь общ:</b>                 <?= $model->total_area ?>
    <?php  } ?>

<?php endif; ?>

<h3> Условия: </h3>
<?php if(isset($model->price)){ ?>

    <b>Стоймость:</b>                   <?= $model->price ?>  <br>

<?php  } ?>


<?php if ($model->type == RealtyObject::REALTY_OBJECT_TYPE_RENT): ?>
    <?php if(isset($model->utility)){ ?>

        <b>Коммунальные платежи:</b>                   <?= ObjectHelper::utilityTypeName($model->utility) ?>  <br>

    <?php  } ?>
    <?php if(isset($model->pledge)){ ?>

        <b>Залог:</b>                   <?= $model->pledge ?>  <br>

    <?php  } ?>
<?php else: ?>




<?php endif; ?>




<h3> Описание: </h3>
    <?=$model->description?>


     <?php

    $image_list = '';

    if ($model->images) {

        $images = explode(',', $model->images);

        foreach ($images as $key => $image) {

            $image_list .=
                '<div data-image="' . basename($image) . '" class="filestyler__item filestyler__item_is-image filestyler__item_image-png">
                        <input name="old_images[]" value="' . $image . '" type="hidden">
                        <input type="hidden" class="filestyler__sort-helper" value="' . $key . '">
                   <div class="RealityImgD">  
                        <div class="filestyler__figure element2" style="background-image: url(' . $image . ')">
                            <img class="filestyler__image"  src="' . $image . '">
                        </div> </div>   ' .
                (($model->object && !$model->object->isDeleted()) ?
                    (($model->id ? '<button type="button" class="filestyler__crop"><i class="fa fa-cut"></i></button>' : '') .
                        '<button type="button" class="filestyler__remove"><i class="fa fa-times"></i></button>') : '') .
                // (($model->id && !$model->object->isDeleted()) ? '<button type="button" class="filestyler__crop"><i class="fa fa-cut"></i></button>' : '') .
                // '<button type="button" class="filestyler__remove"><i class="fa fa-times"></i></button>' .
                '</div>';
        }
    }

    ?>


        <div class='filestyler_board_form'>
            <div class='filestyler filestyler_uninitialized filestyler_image'>
                <div class='filestyler__list'>
                    <?= $image_list ?>
                </div>
            </div>
        </div>



</div>

<?php if ($model->object->isDeleted()): ?>

<div class="control-label">Причина удаления</div>

<div class="text-control border-danger m-b-2">
    <?= nl2br($model->object->del_reason) ?>
</div>

<hr>


<?php endif; ?>


