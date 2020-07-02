
<?php
use app\assets\MultiSelectAsset;
use app\assets\Select2Asset;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\daterange\DateRangePicker;
use dosamigos\multiselect\MultiSelect;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
MultiSelectAsset::register($this);
Select2Asset::register($this);
$this->title = 'Новые объекты';
$this->params['breadcrumbs'][] = $this->title;

if( Yii::$app->request->get('Rooms') ) {
    $queryParams = Yii::$app->request->get('Rooms');
}


$arrWishList = $wishListModel['ads'];

$this->registerJs('var district = document.getElementById(\'rooms-districtsearch\');', yii\web\View::POS_LOAD);

?>
    <section id="intro" class="section">
        <div class=" ">
            <div class="row">
<div class="rooms-index">
 



    
    <div>
    <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => '/rooms',
                'fieldConfig' => [
                    'template' => '{input}',
                    'options' => ['style' => 'display: inline-block; margin: 0 15px 20px 0;'],
                ],
            ]) ?>
    
    <?= $form->field($model, 'catSearch')->dropdownList(['2' => 'Квартиры', '3' => 'Комнаты', '4' => 'Дома, дачи, коттеджи', '5' => 'Земельные участки', '6' => 'Гаражи и машиноместа', '7' => 'Коммерческая недвижимость', '8' => 'Недвижимость за рубежом'], ['prompt' => 'Категория недвижимости', 'value' => @$queryParams['catSearch'] ] ) ?>
    
    <?= $form->field($model, 'typeAds')->dropdownList(['1' => 'Продам', '2' => 'Сдам', '3' => 'Куплю', '4' => 'Сниму'],  ['prompt' => 'Тип объявления', 'style' => 'width: 200px;', 'value' => @$queryParams['typeAds'] ]) ?>
    
    <?= $form->field($model, 'sourceSearch')->dropdownList(['avito.ru' => 'avito.ru', 'irr.ru' => 'irr.ru', 'realty.yandex.ru' => 'realty.yandex.ru', 'cian.ru' => 'cian.ru', 'sob.ru' => 'sob.ru', 'youla.io' => 'youla.io', 'n1.ru' => 'n1.ru', 'egent.ru' => 'egent.ru', 'mirkvartir.ru' => 'mirkvartir.ru', 'moyareklama.ru' => 'moyareklama.ru'],  ['prompt' => 'Источник', 'value' => @$queryParams['sourceSearch'] ]) ?>
    
<br>
    
    <?= $form->field($model, 'districtSearch', ['template' => '{input}{error}'])->dropdownList($districtModel, ['prompt' => 'Область',  'value' => @$queryParams['districtSearch'] ] ) ?>
    
    <?= $form->field($model, 'districtNameSearch')->input('hidden', [ 'style' => 'margin: 0', 'value' => @$queryParams['districtNameSearch'] ]) ?>
    
    <?php if ( $cityModel ) {
            echo $form->field($model, 'citySearch')->dropdownList($cityModel, ['prompt' => 'Город', 'style' => 'width: 250px;', 'value' => @$queryParams['citySearch'] ] );
        } else {
            echo $form->field($model, 'citySearch')->dropdownList([], ['prompt' => 'Город', 'style' => 'width: 250px;', 'disabled' => true, 'value' => @$queryParams['citySearch'] ] );
        }
    ?>
    
    <?= $form->field($model, 'cityNameSearch')->input('hidden', [ 'style' => 'margin: 0', 'value' =>@$queryParams['cityNameSearch'] ]) ?>
    
    
<!--    <?//= $form->field($model, 'regionSearch')->input('text', ['placeholder' => 'Регион', 'style' => 'width: 200px;', 'value' => $queryParams['regionSearch'] ]) ?>-->
    
    <?= $form->field($model, 'metroSearch')->input('text', ['placeholder' => 'Метро/район', 'style' => 'width: 250px;', 'value' => @$queryParams['metroSearch'] ]) ?>
    
    <?= $form->field($model, 'titleSearch')->input('text', ['placeholder' => 'Наименование', 'style' => 'width: 250px;', 'value' => @$queryParams['titleSearch'] ]) ?>
    
    <?= $form->field($model, 'addrSearch')->input('text', ['placeholder' => 'Адрес', 'style' => 'width: 150px;', 'value' => @$queryParams['addrSearch'] ]) ?>
    
    <?= $form->field($model, 'phoneSearch')->input('text', ['placeholder' => 'Телефон', 'style' => 'width: 100px;', 'value' => @$queryParams['phoneSearch'] ]) ?>
    
    <?= $form->field($model, 'imageYesSearch')->checkbox(['style' => 'width: 20px; height: 20px; vertical-align: bottom;']) ?>
    
    <?= $form->field($model, 'imageNoSearch')->checkbox( ['style' => 'width: 20px; height: 20px; vertical-align: bottom;'] ) ?>
    
    <?= $form->field($model, 'priceBegin')->input('text', ['placeholder' => 'Цена от', 'style' => 'width: 100px;', 'value' => @$queryParams['priceBegin'] ]) ?>
    
    <?= $form->field($model, 'priceEnd')->input('text', ['placeholder' => 'Цена до', 'style' => 'width: 100px;', 'value' => @$queryParams['priceEnd'] ]) ?>
    
    <?= $form->field($model, 'dateBegin')->input('date', ['placeholder' => 'Дата от', 'style' => 'width: 150px;', 'value' => @$queryParams['dateBegin'] ]) ?>
    
    <?= $form->field($model, 'dateEnd')->input('date', ['placeholder' => 'Дата до', 'style' => 'width: 150px;', 'value' => @$queryParams['dateEnd'] ]) ?>
    
    <div id="add-fields"></div>
    
    <div class="form-group" style="margin-top: 20px">
        <div>
            <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
            <a href="/rooms" class='btn btn-primary'>Очистить</a>
        </div>
    </div>
<!--        <script type="text/javascript">-->
<!---->
<!--            var district = document.getElementById('rooms-districtsearch');-->
<!--            alert(district.id);-->
<!--            var districtName = document.getElementById('rooms-districtnamesearch');-->
<!--            var city = document.getElementById('rooms-citysearch');-->
<!--            var cityName = document.getElementById('rooms-citynamesearch');-->
<!--            var category = document.getElementById('rooms-catsearch');-->
<!--            var typeAction = document.getElementById('rooms-typeads');-->
<!--            var newFieldsBody = document.getElementById('add-fields');-->
<!--        </script>-->
    
    <?php ActiveForm::end() ?>
    
    </div>
<?php 


        $gridColumns = [


    [
        'attribute'=> 'id',
        'label'=> 'ID',
        'headerOptions' => ['style' => ' text-align: center'],
        'contentOptions' => ['style' => ' text-align: center'],
    ],
        [
        "attribute" => 'date_avito',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' =>  ['datetime', 'php:d M Y H:i']
    ],
    [
        'class' => 'yii\grid\CheckboxColumn',
    ],
    [
        'label' => 'Ссылка',
        'headerOptions' => ['style' => ' text-align: center; color: #000;'],
        'contentOptions' => ['style' => 'padding: 10px 3px; width:40px; text-align: center;'],
        'format'=> 'raw',
        'visible' => 'true',
        'value' =>  function($data) {
            $arrImages = explode(',', $data->images);
            $countImages = count($arrImages);
            $currentImage = trim( $arrImages[0] );

   if($countImages > 1){
            $str = Html::button('<img src="' . $currentImage . '">', ['class' => 'rooms-img-btn', 'onclick' => 'galleryShow("' . $data->images . '")']). '<br>' . Html::a( 'Скачать фото (' . $countImages . ')', '/rooms/download-images?id=' . $data->id, [ 'title' =>'Скачать' ]) . '<br>' . Html::a( $data->source, $data->href, [ 'title' =>'Перейти', 'target' => '_blank' ]);
            return $str;
        }
        }
    ],
    [
        'attribute' => 'description',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => 'raw',
        'value' => function($data) {
            if ( strlen($data->description) > 400 ) {
                
                $tmpDescription = substr($data->description, 0, 400);
                $lastSpace = strripos($tmpDescription, ' ');
                $firstDescription = substr($data->description, 0, $lastSpace);
                $secondDescription = substr($data->description, $lastSpace);
                
                $str = "<div class='description-body'>" . $firstDescription . " <button class='btn-discription' data-do='open-description'><span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span> ещё</button><span class='hidden-description'>" . $secondDescription . "<button class='btn-discription' data-do='close-description'><span class='glyphicon glyphicon-triangle-top' aria-hidden='true'></span> скрыть</button></span></div>";
                
                return $str;
                
            } else {
                
                return $data->description;
            }
        }
    ],
    [
        'attribute' => 'type',
        'headerOptions' => ['style' => 'text-align: center'],
    ],
    [
        'attribute' => 'title',
        'headerOptions' => ['style' => 'text-align: center'],
    ],
    [
        'attribute' => 'addr',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' => 'raw',
        'value' => function ($data) {
            return "<a href='/realty-object/create?copy_id=".$data->id."'>$data->addr</a> ".Html::button('<i class="fa fa-info-circle" aria-hidden="true"></i>', ['class' => 'view-popup btn btn-default btn-sm-listing favorite-btn', 'title' => 'Подробнее',    'data-toggle' => 'tooltip', 'value' => '/rooms/viewpopup?id=' . $data->id, 'data-title' => $data->title]) . "<br><b>" . $data->region . "</b>  ".($data->km_do_metro ? '<div class="badge" style="margin-left: 0">'.$data->km_do_metro.' км до ближ станции</div>' : '').
                ($data->nd ? '<div class="badge" style="margin-left: 0">НД</div>' : '');
            //".".$data->phone."" Html::button($data->addr, ['class' => 'view-popup favorite-btn', 'value' => '/rooms/viewpopup?id=' . $data->id, 'data-title' => $data->title]);
        }
    ],

    [
        'attribute' => 'price',
        'headerOptions' => ['style' => 'text-align: center'],
        'format' =>  ['currency']

    ],
    [
       'attribute' => 'phone',
     'content'=>function($data){
         return Yii::$app->user->identity->access_to >= time() ? "".$data->seller." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>":"".$data->seller." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>  ".($data->phone_protected ? '<div class="badge" title="Номер подменен сервисом. Актуально для объявления с avito, yandex и cian" data-toggle = "tooltip" style="margin-left: 0">телефон подменен</div>' : '');
     }
    ],
    [
        'attribute' => 'city',
        'headerOptions' => ['style' => 'text-align: center'],
    ],
    [


        'class' => 'yii\grid\ActionColumn',
        'header'=>'Действия',
        'template' => ' {view} {add} {blacklist} {delete} {notes} {favorites}',
        'headerOptions' => ['style' => 'color: #000;'],
        'buttons' => [
            'view' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-default btn-sm-listing favorite-btn"><span class="glyphicon glyphicon-eye-open"></span></span> ', ['view', 'id' => $model->id], [ 'title' => 'Просмотр',    'data-toggle' => 'tooltip', 'aria-label' => 'Просмотр', 'data-pjax' => '0', 'target' => '_blank'] );
            },
            'add' => function ($url, $model, $key) {
                return Html::beginForm(['/realty-object/create', 'copy_id' => $model->id], 'post', ['style' => ['margin' => '0']]) . Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Добавить', ['class' => 'btn btn-primary btn-block btn-sm favorite-btn']) . Html::endForm();
            },
            'favorites' => function ($url, $model, $key) use ($arrWishList) {
                $j = strpos($arrWishList, strval($key));
                if ( $j !== false ) { 
                    return Html::button('<span class="glyphicon glyphicon-heart"></span>  Избранное', ['class' => 'favorite-btn', 'onclick' => 'setFavorites(' . $key . ', ' . \Yii::$app->user->identity->username . ')', 'title' => 'Удалить из избранного', 'data-act' => 'del']);
                } else {
                    return Html::button('<span class="glyphicon glyphicon-heart"></span> Избранное', ['class' => 'favorite-btn', 'onclick' => 'setFavorites(' . $key . ',' . \Yii::$app->user->identity->username . ')', 'title' => 'В избранное', 'data-act' => 'add']);
                }
            },
            'blacklist' => function ($url, $model, $key) {
                    return Html::button('<span class="glyphicon glyphicon-remove"></span> Черный список', ['class' => 'btn btn-danger btn-block btn-sm favorite-btn', 'onclick' => 'setBlacklist(' . $model->phone . ',' . \Yii::$app->user->identity->id . ',' . $key . ')', 'title' => 'В чёрный список']);
            },
            'delete' => function ($url, $model, $key) {
                    return Html::button('<span class="glyphicon glyphicon-remove"></span> Удалить', ['class' => 'btn btn-danger btn-block btn-sm favorite-btn object-delete-btn', 'data-obj_id' => $model->id]);
            },
            'notes' => function ($url, $model, $key) use ($arrNotes) {
                if (isset($arrNotes[$key]))


                    return
                        '<div class="notes-body">' .
                        Html::button('<span class="glyphicon glyphicon-comment"></span> Заметки', ['class' => 'btn btn-success btn-block btn-sm notes-ads favorite-btn', 'title' => 'Заметки']) .
                        '<form class="notes-wrapper" action="/rooms/notes" method="post">
                                <div class="notes-header">
                                    <h4><span class="glyphicon glyphicon-edit"></span> Ваши заметки</h4>
                                    <button class="close-notes glyphicon glyphicon-remove" onclick="return false;"></button></div>
                                <div class="notes-body">
                                    <textarea name="note">' . $arrNotes[$key] . '</textarea>
                                    <input type="hidden" name="ads_id" value="' . $key . '">
                                </div>
                                <div class="notes-footer">
                                    <button type="reset" title="Очистить"><span class="glyphicon glyphicon-ban-circle"></span></button> 
                                    <button class="btn-notes btn-primary" type="submit" title="Сохранить"><span class="glyphicon glyphicon-ok"></span></button>
                                </div>
                            </form>
                        </div>';

            },
            
        ],
        
    ],
    ];

?>
<?php if( @$queryParams ) : ?>
<div class="export-menu">
    <?php echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]); ?>
</div>
<div class="c"></div>
<div class="rooms-table-body">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    'tableOptions' => [
            'id' => 'table-rooms',
            'style' => 'font-size: 12px;'
        ],
    'columns' => $gridColumns,
    'rowOptions' => function ($model, $key, $index, $grid) use ($arrWishList) {
        $j = strpos($arrWishList, strval($key));
        if ( $j !== false ) {    
            return ['class' => 'favorites-row'];
        }
    }
]); ?>
    
    <?php  if ( !Yii::$app->user->isGuest ) { ?>
    <div>
        <span>Отмеченное поместить: </span>
         <?= Html::submitButton( 'В избранное', ['class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical', 'onclick' => 'wishList(' . \Yii::$app->user->identity->username . ')', 'data-act' => 'add-list' ] ) ?>
         <?= Html::submitButton( 'В чёрный список', ['class' => 'btn btn-light-gray btn-hvr hvr-shutter-out-vertical', 'onclick' => 'setBlacklist(' . \Yii::$app->user->identity->id . ')'] ) ?>
     </div>
     <?php } ?>
    </div>
<?php endIf; ?>
 </div>
 <div class="message-resalt-favorites" id="message-resalt-favorites"></div>
<?php
//  модальное окно вывода галлерей изображений
Modal::begin([
    'options' => [
        'id' => 'gallery-wrapper',
    ]
]);

Modal::end();
//  модальное окно просмотра всей информации об объявлении
Modal::begin([
    'id' => 'view-popup',
    'size' => 'modal-lg',
]);

echo "<div id='full-view'></div>";

Modal::end();
?>
<style>
    #w0 .help-block {
        position: absolute;
        font-size: smaller;
        line-height: 1em;
    }
</style>

<?php

$this->registerJsFile('/js/jquery.bxslider.min.js', ['depends' => 'yii\web\YiiAsset']);

?>

</div>
</div>
</section>

<div id="loader"></div>
<div id="fade"></div>



<?php $this->registerJs('

    $(function() {
         $(\'[data-toggle="tooltip"]\').tooltip();
        $("select[multiple != multiple]").select2({
            width: "100%",
            minimumResultsForSearch: 2
        });
        
        $("#location_metro_selector").multiselect({
            texts: {
                placeholder: "---",
                search: "",
                selectedOptions: " выбрано"
            },
            search: true
        });
        
        $("#street_address").suggestions({
            token: "ce84cf57c3f0608fa62c6cff354ec3ed29c21b1b",
            type: "ADDRESS",
            geoLocation: false,
            bounds: "street",
            hint: false,
            constraints: {
                label: false,
                locations: { city: $("#location_city_selector").find(":selected").text() }
            },
            restrict_value: true,

            onSelect: function(suggestion) {

                var house_address = $("#house_address");
                var stg_house_address = house_address.suggestions();

                house_address.attr("disabled", null);

                stg_house_address.clear();
                stg_house_address.setOptions({
                    constraints: {
                        label: false,
                        locations: {
                            city: $("#location_city_selector").find(":selected").text(),
                            street: suggestion.data.street
                        }
                    },
                    restrict_value: true
                });

            }
        });

        $("#house_address").suggestions({
            token: "ce84cf57c3f0608fa62c6cff354ec3ed29c21b1b",
            type: "ADDRESS",
            geoLocation: false,
            bounds: "house",
            hint: false,
            constraints: {
                label: false,
                locations: {
                    city: $("#location_city_selector").find(":selected").text(),
                    street: $("#street_address").val()
                }
            },
            restrict_value: true,

            onSelect: function(suggestion) {
                $("#apartment").attr("disabled", null);
            }
        });
        
        
        new Sortable(sortable, {
            animation: 150,
            ghostClass: "sortable-ghost-item",
            dataIdAttr: "data-image",
            filter: ".filestyler__file filestyler__plus",
            
            
            // store: {
            //     /**
            //      * Get the order of elements. Called once during initialization.
            //      * @param   {Sortable}  sortable
            //      * @returns {Array}
            //      */
            //     // get: function (sortable) {
            //     //     var order = localStorage.getItem(sortable.options.group.name);
            //     //     return order ? order.split("|") : [];
            //     // },
            //
            //     /**
            //      * Save the order of elements. Called onEnd (when the item is dropped).
            //      * @param {Sortable}  sortable
            //      */
            //     set: function (sortable) {
            //         // var order = sortable.toArray();
            //         // localStorage.setItem(sortable.options.group.name, order.join("|"));
            //         sortImages(' . $model->id . ');
            //     }
            // },
            
            onMove: function (evt) {
                return evt.related.className !== "filestyler__file filestyler__plus";
            }
        });
    });
') ?>

<?php
$this->registerJsFile('js/jquery.magnific-popup.min.js', ['depends' => 'yii\web\YiiAsset']);

$openMagnific = <<<JS
    $('.filestyler__list').magnificPopup({
        delegate: 'img',
        type: 'image',
        gallery: {
            enabled: true,
            preload: [0, 1]
        },
        callbacks: {
            elementParse: function(item) {
                item.src = $(item.el).attr('src');
            }
        }
    });
JS;

$this->registerJs($openMagnific);