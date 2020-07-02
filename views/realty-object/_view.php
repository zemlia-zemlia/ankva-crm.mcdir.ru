<?php

use app\helpers\LocationHelper;
use app\helpers\ObjectHelper;
use app\helpers\StageHelper;
use app\helpers\StrHelper;
use app\models\Adwords;
use app\models\RealtyObject;
use app\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RealtyObject */

$this->title = $model->title ? $model->title : 'Объект #' . $model->id_c;
$this->params['breadcrumbs'][] = ['label' => 'Мои объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['object'] = $model;
?>

    <div class="text-title m-b-4">
        <?= Html::encode($this->title) ?>
    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="control-label">Статус объекта</div>
            <div class="text-control">
                <?= ObjectHelper::statusName($model->status) ?>
            </div>

        </div>

    </div>

    <hr>

    <div class="row control-label">
        <div class="col-md-6">Категория</div>
        <div class="col-md-6">Сдам/Продам</div>
    </div>

    <div class="row flex">

        <div class="col-md-6">
            <div class="text-control">
                <?= ObjectHelper::categoryName($model->category) ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="text-control">
                <?= ObjectHelper::typeName($model->type) ?>
            </div>
        </div>

    </div>

    <hr>

    <div class="row control-label">
        <div class="col-md-3">Имя</div>
        <div class="col-md-3">Телефон</div>
        <div class="col-md-3">Доп. телефон</div>
        <div class="col-md-3">E-mail</div>
    </div>

    <div class="row flex">

        <div class="col-md-3">
            <div class="text-control">
                <?= $model->name ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="text-control">
                <?= StrHelper::phone($model->phone) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="text-control">
                <?= StrHelper::phone($model->phone_2) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="text-control">
                <?= $model->email ?>
            </div>
        </div>

    </div>

    <div class="row control-label m-t-1">
        <div class="col-md-3">Telegram</div>
        <div class="col-md-3">Whatsapp</div>
        <div class="col-md-3">Viber</div>
        <div class="col-md-3">ВКонтакте</div>
    </div>

    <div class="row flex">

        <div class="col-md-3">
            <div class="text-control">
                <?= $model->telegram ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="text-control">
                <?= StrHelper::phone($model->whatsapp) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="text-control">
                <?= StrHelper::phone($model->viber) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="text-control">
                <?= $model->vk ?>
            </div>
        </div>

    </div>

    <hr>

    <div class="row control-label">
        <div class="col-md-3">Область</div>
        <div class="col-md-3">Город</div>
        <div class="col-md-3">Район</div>
        <div class="col-md-3">Метро</div>
    </div>

    <div class="row flex">

        <div class="col-md-3">

            <div class="text-control">
                <?= LocationHelper::regionName($model->region) ?>
            </div>

        </div>

        <div class="col-md-3">

            <div class="text-control">
                <?= LocationHelper::cityName($model->city) ?>
            </div>

        </div>

        <div class="col-md-3">

            <div class="text-control">
                <?= LocationHelper::districtName($model->district) ?>
            </div>

        </div>

        <div class="col-md-3">

            <div class="text-control">
                <?= StrHelper::itemsList($model->metro_titles) ?>
            </div>

        </div>

    </div>

    <div class="row control-label m-t-1">
        <div class="col-md-4">Улица</div>
        <div class="col-md-4">Дом</div>
        <div class="col-md-4">Квартира</div>
    </div>

    <div class="row flex">

        <div class="col-md-4">

            <div class="text-control">
                <?= $model->street ?>
            </div>

        </div>

        <div class="col-md-4">

            <div class="text-control">
                <?= $model->home ?>
            </div>

        </div>

        <?php if ($model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL): ?>
            <div class="col-md-4">

                <div class="text-control">
                    <?= $model->apartment_number ?>
                </div>

            </div>
        <?php endif; ?>

    </div>

    <hr>

    <div class="row control-label m-t-1">
        <div class="col-md-3">Тип недвижимости</div>
        <div class="col-md-3">Ремонт</div>
        <div class="col-md-3">Мебель</div>
        <div class="col-md-3">Этаж</div>
    </div>

    <div class="row flex">

        <div class="col-md-3">

            <div class="text-control">
                <?= ObjectHelper::propertyTypeName($model->category, $model->type) ?>
            </div>

        </div>

        <div class="col-md-3">

            <div class="text-control">
                <?= ObjectHelper::repairName($model->repair) ?>
            </div>

        </div>

        <div class="col-md-3">

            <div class="text-control">
                <?= ObjectHelper::furnitureName($model->furniture) ?>
            </div>

        </div>

        <div class="col-md-3">

            <div class="text-control">
                <?= $model->getFloors() ?>
            </div>

        </div>

    </div>

    <hr>


    <?php if ($model->category == RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL): ?>

    <div class="row control-label m-t-1">
        <div class="col-md-5th">Тип жилья</div>
        <div class="col-md-5th">Тип дома</div>
        <div class="col-md-5th">Пл. общая</div>
        <div class="col-md-5th">Пл. жилая</div>
        <div class="col-md-5th">Пл. кухни</div>
    </div>

    <div class="row flex">

        <div class="col-md-5th">

            <div class="text-control">
                <?= ObjectHelper::classTypeName($model->class_building) ?>
            </div>

        </div>

        <div class="col-md-5th">

            <div class="text-control">
                <?= ObjectHelper::buildTypeName($model->type_building) ?>
            </div>

        </div>

        <div class="col-md-5th">

            <div class="text-control">
                <?= $model->total_area ?>
            </div>

        </div>

        <div class="col-md-5th">

            <div class="text-control">
                <?= $model->living_area ?>
            </div>

        </div>

        <div class="col-md-5th">

            <div class="text-control">
                <?= $model->kitchen_area ?>
            </div>

        </div>

    </div>

    <?php else: ?>

    <div class="row control-label m-t-1">
        <div class="col-md-6">Пл. общая</div>
    </div>

    <div class="row flex">

        <div class="col-md-6">

            <div class="text-control">
                <?= $model->total_area ?>
            </div>

        </div>

    </div>

    <?php endif; ?>

    <hr>

    <?php if ($model->type == RealtyObject::REALTY_OBJECT_TYPE_RENT): ?>

        <div class="row control-label m-t-1">
            <div class="col-md-5th">Стоимость</div>
            <div class="col-md-5th">Залог</div>
            <div class="col-md-5th">Комм. платежи</div>
            <div class="col-md-5th">Торг</div>
            <div class="col-md-5th">Освободится</div>
        </div>

        <div class="row flex">

            <div class="col-md-5th">

                <div class="text-control">
                    <?= $model->price ?>
                </div>

            </div>

            <div class="col-md-5th">

                <div class="text-control">
                    <?= $model->pledge ?>
                </div>

            </div>

            <div class="col-md-5th">

                <div class="text-control">
                    <?= ObjectHelper::utilityTypeName($model->utility) ?>
                </div>

            </div>

            <div class="col-md-5th">

                <div class="text-control">
                    <?= $model->trade == '1' ? 'Да' : 'Нет' ?>
                </div>

            </div>

            <div class="col-md-5th">

                <div class="text-control">
                    <?= $model->release_date ? date('d M Y H:i', $model->release_date) : '' ?>
                </div>

            </div>

        </div>

    <?php else: ?>

        <div class="row control-label m-t-1">
            <div class="col-md-6">Стоимость</div>
            <div class="col-md-6">Комм. платежи</div>
        </div>

        <div class="row flex">

            <div class="col-md-6">

                <div class="text-control">
                    <?= $model->price ?>
                </div>

            </div>

            <div class="col-md-6">

                <div class="text-control">
                    <?= ObjectHelper::utilityTypeName($model->utility) ?>
                </div>

            </div>

        </div>

    <?php endif; ?>

    <hr>

    <div class="row control-label">
        <div class="col-md-4">Кадастровый номер</div>
    </div>

    <div class="row flex">
        <div class="col-md-4">

            <div class="text-control">
                <?= $model->cadastral ?>
            </div>

        </div>
    </div>

    <hr>

    <div class="row control-label">
        <div class="col-md-12">Описание</div>
    </div>

    <div class="row flex">
        <div class="col-md-12">

            <div class="text-control">
                <?= $model->description ?>
            </div>

        </div>
    </div>

    <div class="row control-label m-t-2">
        <div class="col-md-12">Служебная информация <p style="color:grey;">(Информация отображается только в CRM)</p></div>
    </div>

    <div class="row flex">
        <div class="col-md-12">

            <div class="text-control">
                <?= $model->service_info ?>
            </div>

        </div>
    </div>

    <hr>

    <div class="row control-label m-t-1">
        <div class="col-md-4">Ответственный пользователь</div>
        <div class="col-md-4">Этап</div>
        <div class="col-md-4">Источник</div>
    </div>

    <div class="row flex">

        <div class="col-md-4">

            <div class="text-control">
                <?= User::getName($model->manager) ?>
            </div>

        </div>

        <div class="col-md-4">

            <div class="text-control">
                <?= StageHelper::stageName($model->stage) ?>
            </div>

        </div>

        <div class="col-md-4">

            <div class="text-control">
                <?= Adwords::adwordName($model->source) ?>
            </div>

        </div>

    </div>

    <hr>

    <div class="row control-label">
        <div class="col-md-6">Перезвонить</div>
    </div>

    <div class="row flex">
        <div class="col-md-6">

            <div class="text-control">
                <?= $model->call_back == '1' ? date('d M Y H:i', $model->call_back_date) : '-' ?>
            </div>

        </div>
    </div>

    <hr>

    <div class="row control-label">
        <div class="col-md-6">Фотографии</div>
    </div>

    <?php
        $arrImages = explode(',', $model->images);
        $galleryImages = "<div class='rooms-images'>";
        foreach ($arrImages as $image) {
            $image = trim($image);
            $galleryImages .= '<a href="' . $image . '" style="display: inline-block; width: 80px; margin-right: 5px; vertical-align: middle;" rel="alternate"><img src="' . $image . '" ></a>';
        }
        $galleryImages .= '</div>';
    ?>

    <?= $galleryImages ?>

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
