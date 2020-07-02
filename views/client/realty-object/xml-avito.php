<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\forms\RealtyObjectForm */
/* @var $managers array */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06">
    <generation-date><?= date('c') ?></generation-date>
<?php foreach ($models as $model){?>
    <!-- Аренда комнаты -->
    <offer internal-id="<?= $model->id ?>">
        <type>аренда</type>
        <property-type>жилая</property-type>
        <category><?= $model->type->xmlName ?></category>
        <creation-date><?= date( 'c' ,$model->created_at) ?></creation-date>
        <location>
            <country>Россия</country>
            <region><?= $model->region->name ?></region>

            <locality-name><?= $model->city->name ?></locality-name>
            <?=
             ($model->district) ? "<sub-locality-name>". $model->district->login ." район</sub-locality-name>" : ""
            ?>

            <address><?= $model->street.' '.$model->home ?></address>
        </location>
        <sales-agent>
            <phone><?=str_replace(')','',str_replace('(','', str_replace(' ', '', $model->phone)))?></phone>


            <name><?= $model->name ?></name>
            <category>владелец</category>
        </sales-agent>

        <price>
            <value><?= $model->price ?></value>
            <currency>RUR</currency>
            <period>месяц</period>
        </price>
        <area>
        <value><?= $model->total_area ?></value>
        <unit>кв. м</unit>
        </area>
        <?php if ($model->type->xmlName == 'комната'){ ?>
        <room-space>
            <value><?= $model->living_area ?></value>
            <unit>кв. м</unit>
            </room-space>
    <rooms-offered>1</rooms-offered>
            <?php } ?>
            <living-space>
                <value><?= $model->living_area ?></value>
                <unit>кв. м</unit>
            </living-space>
            <kitchen-space>
                <value><?= $model->kitchen_area ?></value>
                <unit>кв. м</unit>
            </kitchen-space>

        <?php
         if ($model->images != "[]" && $model->images !='') {

             foreach (json_decode($model->images) as $img){
                 echo '<image>http://ankva-crm.mcdir.ru/' . $img .'</image>';
             }
        }
        ?>

        <description><?= strip_tags($model->description) ?></description>


            <floors-total><?= $model->total_floor ?></floors-total>
            <rooms><?= $model->type->id ?></rooms>

            <floor><?= $model->floor ?></floor>
            <?= ($model->property_type == 6) ? '<studio>true</studio>' : ''?>
    </offer>
<?php } ?>

</realty-feed>






