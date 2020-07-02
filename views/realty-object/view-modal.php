<?php

use app\helpers\ObjectHelper;
use app\helpers\StageHelper;
use app\models\Adwords;
use app\models\RealtyObject;
use app\models\User;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model RealtyObject */
?>
    <div class="realty-object-view">

<?    if (Yii::$app->user->identity->access_to >= time()) { ?>


    <?//= DetailView::widget([
    //     'model' => $model,
    //     'template' => function($attribute, $index, $widget) {
    //         if($attribute['value']) {
    //             return "<tr><th>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
    //         }
    //     },
    //     'attributes' => [
    //         'id',
    //         'avito_id',
    //         //            'title',
    //         //            'date_avito',
    //         [
    //             "attribute" => 'date_avito',
    //             'headerOptions' => ['style' => 'text-align: center'],
    //             'format' => ['datetime', 'php:d M Y H:i']
    //         ],
    //         /*[
    //             'attribute' => 'images',
    //             'label' => 'Изображения<br>' . Html::a( 'Скачать', '/rooms/download-images?id=' . $model->id, [ 'title' =>'Скачать', 'style' => 'font-weight: 400;' ]),
    //             'format' => 'raw',
    //             'value' => function($data) {
    //                 $arrImages = explode(',', $data->images);
    //                 $galleryImages = "";
    //                 foreach ($arrImages as $image) {
    //                     $image = trim($image);
    //                     $galleryImages .= "<img src='" . $image . "' style='display: inline-block; width: 80px; margin-right: 5px;'>";
    //                 }
    //                 return $galleryImages;
    //             },
    //         ],*/
    //         [
    //             'attribute' => 'images',
    //             'label' => 'Изображения<br>' . Html::a( 'Скачать', '/rooms/download-images?id=' . $model->id, [ 'title' =>'Скачать', 'style' => 'font-weight: 400;' ]),
    //             'format' => 'raw',
    //             'value' => function($data) {
    //                 $arrImages = explode(',', $data->images);
    //                 $galleryImages = "<div class='rooms-images'>";
    //                 foreach ($arrImages as $image) {
    //                     $image = trim($image);
    //                     $galleryImages .= '<a href="' . $image . '" style="display: inline-block; width: 80px; margin-right: 5px; vertical-align: middle;" rel="alternate"><img src="' . $image . '" ></a>';
    //                 }
    //                 $galleryImages .= '</div>';
    //                 return $galleryImages;
    //             },
    //         ],
    //         'is_company:ntext',
    //         'price',
    //         'pledge:ntext',
    //         'description:ntext',
    //         'href',
    //         'seller',
    //
    //         [
    //             'attribute' => 'phone',
    //             'content'=>function($data){
    //                 return "<a href='tel:+7".$data->phone."'>+7".$data->phone."</a>";
    //
    //
    //
    //             },
    //         ],
    //
    //         'city',
    //         'region',
    //         'addr',
    //         'type',
    //         'type_info',
    //         'rooms',
    //         'etazh:ntext',
    //         'etazhnost:ntext',
    //         'metr',
    //         'date_add',
    //         'actual:ntext',
    //         'source:ntext',
    //         'yandex_id:ntext',
    //         'sale_parametr1:ntext',
    //         'sale_parametr2:ntext',
    //         'sale_parametr3',
    //         'sale_parametr4',
    //         'sale_parametr5',
    //         'sale_parametr6',
    //         'rent_parametr1:ntext',
    //         'rent_parametr2:ntext',
    //         'rent_parametr3',
    //         'rent_parametr4',
    //         'sale_room_parametr1:ntext',
    //         'sale_room_parametr2:ntext',
    //         'sale_room_parametr3',
    //         'sale_room_parametr4',
    //         'sale_room_parametr5',
    //         'sale_room_parametr6:ntext',
    //         'rent_room_parametr1:ntext',
    //         'rent_room_parametr2:ntext',
    //         'rent_room_parametr3:ntext',
    //         'rent_room_parametr4',
    //         'rent_room_parametr5',
    //         'rent_room_parametr6',
    //         'rent_room_parametr7:ntext',
    //         'sale_home_parametr1:ntext',
    //         'sale_home_parametr2:ntext',
    //         'sale_home_parametr3:ntext',
    //         'sale_home_parametr4',
    //         'sale_home_parametr5',
    //         'sale_home_parametr6',
    //         'sale_home_parametr7:ntext',
    //         'rent_home_parametr1:ntext',
    //         'rent_home_parametr2:ntext',
    //         'rent_home_parametr3:ntext',
    //         'rent_home_parametr4',
    //         'rent_home_parametr5',
    //         'rent_home_parametr6',
    //         'rent_home_parametr7:ntext',
    //         'rent_home_parametr8:ntext',
    //         'sale_land_parametr1:ntext',
    //         'sale_land_parametr2:ntext',
    //         'sale_land_parametr3:ntext',
    //         'sale_land_parametr4:ntext',
    //         'rent_land_parametr1:ntext',
    //         'rent_land_parametr2:ntext',
    //         'rent_land_parametr3:ntext',
    //         'rent_land_parametr4:ntext',
    //         'sale_garage_parametr1:ntext',
    //         'sale_garage_parametr2:ntext',
    //         'sale_garage_parametr3:ntext',
    //         'sale_garage_parametr4:ntext',
    //         'sale_garage_parametr5:ntext',
    //         'rent_garage_parametr1:ntext',
    //         'rent_garage_parametr2:ntext',
    //         'rent_garage_parametr3:ntext',
    //         'rent_garage_parametr4:ntext',
    //         'rent_garage_parametr5:ntext',
    //         'rent_commerc_parametr1:ntext',
    //         'rent_commerc_parametr2:ntext',
    //         'rent_commerc_parametr3:ntext',
    //         'rent_commerc_parametr4:ntext',
    //         'rent_commerc_parametr5:ntext',
    //         'sale_commerc_parametr1:ntext',
    //         'sale_commerc_parametr2:ntext',
    //         'sale_commerc_parametr3:ntext',
    //         'sale_commerc_parametr4:ntext',
    //         'sale_commerc_parametr5:ntext',
    //         'dop:ntext',
    //         'dop2:ntext',
    //         'category_id:ntext',
    //         'person_type:ntext',
    //         'count_ads_same_phone:ntext',
    //         'blackagent',
    //         'id_task',
    //     ],
    // ]) ?>

<? }else{
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'template' => function($attribute, $index, $widget) {
            if($attribute['value']) {
                return "<tr><th>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
            }
        },
        'attributes' => array_filter([
            'id',
            [
                'attribute' => 'created_at',
                'headerOptions' => ['style' => 'text-align: center'],
                'value' => function(RealtyObject $data) {
                    return date('d M Y H:i', $data->created_at);
                }
            ],
            [
                // 'attribute' => 'images',
                'label' => 'Изображения',
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

            'description:ntext',
            [
                'attribute' => 'category',
                'value' => ObjectHelper::categoryName($model->category),
            ],
            [
                'attribute' => 'property_type',
                'value' => ObjectHelper::propertyTypeName($model->category, $model->property_type),
            ],

            $model->type == RealtyObject::REALTY_OBJECT_TYPE_RENT ?
            [
                'attribute' => 'trade',
                'value' => $model->trade == '1' ? 'Да' : 'Нет',
            ] :
            false,

            $model->type == RealtyObject::REALTY_OBJECT_TYPE_RENT ?
            [
                'attribute' => 'release_date',
                'label' => 'Освободится',
                'value' => ($model->release && $model->release_date) ? date('d M Y H:i', $model->release_date) : null,
            ] :
            false,

            [
                'attribute' => 'class_building',
                'value' => ObjectHelper::classTypeName($model->class_building),
            ],
            [
                'attribute' => 'type_building',
                'value' => ObjectHelper::buildTypeName($model->type_building),
            ],

            [
                'attribute' => 'repair',
                'value' => ObjectHelper::repairName($model->repair),
            ],


            [
                'attribute' => 'furniture',
                'value' => ObjectHelper::furnitureName($model->furniture),
            ],


            [
                'attribute' => 'address',
                'headerOptions' => ['style' => 'text-align: center'],
                'value' => function(RealtyObject $data) {
                    return $data->getAddress() . ($data->isUnavailable() ? '<span class="badge">НД</span>' : '');
                },
                'format' => 'html',
            ],


            // [
            //     'attribute' => 'region',
            //     'value' => LocationHelper::regionName($model->region),
            // ],


            // [
            //     'attribute' => 'city',
            //     'value' => LocationHelper::cityName($model->city),
            // ],


            // 'district:ntext',

            [
                'attribute' => 'metro_titles',
                // 'value' => LocationHelper::metroName($model->metro, $model->city),
            ],

            'street:ntext',
            'home:ntext',
            'apartment_number:ntext',
            'cadastral:ntext',



            'price',
            'pledge:ntext',

            'floor:ntext',
            'total_floor:ntext',
            'total_area:ntext',
            'living_area:ntext',
            'kitchen_area:ntext',

            [
                'attribute' => 'utility',
                'value' => ObjectHelper::utilityTypeName($model->utility),
            ],














            'name:ntext',
            'phone:ntext',
            'phone_2:ntext',
            'email:ntext',
            'telegram:ntext',
            'whatsapp:ntext',
            'viber:ntext',
            'vk:ntext',
            'service_info:ntext',



            [
                'attribute' => 'manager',
                'value' => function(RealtyObject $data) {
                    return User::getName($data->manager);
                }
            ],

            [
                'attribute' => 'stage',
                'value' => StageHelper::stageName($model->stage),
            ],

            [
                'attribute' => 'source',
                'value' => Adwords::adwordName($model->source),
            ],

            [
                'attribute' => 'call_back',
                'value' => function(RealtyObject $data) {
                    return $data->call_back == 1 ? date('d M Y H:i', $data->call_back_date) : 'Нет';
                }
            ],

        ]),
    ]) ?>




    <?

} ?>

    </div>

<?php

$this->registerJsFile('js/jquery.magnific-popup.min.js', ['depends' => 'yii\web\YiiAsset']);

$openMagnific = <<<JS
    $('.rooms-images').magnificPopup({
        delegate: 'a',
        type:'image',
        gallery:{
            enabled:true,
            preload: [0, 1]
        }
    });
JS;

$this->registerJs($openMagnific);