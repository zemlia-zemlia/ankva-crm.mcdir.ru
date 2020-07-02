<?php

use app\helpers\LocationHelper;
use app\helpers\ObjectHelper;
use app\models\RealtyObject;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $parserDataProvider \yii\data\ActiveDataProvider|null */
/* @var $objectDataProvider \yii\data\ActiveDataProvider|null */
?>

<div id="dublication_info_heading" class="dublication-info-heading">
    <?= 'Совпадения &nbsp;(' . (($parserDataProvider ? $parserDataProvider->count : 0) + ($objectDataProvider ? $objectDataProvider->count : 0)) . ')' ?>
</div>

<div class="collapse" id="dublications">

    <hr>

    <div class="m-y-2">
        Парсер: найдено <?= $parserDataProvider ? $parserDataProvider->count : 0 ?> совп.
    </div>

    <?php if ($parserDataProvider && $parserDataProvider->count > 0): ?>

        <?= GridView::widget([
            'summary' => '',
            'dataProvider' => $parserDataProvider,
            'columns' => [
                [
                    'label' => 'Фото',
                    'headerOptions' => ['style' => 'width: 90px; text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'contentOptions' => ['style' => 'padding: 10px 3px; text-align: center'],
                    'format'=> 'raw',
                    'value' =>  function($data) {
                        $arrImages = explode(',', $data->images);
                        $currentImage = trim( $arrImages[0] );
                        $str = Html::img($currentImage, [
                            'class' => 'view-popup-img img-responsive',
                            'value' => '/rooms/viewpopup?id=' . $data->id,
                            'data-title' => $data->title,
                            'title' => 'Посмотреть',
                            'style' => [
                                'cursor' => 'pointer',
                            ],
                        ]);
                        return $str;
                    }
                ],
                [
                    "attribute" => 'date_avito',
                    'label' => 'Дата',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'format' => ['datetime', 'php:d M Y H:i']
                ],
                [
                    'attribute' => 'type',
                    'label' => 'Тип',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                ],
                [
                    'attribute' => 'addr',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'description',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'format' => 'raw',
                    'value' => function($data) {
                        if ( strlen($data->description) > 400 ) {

                            $tmpDescription = substr($data->description, 0, 400);
                            $lastSpace = strripos($tmpDescription, ' ');
                            $firstDescription = substr($data->description, 0, $lastSpace);
                            return $firstDescription . ' ...';

                        } else {

                            return $data->description;
                        }
                    }
                ],
                // [
                //     'attribute' => 'title',
                //     'headerOptions' => ['style' => 'text-align: center'],
                // ],
                // [
                //     'attribute' => 'price',
                //     'headerOptions' => ['style' => 'text-align: center'],
                // ],
                // [
                //     'attribute' => 'phone',
                //     'headerOptions' => ['style' => 'text-align: center'],
                //     'content'=>function($data){
                //         return "".$data->seller." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>";
                //     }
                // ],
                // [
                //     'attribute' => 'city',
                //     'headerOptions' => ['style' => 'text-align: center'],
                // ],
            ],
        ]); ?>

    <?php endif; ?>

    <hr>

    <div class="m-y-2">
        База: найдено <?= $objectDataProvider ? $objectDataProvider->count : 0 ?> совп.
    </div>


    <?php if ($objectDataProvider && $objectDataProvider->count > 0): ?>

        <?= GridView::widget([
            'summary' => '',
            'dataProvider' => $objectDataProvider,
            'columns' => [
                [
                    'label' => 'Фото',
                    'headerOptions' => ['style' => 'width: 90px; text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'contentOptions' => ['style' => 'padding: 10px 3px; text-align: center'],
                    'format'=> 'raw',
                    'value' =>  function($data) {
                        $arrImages = explode(',', $data->images);
                        $currentImage = trim( $arrImages[0] );
                        $str = Html::img($currentImage, [
                            'class' => 'view-popup-img img-responsive',
                            'value' => '/realty-object/view-modal?id=' . $data->id,
                            'data-title' => 'Объект #' . $data->id,
                            'title' => 'Посмотреть',
                            'style' => [
                                'cursor' => 'pointer',
                            ],
                        ]);
                        return $str;
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Дата',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'format' => ['datetime', 'php:d M Y H:i']
                ],
                [
                    'attribute' => 'type',
                    'label' => 'Тип',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'value' => function(RealtyObject $data) {
                        return ObjectHelper::typeName($data->type);
                    }
                ],
                [
                    'label' => 'Адрес',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'value' => function(RealtyObject $data) {
                        return LocationHelper::regionName($data->region) . ', ' . LocationHelper::cityName($data->city);
                    }
                ],
                [
                    'attribute' => 'description',
                    'headerOptions' => ['style' => 'text-align: center; color: #666; font-size: 12px; font-weight: normal'],
                    'format' => 'raw',
                    'value' => function($data) {
                        if ( strlen($data->description) > 400 ) {

                            $tmpDescription = substr($data->description, 0, 400);
                            $lastSpace = strripos($tmpDescription, ' ');
                            $firstDescription = substr($data->description, 0, $lastSpace);
                            return $firstDescription . ' ...';

                        } else {

                            return $data->description;
                        }
                    }
                ],
                // [
                //     'attribute' => 'price',
                //     'headerOptions' => ['style' => 'text-align: center'],
                // ],
                // [
                //     'attribute' => 'phone',
                //     'headerOptions' => ['style' => 'text-align: center'],
                //     'content'=>function(RealtyObject $data){
                //         return "".$data->name." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>";
                //     }
                // ],
            ],
        ]); ?>

    <?php endif; ?>

</div>
