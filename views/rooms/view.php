<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rooms */

$this->title = $model->title;

\yii\web\YiiAsset::register($this);
?>


    <section id="intro" class="section">
        <div class="container">
            <div class="row">

<div class="rooms-view">










    <?= DetailView::widget([
        'model' => $model,
        'template' => function($attribute, $index, $widget) {
            if($attribute['value']) {
                return "<tr><th>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
            }
        },
        'attributes' => [
            'id',


            'avito_id',
//            'title',
//            'date_avito',
            [
                "attribute" => 'date_avito',
                'headerOptions' => ['style' => 'text-align: center'],
                'format' => ['datetime', 'php:d M Y H:i']
            ],


            [
                'attribute' => 'images',

                'label' => 'Изображения<br>' . Html::a( 'Скачать', '/rooms/download-images?id=' . $model->id, [ 'title' =>'Скачать', 'style' => 'font-weight: 400;' ]),
                'format' => 'raw',
                'value' => function($data) {
                    $arrImages = explode(',', $data->images);
                    $galleryImages = "<div class='rooms-images'>";
                    foreach ($arrImages as $image) {
                        $image = trim($image);
                        $galleryImages .= '<a href="' . $image . '" style="display: inline-block; width: 80px; margin-right: 5px; vertical-align: middle;" rel="alternate"><img src="' . $image . '" ></a>';
                    }
                    $galleryImages .= '</div>';
                    return $galleryImages;
                },
            ],


            'is_company:ntext',
            'price',
            'pledge:ntext',
            'description:ntext',
            'href',
            'seller',
            'phone',
            'city',
            'region',
            'addr',
            'type',
            'type_info',
            'rooms',
            'etazh:ntext',
            'etazhnost:ntext',

            'metr',
            'date_add',
            'actual:ntext',
            'source:ntext',
            'yandex_id:ntext',
            'sale_parametr1:ntext',
            'sale_parametr2:ntext',
            'sale_parametr3',
            'sale_parametr4',
            'sale_parametr5',
            'sale_parametr6',
            'rent_parametr1:ntext',
            'rent_parametr2:ntext',
            'rent_parametr3',
            'rent_parametr4',
            'sale_room_parametr1:ntext',
            'sale_room_parametr2:ntext',
            'sale_room_parametr3',
            'sale_room_parametr4',
            'sale_room_parametr5',
            'sale_room_parametr6:ntext',
            'rent_room_parametr1:ntext',
            'rent_room_parametr2:ntext',
            'rent_room_parametr3:ntext',
            'rent_room_parametr4',
            'rent_room_parametr5',
            'rent_room_parametr6',
            'rent_room_parametr7:ntext',
            'sale_home_parametr1:ntext',
            'sale_home_parametr2:ntext',
            'sale_home_parametr3:ntext',
            'sale_home_parametr4',
            'sale_home_parametr5',
            'sale_home_parametr6',
            'sale_home_parametr7:ntext',
            'rent_home_parametr1:ntext',
            'rent_home_parametr2:ntext',
            'rent_home_parametr3:ntext',
            'rent_home_parametr4',
            'rent_home_parametr5',
            'rent_home_parametr6',
            'rent_home_parametr7:ntext',
            'rent_home_parametr8:ntext',
            'sale_land_parametr1:ntext',
            'sale_land_parametr2:ntext',
            'sale_land_parametr3:ntext',
            'sale_land_parametr4:ntext',
            'rent_land_parametr1:ntext',
            'rent_land_parametr2:ntext',
            'rent_land_parametr3:ntext',
            'rent_land_parametr4:ntext',
            'sale_garage_parametr1:ntext',
            'sale_garage_parametr2:ntext',
            'sale_garage_parametr3:ntext',
            'sale_garage_parametr4:ntext',
            'sale_garage_parametr5:ntext',
            'rent_garage_parametr1:ntext',
            'rent_garage_parametr2:ntext',
            'rent_garage_parametr3:ntext',
            'rent_garage_parametr4:ntext',
            'rent_garage_parametr5:ntext',
            'rent_commerc_parametr1:ntext',
            'rent_commerc_parametr2:ntext',
            'rent_commerc_parametr3:ntext',
            'rent_commerc_parametr4:ntext',
            'rent_commerc_parametr5:ntext',
            'sale_commerc_parametr1:ntext',
            'sale_commerc_parametr2:ntext',
            'sale_commerc_parametr3:ntext',
            'sale_commerc_parametr4:ntext',
            'sale_commerc_parametr5:ntext',
            'dop:ntext',
            'dop2:ntext',
            'category_id:ntext',
            'person_type:ntext',
            'count_ads_same_phone:ntext',
            'blackagent',
            'id_task',
        ],
    ]) ?>

</div>


<?php
            
$this->registerJsFile('js/jquery.magnific-popup.min.js', ['depends' => 'yii\web\YiiAsset']);
        
$openMagnific = <<<JS
    $('.rooms-images').magnificPopup({
        delegate: 'a',
        type:'image',
        gallery:{
            enabled:true,
            preload: [0, 1],
        }
    });
JS;

$this->registerJs($openMagnific);



?>

</div></div>
</section>
