<?php

namespace app\models;

use Yii;
use app\helpers\ObjectHelper;
use app\helpers\StageHelper;
use app\forms\RealtyObjectForm;
use app\helpers\LocationHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\District;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property int $category
 * @property int $property_type
 * @property int $type
 * @property int $trade
 * @property int $release
 * @property int $release_date
 * @property int $repair
 * @property int $furniture
 * @property int $region
 * @property int $city
 * @property int $district_id
 * @property string $metro
 * @property string $metro_titles
 * @property string $street
 * @property string $home
 * @property string $cadastral
 * @property int $apartment_number
 * @property int $class_building
 * @property int $type_building
 * @property int $floor
 * @property int $total_floor
 * @property int $total_area
 * @property int $living_area
 * @property int $kitchen_area
 * @property int $utility
 * @property int $price
 * @property int $pledge
 * @property string $name
 * @property string $phone
 * @property string $phone_2
 * @property string $email
 * @property boolean $nd
 * @property int $use_telegram
 * @property string $telegram
 * @property int $use_whatsapp
 * @property string $whatsapp
 * @property int $use_viber
 * @property string $viber
 * @property int $use_vk
 * @property string $vk
 * @property string $title
 * @property string $description
 * @property string $service_info
 * @property int $manager
 * @property int $stage
 * @property int $source
 * @property int $call_back
 * @property int $call_back_date
 * @property string $images
 * @property int $status
 * @property int $actual_date
 * @property string $del_reason
 * @property int $created_at
 * @property int $updated_at
 * @property int $moderate
 * @property int $manager_added
 * @property int $manager_update
 * @property int $manager_fixed
 * @property int $id_company
 * @property int $id_c
 *
 * @property District $district
 * @property ObjectLog[] $logs
 */
class RealtyObject extends ActiveRecord
{
    const REALTY_OBJECT_CATEGORY_RESIDENTAL = 1;
    const REALTY_OBJECT_CATEGORY_COMMERCIAL = 2;

    const REALTY_OBJECT_TYPE_RENT = 3;
    const REALTY_OBJECT_TYPE_SELL = 4;

    const REALTY_OBJECT_CLASS_TYPE_NEW = 5;
    const REALTY_OBJECT_CLASS_TYPE_SECONDARY = 6;

    const REALTY_OBJECT_BUILD_TYPE_BRICK = 7;
    const REALTY_OBJECT_BUILD_TYPE_PANEL = 8;
    const REALTY_OBJECT_BUILD_TYPE_BLOCK = 9;
    const REALTY_OBJECT_BUILD_TYPE_MONOLIT = 10;
    const REALTY_OBJECT_BUILD_TYPE_WOOD = 11;

    const REALTY_OBJECT_UTILITY_TYPE_NO = 12;
    const REALTY_OBJECT_UTILITY_TYPE_ALL = 13;
    const REALTY_OBJECT_UTILITY_TYPE_COUNTERS = 14;

    const REALTY_OBJECT_REPAIR_TYPE_SIMPLE = 15;
    const REALTY_OBJECT_REPAIR_TYPE_EURO = 16;
    const REALTY_OBJECT_REPAIR_TYPE_COSMETIC = 17;
    const REALTY_OBJECT_REPAIR_TYPE_DRAFT = 18;

    const REALTY_OBJECT_FURNITURE_YES = 19;
    const REALTY_OBJECT_FURNITURE_SOME = 20;
    const REALTY_OBJECT_FURNITURE_NO = 21;

    const REALTY_OBJECT_BOARD_STATUS_PUBLIC = 22;
    const REALTY_OBJECT_BOARD_STATUS_ARCHIVE = 23;
    const REALTY_OBJECT_BOARD_STATUS_DELETED = 24;


    public static function create(RealtyObjectForm $form)
    {
        $object = new self();

        $object->category = $form->category;
        $object->property_type = $form->property_type;
        $object->type = $form->type;
        $object->trade = $form->trade;
        $object->release = $form->release;
        $object->release_date = strtotime($form->release_date);
        $object->repair = $form->repair;
        $object->furniture = $form->furniture;
        $object->region = $form->region;
        $object->city = $form->city;
        $object->district_id = $form->district_id;
        $object->metro = $form->metro ? implode(',', $form->metro) : '';
        $object->metro_titles = $form->metro ? implode(',', array_map(function ($station_id) use ($form) {
            return LocationHelper::metroStationName($form->city, $station_id);
        }, $form->metro)) : '';
        $object->street = $form->street;
        $object->home = $form->home;
        $object->cadastral = $form->cadastral;
        $object->apartment_number = $form->apartment_number;
        $object->class_building = $form->class_building;
        $object->type_building = $form->type_building;
        $object->floor = $form->floor;
        $object->total_floor = $form->total_floor;
        $object->total_area = $form->total_area;
        $object->living_area = $form->living_area;
        $object->kitchen_area = $form->kitchen_area;
        $object->utility = $form->utility;
        $object->price = $form->price;
        $object->pledge = $form->pledge;
        $object->name = $form->name;
        $object->phone = substr($form->phone, 4, 3) . substr($form->phone, 9, 3) . substr($form->phone, 13, 2) . substr($form->phone, 16, 2);
        $object->phone_2 = $form->phone_2 ? substr($form->phone_2, 4, 3) . substr($form->phone_2, 9, 3) . substr($form->phone_2, 13, 2) . substr($form->phone_2, 16, 2) : '';
        $object->email = $form->email;
        $object->nd = $form->nd;
        $object->use_telegram = $form->use_telegram;
        $object->telegram = $form->telegram;
        $object->use_whatsapp = $form->use_whatsapp;
        $object->whatsapp = $form->whatsapp ? substr($form->whatsapp, 4, 3) . substr($form->whatsapp, 9, 3) . substr($form->whatsapp, 13, 2) . substr($form->whatsapp, 16, 2) : '';
        $object->use_viber = $form->use_viber;
        $object->viber = $form->viber ? substr($form->viber, 4, 3) . substr($form->viber, 9, 3) . substr($form->viber, 13, 2) . substr($form->viber, 16, 2) : '';
        $object->use_vk = $form->use_vk;
        $object->vk = $form->vk;
        $object->title = $form->title;
        $object->description = $form->description;
        $object->service_info = $form->service_info;
        $object->manager = $form->manager;
        $object->stage = $form->stage;
        $object->source = $form->source;
        $object->call_back = $form->call_back;
        $object->call_back_date = strtotime($form->call_back_date);
        $object->images = $form->images;
        $object->status = $form->status;
        $object->actual_date = time();

        $object->id_company = Yii::$app->user->identity->id_company;

        return $object;
    }


    public function edit(RealtyObjectForm $form)
    {
        $change_log = '';
        $separator = '&nbsp;&nbsp;&raquo;&nbsp;&nbsp;';


        if ($this->category != $form->category) {  // поменялась категория
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Категория' . '<br>' .
                ObjectHelper::categoryName($this->category) . $separator . ObjectHelper::categoryName($form->category);
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Тип недвижимости' . '<br>' .
                ObjectHelper::propertyTypeName($this->category, $this->property_type) . $separator . ObjectHelper::propertyTypeName($form->category, $form->property_type);
        } else {
            if ($this->property_type != $form->property_type) {  // тип недвижимости поменялся
                $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Тип недвижимости' . '<br>' .
                    ObjectHelper::propertyTypeName($this->category, $this->property_type) . $separator . ObjectHelper::propertyTypeName($form->category, $form->property_type);
            }
        }

        $this->category = $form->category;
        $this->property_type = $form->property_type;


        if ($this->type != $form->type) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Сдам/Продам' . '<br>' . ObjectHelper::typeName($this->type) . $separator . ObjectHelper::typeName($form->type);
        }
        $this->type = $form->type;


        if ($this->trade != $form->trade) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Торг' . '<br>' . ObjectHelper::tradeName($this->trade) . $separator . ObjectHelper::tradeName($form->trade);
        }
        $this->trade = $form->trade;


        $release_date = strtotime($form->release_date);

        if ($this->release != $form->release) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Освободится' . '<br>' . ObjectHelper::checkName($this->release) . $separator . ObjectHelper::checkName($form->release);
        }
        if ($this->release_date != $release_date) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Освободится (дата)' . '<br>' . date('d M Y H:i', $this->release_date) . $separator . date('d M Y H:i', $release_date);
        }
        $this->release = $form->release;
        $this->release_date = $release_date;


        if ($this->repair != $form->repair) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Ремонт' . '<br>' . ObjectHelper::repairName($this->repair) . $separator . ObjectHelper::repairName($form->repair);
        }
        $this->repair = $form->repair;


        if ($this->furniture != $form->furniture) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Мебель' . '<br>' . ObjectHelper::furnitureName($this->furniture) . $separator . ObjectHelper::furnitureName($form->furniture);
        }
        $this->furniture = $form->furniture;


        if ($this->region != $form->region) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Область' . '<br>' . LocationHelper::regionName($this->region) . $separator . LocationHelper::regionName($form->region);
        }
        $this->region = $form->region;


        if ($this->city != $form->city) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Город' . '<br>' . LocationHelper::cityName($this->city) . $separator . LocationHelper::cityName($form->city);
        }
        $this->city = $form->city;


        if ($this->district_id != $form->district_id) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Район' . '<br>' . LocationHelper::districtName($this->district_id) . $separator . LocationHelper::districtName($form->district_id);
        }
        $this->district_id = $form->district_id;


        $metro_titles = !empty($form->metro) ? implode(',', array_map(function ($station_id) use ($form) {
            return LocationHelper::metroStationName($form->city, $station_id);
        }, $form->metro)) : '';

        if ($this->metro_titles != $metro_titles) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Метро' . '<br>' . $this->metro_titles . $separator . $metro_titles;
        }
        $this->metro = $form->metro ? implode(',', $form->metro) : '';
        $this->metro_titles = $metro_titles;


        if ($this->street != $form->street) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Улица' . '<br>' . $this->street . $separator . $form->street;
        }
        $this->street = $form->street;


        if ($this->home != $form->home) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Дом' . '<br>' . $this->home . $separator . $form->home;
        }
        $this->home = $form->home;


        if ($this->cadastral != $form->cadastral) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Кадастровый номер' . '<br>' . $this->cadastral . $separator . $form->cadastral;
        }
        $this->cadastral = $form->cadastral;


        if ($this->apartment_number != $form->apartment_number) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Квартира' . '<br>' . $this->apartment_number . $separator . $form->apartment_number;
        }
        $this->apartment_number = $form->apartment_number;


        if ($this->class_building != $form->class_building) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Тип жилья' . '<br>' . ObjectHelper::classTypeName($this->class_building) . $separator . ObjectHelper::classTypeName($form->class_building);
        }
        $this->class_building = $form->class_building;


        if ($this->type_building != $form->type_building) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Тип дома' . '<br>' . ObjectHelper::buildTypeName($this->type_building) . $separator . ObjectHelper::buildTypeName($form->type_building);
        }
        $this->type_building = $form->type_building;


        if ($this->floor != $form->floor) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Этаж' . '<br>' . $this->floor . $separator . $form->floor;
        }
        $this->floor = $form->floor;


        if ($this->total_floor != $form->total_floor) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Этажность' . '<br>' . $this->total_floor . $separator . $form->total_floor;
        }
        $this->total_floor = $form->total_floor;


        if ($this->total_area != $form->total_area) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Общая площадь' . '<br>' . $this->total_area . $separator . $form->total_area;
        }
        $this->total_area = $form->total_area;


        if ($this->living_area != $form->living_area) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Жилая площадь' . '<br>' . $this->living_area . $separator . $form->living_area;
        }
        $this->living_area = $form->living_area;


        if ($this->kitchen_area != $form->kitchen_area) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Площадь кухни' . '<br>' . $this->kitchen_area . $separator . $form->kitchen_area;
        }
        $this->kitchen_area = $form->kitchen_area;


        if ($this->utility != $form->utility) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Коммунальные платежи' . '<br>' . ObjectHelper::utilityTypeName($this->utility) . $separator . ObjectHelper::utilityTypeName($form->utility);
        }
        $this->utility = $form->utility;


        if ($this->price != $form->price) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Стоимость' . '<br>' . $this->price . $separator . $form->price;
        }
        $this->price = $form->price;


        if ($this->pledge != $form->pledge) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Залог' . '<br>' . $this->pledge . $separator . $form->pledge;
        }
        $this->pledge = $form->pledge;


        if ($this->name != $form->name) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Имя' . '<br>' . $this->name . $separator . $form->name;
        }
        $this->name = $form->name;


        $phone = substr($form->phone, 4, 3) . substr($form->phone, 9, 3) . substr($form->phone, 13, 2) . substr($form->phone, 16, 2);

        if ($this->phone != $phone) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Телефон' . '<br>' . $this->phone . $separator . $phone;
        }
        $this->phone = $phone;


        $phone_2 = $form->phone_2 ? substr($form->phone_2, 4, 3) . substr($form->phone_2, 9, 3) . substr($form->phone_2, 13, 2) . substr($form->phone_2, 16, 2) : '';

        if ($this->phone_2 != $phone_2) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Доп. телефон' . '<br>' . $this->phone_2 . $separator . $phone_2;
        }
        $this->phone_2 = $phone_2;


        if ($this->email != $form->email) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'E-mail' . '<br>' . $this->email . $separator . $form->email;
        }
        $this->email = $form->email;


        if ($this->use_telegram != $form->use_telegram) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Telegram' . '<br>' . ObjectHelper::checkName($this->use_telegram) . $separator . ObjectHelper::checkName($form->use_telegram);
        }
        $this->use_telegram = $form->use_telegram;


        if ($this->telegram != $form->telegram) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Telegram (аккаунт)' . '<br>' . $this->telegram . $separator . $form->telegram;
        }
        $this->telegram = $form->telegram;


        if ($this->use_whatsapp != $form->use_whatsapp) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Whatsapp' . '<br>' . ObjectHelper::checkName($this->use_whatsapp) . $separator . ObjectHelper::checkName($form->use_whatsapp);
        }
        $this->use_whatsapp = $form->use_whatsapp;


        $whatsapp = $form->whatsapp ? substr($form->whatsapp, 4, 3) . substr($form->whatsapp, 9, 3) . substr($form->whatsapp, 13, 2) . substr($form->whatsapp, 16, 2) : '';

        if ($this->whatsapp != $whatsapp) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Whatsapp (номер)' . '<br>' . $this->whatsapp . $separator . $whatsapp;
        }
        $this->whatsapp = $whatsapp;


        if ($this->use_viber != $form->use_viber) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Viber' . '<br>' . ObjectHelper::checkName($this->use_viber) . $separator . ObjectHelper::checkName($form->use_viber);
        }
        $this->use_viber = $form->use_viber;


        $viber = $form->viber ? substr($form->viber, 4, 3) . substr($form->viber, 9, 3) . substr($form->viber, 13, 2) . substr($form->viber, 16, 2) : '';

        if ($this->viber != $viber) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Viber (номер)' . '<br>' . $this->viber . $separator . $viber;
        }
        $this->viber = $viber;


        if ($this->use_vk != $form->use_vk) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'ВКонтакте' . '<br>' . ObjectHelper::checkName($this->use_vk) . $separator . ObjectHelper::checkName($form->use_vk);
        }
        $this->use_vk = $form->use_vk;


        if ($this->vk != $form->vk) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'ВКонтакте (аккаунт)' . '<br>' . $this->vk . $separator . $form->vk;
        }
        $this->vk = $form->vk;


        if ($this->title != $form->title) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Название' . '<br>' . $this->title . $separator . $form->title;
        }
        $this->title = $form->title;


        if ($this->description != $form->description) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Описание' . '<br>' . $this->description . $separator . $form->description;
            // $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Изменение описания';
        }
        $this->description = $form->description;


        if ($this->service_info != $form->service_info) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Служебная информация' . '<br>' . $this->service_info . $separator . $form->service_info;
        }
        $this->service_info = $form->service_info;


        if ($this->manager != $form->manager) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Ответственный пользователь' . '<br>' . User::getName($this->manager) . $separator . User::getName($form->manager);
        }
        $this->manager = $form->manager;


        if ($this->stage != $form->stage) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Этап' . '<br>' . StageHelper::stageName($this->stage) . $separator . StageHelper::stageName($form->stage);
        }
        $this->stage = $form->stage;


        if ($this->source != $form->source) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Источник' . '<br>' . Adwords::adwordName($this->source) . $separator . Adwords::adwordName($form->source);
        }
        $this->source = $form->source;


        $call_back_date = strtotime($form->call_back_date);

        if ($this->call_back != $form->call_back) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Перезвонить' . '<br>' . ObjectHelper::checkName($this->call_back) . $separator . ObjectHelper::checkName($form->call_back);
        }
        if ($this->call_back_date != $call_back_date) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Перезвонить (дата)' . '<br>' . date('d M Y H:i', $this->call_back_date) . $separator . date('d M Y H:i', $call_back_date);
        }
        $this->call_back = $form->call_back;
        $this->call_back_date = $call_back_date;


        if ($form->images_updated) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Изменение фотографий';
        }
        $this->images = $form->images;


        if ($this->status != $form->status) {
            $change_log .= ($change_log != '' ? '<br><br>' : '') . 'Статус объекта' . '<br>' . ObjectHelper::statusName($this->status) . $separator . ObjectHelper::statusName($form->status);
        }
        $this->status = $form->status;


        if ($change_log != '') {

            $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_MODIFICATION,
                ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $this->id, $change_log, null, null);
            $objectLog->save();
        }

        return $change_log !== '';
    }


    public function setDelete()
    {
        $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_MODIFICATION,
            ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $this->id, 'Удаление объекта', null, null);
        $objectLog->save();

        $this->status = self::REALTY_OBJECT_BOARD_STATUS_DELETED;
    }


    public function isDeleted()
    {
        return $this->status == self::REALTY_OBJECT_BOARD_STATUS_DELETED;
    }


    public function inBlacklist()
    {
        return BlacklistObject::find()->where(['user_id' => Yii::$app->user->id, 'phone' => $this->phone])->exists();
    }


    public function setArchive()
    {
        $this->status = self::REALTY_OBJECT_BOARD_STATUS_ARCHIVE;
    }


    public function isArchive()
    {
        return $this->status == self::REALTY_OBJECT_BOARD_STATUS_ARCHIVE;
    }


    public function setPublic()
    {
        $this->status = self::REALTY_OBJECT_BOARD_STATUS_PUBLIC;
    }


    public function isPublic()
    {
        return $this->status == self::REALTY_OBJECT_BOARD_STATUS_PUBLIC;
    }


    public function refreshActualDate()
    {
        $new_actual_date = time();

        $separator = '&nbsp;&nbsp;&raquo;&nbsp;&nbsp;';
        $change_log = 'Дата актуальности' . '<br>' . Yii::$app->formatter->asDatetime($this->actual_date, 'short') . $separator . Yii::$app->formatter->asDatetime($new_actual_date, 'short');

        $objectLog = ObjectLog::create(ObjectLogType::LOG_CATEGORY_MODIFICATION,
            ObjectLogType::LOG_TYPE_STRING, Yii::$app->user->id, $this->id, $change_log, null, null);
        $objectLog->save();

        $this->actual_date = $new_actual_date;
        $this->nd = false;
    }


    public function setUnavailable()
    {
        $this->nd = true;
    }


    public function removeUnavailable()
    {
        $this->nd = false;
    }


    public function isUnavailable()
    {
        return $this->nd == true;
    }


    public function inFavorites()
    {
        $user_favorites = FavoriteObject::findOne(['user_id' => Yii::$app->user->id]);
        if ($user_favorites) {
            $favorites = explode(',', $user_favorites->ads);
        } else {
            $favorites = [];
        }
        return in_array($this->id, $favorites);
    }


    // -----------------------------------


    /*
     *
     *
     *     public function getAddress()
    {
        return '<a href="">'.LocationHelper::regionName($this->region) . ', ' . LocationHelper::cityName($this->city) . ', ' .
            $this->street . ', ' . ($this->district_id ? ('р-н ' . LocationHelper::districtName($this->district_id) . ', ') : '') .
            $this->home . ($this->apartment_number ? (', кв. ' . $this->apartment_number) : '').'</a>' ;
    }


     */

    public function getAddress()
    {
       return Html::a($this->street, Url::to(['/realty-object/view', 'id' => $this->id]), ['data-pjax' => 0]) . "</div>";
/*
        return '<a href="/realty-object/view?id='.$this->id.'">'.
            $this->street . ' ' . ($this->district_id ? ('р-н ' . LocationHelper::districtName($this->district_id) . ', ') : '') .
            $this->home . ($this->apartment_number ? (', кв. ' . $this->apartment_number) : '').'</a>' ;
*/
    }


    public function getFloors()
    {
        return $this->floor . ' / ' . $this->total_floor;
    }


    public function getDistrictName()
    {
//        var_dump($this);die;

        return $this->district_id ?  $this->district->login : 'не задан';
    }


    // logs

    public function getCreateLog()
    {
        $log = $this->getLogs()->where(['log_category' => ObjectLogType::LOG_CATEGORY_CREATE])->limit(1)->one();
        return $log;
    }

    public function getLastModifyLog()
    {
        $log = $this->getLogs()->where(['log_category' => ObjectLogType::LOG_CATEGORY_OPERATION])->orderBy(['created_at' => SORT_DESC])->limit(1)->one();
        return $log;
    }


    // ----------------------------------


    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city']);
    }

    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    public function getLogs()
    {
        return $this->hasMany(ObjectLog::className(), ['log_object_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }


    public static function tableName()
    {
        return 'objects';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Категория',
            'property_type' => 'Тип недв.',
            'type' => 'Сдам/Продам',
            'property' => 'Помещение',
            'trade' => 'Торг',
            'release' => 'Освободится',
            'release_date' => 'Дата',
            'repair' => 'Ремонт',
            'furniture' => 'Мебель',
            'address' => 'Адрес',
            'region' => 'Область',
            'city' => 'Город',
            'district_id' => 'Район',
            'districtName' => 'Район',
            'metro' => 'Метро',
            'metro_titles' => 'Метро',
            'street' => 'Улица',
            'home' => 'Дом',
            'apartment_number' => 'Квартира',
            'cadastral' => 'Кадастровый номер',
            'class_building' => 'Тип жилья',
            'type_building' => 'Тип дома',
            'floor' => 'Этаж',
            'total_floor' => 'Этажность',
            'floors' => 'Этажность',
            'total_area' => 'Общая площадь',
            'living_area' => 'Жилая площадь',
            'kitchen_area' => 'Площадь кухни',
            'utility' => 'Комм. платежи',
            'price' => 'Стоимость',
            'pledge' => 'Залог',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'phone_2' => 'Доп. телефон',
            'email' => 'E-mail',
            'nd' => 'Недоступен',
            'telegram' => 'Telegram',
            'use_telegram' => 'Telegram',
            'whatsapp' => 'WhatsApp',
            'use_whatsapp' => 'WhatsApp',
            'viber' => 'Viber',
            'use_viber' => 'Viber',
            'vk' => 'ВКонтакте',
            'use_vk' => 'ВКонтакте',
            'title' => 'Название',
            'description' => 'Описание',
            'service_info' => 'Служебная информация',
            'manager' => 'Отв. пользователь',
            'stage' => 'Этап',
            'source' => 'Источник',
            'call_back' => 'Перезвонить',
            'call_back_time' => 'Время',
            'call_back_date' => 'Дата',
            'images' => 'Фотографии',
            'created_at' => 'Добавлен',
            'updated_at' => 'Изменен',
            'status' => 'Статус',
            'actual_date' => 'Дата',

            'moderate' => 'Moderate',
            'manager_added' => 'Manager Added',
            'manager_update' => 'Manager Update',
            'id_company' => 'Id Company',
            'id_c' => 'Id C',
            'manager_fixed' => 'Manager Fixed',
        ];
    }
}
