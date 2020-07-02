<?php


use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\daterange\DateRangePicker;
use dosamigos\multiselect\MultiSelect;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

//echo "<pre>";
//print_r ($modelFavorites);
//echo "</pre>";
            $access_to = Yii::$app->user->identity->access_to;
          //  $access_to = '989898989899';


?>

    <section id="intro" class="section">
        <div class="container">
            <div class="row">



<div class="rooms-index">

<?

$this->title = 'Избранное';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>



    <div>

        <?
 $gridColumns = [

    [
        'attribute'=> 'id',
        'visible'=> 'true',

        'label'=> 'ID',
        'headerOptions' => ['style' => 'text-align: center'],
        'contentOptions' => ['style' => 'text-align: center'],
    ],
        [
        "attribute" => 'date_avito',


        'headerOptions' => ['style' => 'text-align: center'],
        'format' => ['datetime', 'php:d M Y H:i']
    ],
    [
        'label' => 'Ссылка',
        'headerOptions' => ['style' => 'width: 90px; padding: 5px 21px; text-align: center; color: #000;'],
        'contentOptions' => ['style' => 'padding: 10px 3px; text-align: center;'],
        'format'=> 'raw',
        'visible' => 'true',
        'value' =>  function($data) {
            $arrImages = explode(',', $data->images);
            $countImages = count($arrImages);
            $currentImage = trim( $arrImages[0] );

   if(Yii::$app->user->identity->access_to >= time()){
            $str = Html::button('<img src="' . $currentImage . '">', ['class' => 'rooms-img-btn', 'onclick' => 'galleryShow("' . $data->images . '")']). '<br>' . Html::a( 'Скачать (' . $countImages . ')', '/rooms/download-images?id=' . $data->id, [ 'title' =>'Скачать' ]) . '<br>' . Html::a( $data->source, $data->href, [ 'title' =>'Перейти', 'target' => '_blank' ]);
            return $str;
        }else{
                return '          
 <div class="sidebar-module sidebar-module-inset">
            
            <p><b>Доступ ограничен</b><br>Фотографии, ссылки на объявления, контактные данные а так-же все дополнительные функции доступны только при активации тарифа.</p>
          </div>
    ';

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
        'label' => 'Адрес',

        'headerOptions' => ['style' => 'text-align: center'],
        'format' => 'raw',
        'value' => function ($data) {
            return Html::button($data->addr, ['class' => 'view-popup favorite-btn', 'style' => 'color: #3d78d8;', 'value' => '/rooms/viewpopup?id=' . $data->id, 'data-title' => $data->title]);
        }
    ],

    [
        'attribute' => 'price',
        'headerOptions' => ['style' => 'text-align: center'],
             'content'=>function($data){
         return "".$data->price." руб."; 


            },
    ],
    [
        'attribute' => 'phone',
     'content'=>function($data){
         return Yii::$app->user->identity->access_to >= time() ? "".$data->seller." <br> <a href='tel:+7".$data->phone."'>+7".$data->phone."</a>":'У вас закрыт доступ к контактным данным объявлений, т.к у вас не выбран тарифный план. '; 


            },
    ],
    [
        'attribute' => 'city',
        'headerOptions' => ['style' => 'text-align: center'],
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header'=>'Действия',
        'template' => '{view}  {notes} {delete}',
        'headerOptions' => ['style' => 'color: #000;'],
        'buttons' => [
            'view' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm favorite-btn', 'title' => 'Просмотр', 'aria-label' => 'Просмотр', 'data-pjax' => '0', 'target' => '_blank'] );
            },
    
            'notes' => function ($url, $model, $key) use ($arrNotes) {
                    return 
                        '<div class="notes-body">' . 
                            Html::button('<span class="glyphicon glyphicon-comment"></span> Заметки', ['class' => 'btn btn-success btn-sm notes-ads favorite-btn', 'title' => 'Заметки']) . 
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

                    'delete' => function ($url, $model, $key) {
                return Html::button('<span class="glyphicon glyphicon-trash"></span> Удалить из избранного', [ 'onclick' => 'setFavorites(' . $key . ', ' . \Yii::$app->user->identity->username . ')', 'title' => 'Удалить', 'class' => 'favorite-btn', 'data-act' => 'delete']);
            },
        ],
    ],
    ];

?>

<div class="rooms-index">

    <div class="export-menu">
        <?php echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]); ?>
    </div>
    
    <div class="c"></div>
    
    <div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'style' => 'font-size: 12px;'
            ],
        'columns' => $gridColumns,
    ]); ?>
    </div>

</div>
</div></div></section>
<?php
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

<?php

$this->registerJsFile('/js/jquery.bxslider.min.js', ['depends' => 'yii\web\YiiAsset']);



