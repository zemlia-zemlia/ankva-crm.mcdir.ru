<?php
use app\assets\MultiSelectAsset;
use app\assets\Select2Asset;
use app\helpers\ObjectHelper;
use app\models\RealtyObject;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $RealtyObjectSearchModel app\models\client\UserSmsSearch */
/* @var $RealtyObjectDataProvider yii\data\ActiveDataProvider */

$columns = [

    [
        'attribute'=> 'id',
        'label'=> 'ID',

        'value' => function (RealtyObject $data) {
            return '#' . $data->id;
        },

    ],
//
    [
        'attribute' => 'actual_date',
        'label' => 'Дата',

        'headerOptions' => ['style' => 'text-align: center'],
        'format' => ['datetime', 'php:d M Y H:i'],

    ],
    [
        'attribute' => 'districtName',
    ],

    [
        'attribute' => 'property_type',
        'label' => 'Тип',
        'filter' => ObjectHelper::propertyTypeList(RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL),
        'value' => function (RealtyObject $data) {
            return ObjectHelper::propertyTypeName($data->category, $data->property_type);
        },
    ],
    [
        'attribute' => 'phone',
        'label' => 'Тел.',
        'headerOptions' => ['style' => 'text-align: center'],
        'value' => function(RealtyObject $data) {
            return $data->name . (1 ? ('<br><a href="tel:+7' . $data->phone . '">+7' . $data->phone . '</a>') :
                ('<div id="user_phone_btn_' . $data->id . '">' . Html::button('Показать номер', [
                        'class' => 'badge skip-export',
                        'style' => 'margin-left: 0; margin-top: 10px',
                        'onclick' => 'showPhone("' . $data->id . '")',
                    ]))) . '</div>' .
            '<div id="user_phone_' . $data->id . '" style="display: none"><a href="tel:+7' . $data->phone . '">+7' . $data->phone . '</a></div>';
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'address',
        'headerOptions' => ['style' => 'min-width: 100px; text-align: center'],
        'value' => function(RealtyObject $data) {
            return $data->getAddress() .
            '<br><div id="unavailable_' . $data->id . '" style="margin-top: 10px">' .
            ($data->isUnavailable() ? '<div class="badge" style="margin-left: 0">НД</div>' : '') .
            '</div>';
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'description',
        'headerOptions' => ['style' => 'min-width: 250px; text-align: center'],
        'format' => 'raw',
        'value' => function(RealtyObject $data) {

            if ( strlen($data->description) > 400 ) {

                $tmpDescription = substr($data->description, 0, 400);
                $lastSpace = strripos($tmpDescription, ' ');
                $shortDescription = substr($data->description, 0, $lastSpace);

                $str = ($data->title ? ("<div class='skip-export' style='font-weight: bold; margin-bottom: 5px'>" .
                        Html::a($data->title, Url::to(['/realty-object/view', 'id' => $data->id]), ['data-pjax' => 0]) . "</div>" .
                        "<div style='font-weight: bold; margin-bottom: 5px; display: none'>" .
                        Html::a($data->title, Url::toRoute(['/realty-object/view', 'id' => $data->id], true), ['target' => '_blank']) . "</div>") : '')  .

                    "<div class='description-body'>" .
                    "<div id='short_description_" . $data->id . "' class='skip-export'>" . $shortDescription . " " .
                    "<button class='description-btn' data-do='open-description' data-id='" . $data->id . "'>" .
                    "<span class='caret' aria-hidden='true'></span> полностью" .
                    "</button>" .
                    "</div>" .
                    "<div class='hidden-description' id='full_description_" . $data->id . "'>" . $data->description .
                    "<button class='description-btn skip-export' data-do='close-description' data-id='" . $data->id . "'>" .
                    "<span class='caret-up' aria-hidden='true'></span> скрыть" .
                    "</button>" .
                    "</div>" .
                    "</div>";
                return $str;

            } else {

                $str = ($data->title ? ("<div class='skip-export' style='font-weight: bold; margin-bottom: 5px'>" .
                        Html::a($data->title, Url::to(['/realty-object/view', 'id' => $data->id]), ['data-pjax' => 0]) . "</div>" .
                        "<div style='font-weight: bold; margin-bottom: 5px; display: none'>" .
                        Html::a($data->title, Url::toRoute(['/realty-object/view', 'id' => $data->id], true), ['target' => '_blank']) . "</div>") : '')  .

                    $data->description;

                return $str;
            }
        },
    ],
    [
        'attribute' => 'price',
        'label' => 'Цена',
        'value' => function (RealtyObject $data) {
            return number_format($data->price, 0, '.', ' ');
        },
        // 'headerOptions' => ['style' => 'text-align: center'],
    ],
    [
        'attribute' => 'floors',
        'label' => 'Этажн.',
    ],

    [

        'label' => 'Действие',
        'format' => 'raw',
        'value' => function ($data) {
//            var_dump($data);die;
            $sms = $data->phone . ', ' . $data->name  .  ', ' .
                $data->street . ', ' . ObjectHelper::propertyTypeName($data->category, $data->property_type);
            return Html::button('<span class="glyphicon glyphicon-arrow-left"></span> В SMS',
                ['class' => 'btn btn-success btn-block btn-sm ', 'onclick' => 'addToSms("' . $sms . '")',
                    'title' => 'В SMS']);
        },

    ],


];


?>
<div class="user-related-object-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-lg-12">
            <?= GridView::widget([
                'dataProvider' => $RelatedObjectDataProvider,
                'filterModel' => $RelatedObjectSearchModel,
                'columns' => $columns
            ]); ?>
        </div>



    </div>




</div>
