<?php

namespace app\forms\client;

use app\helpers\LocationHelper;
use app\helpers\StrHelper;
use app\models\client\RealtyObject;
use app\models\Rooms;
use app\validators\PhoneValidator;
use yii\base\Model;
use yii\web\UploadedFile;

class RealtyObjectForm extends Model
{
    public $id;
    public $category;
    public $property_type;
    public $type;
    public $trade;
    public $release;
    public $release_date;
    public $repair;
    public $furniture;
    public $region;
    public $city;
    public $district_id;
    public $metro;
    public $street;
    public $home;
    public $cadastral;
    public $apartment_number;
    public $class_building;
    public $type_building;
    public $floor;
    public $total_floor;
    public $total_area;
    public $living_area;
    public $kitchen_area;
    public $utility;
    public $price;
    public $pledge;
    public $name;
    public $phone;
    public $phone_2;
    public $email;
    public $nd;
    public $use_telegram;
    public $telegram;
    public $use_whatsapp;
    public $whatsapp;
    public $use_viber;
    public $viber;
    public $use_vk;
    public $vk;
    public $title;
    public $description;
    public $service_info;
    public $manager;
    public $stage;
    public $source;
    public $call_back;
    public $call_back_date;
    public $images;

    public $id_company;

    public $status;

    /**
     * @var UploadedFile[]
     */
    public $image_files;

    public $old_images;
    public $images_order;           // отсортированные изображения
    public $images_updated = false;  // флаг изменения изображений (для логов)

    public $copy_id = null;

    public $room_object = null;
    public $object = null;

    public function __construct($object = null, array $config = [])
    {
        if ($object) {
            if ($object instanceof RealtyObject) {

                $this->id = $object->id;
                $this->category = $object->category;
                $this->property_type = $object->property_type;
                $this->type = $object->type;
                $this->repair = $object->repair;
                $this->furniture = $object->furniture;
                $this->region = $object->region;
                $this->city = $object->city;
                $this->district_id = $object->district_id;
                $this->metro = array_filter(explode(',', $object->metro));
                $this->street = $object->street;
                $this->home = $object->home;
                $this->cadastral = $object->cadastral;
                $this->apartment_number = $object->apartment_number;
                $this->class_building = $object->class_building;
                $this->type_building = $object->type_building;
                $this->floor = $object->floor;
                $this->total_floor = $object->total_floor;
                $this->total_area = $object->total_area;
                $this->living_area = $object->living_area;
                $this->kitchen_area = $object->kitchen_area;
                $this->utility = $object->utility;
                $this->price = $object->price;
                $this->pledge = $object->pledge;
                $this->name = $object->name;
                $this->phone = $object->phone;
                $this->phone_2 = $object->phone_2;
                $this->email = $object->email;
                $this->nd = $object->nd;
                $this->use_telegram = $object->use_telegram;
                $this->telegram = $object->telegram;
                $this->use_whatsapp = $object->use_whatsapp;
                $this->whatsapp = $object->whatsapp;
                $this->use_viber = $object->use_viber;
                $this->viber = $object->viber;
                $this->use_vk = $object->use_vk;
                $this->vk = $object->vk;
                $this->title = $object->title;
                $this->description = $object->description;
                $this->service_info = $object->service_info;
                $this->manager = $object->manager;
                $this->stage = $object->stage;
                $this->source = $object->source;
                $this->call_back = $object->call_back;
                $this->call_back_date = $object->call_back_date ? date('d.m.Y H:i', $object->call_back_date) : null;
                $this->trade = $object->trade;
                $this->release = $object->release;
                $this->release_date = $object->release_date ? date('d.m.Y H:i', $object->release_date) : null;
                $this->images = $object->images;
                $this->status = $object->status;
                $this->id_company = $object->id_company;

                $this->object = $object;
            }

            if ($object instanceof Rooms) {

                $this->category = $object->cat2 == 'Коммерческая недвижимость' ?
                    RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL : RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL;
                $this->type = $object->type == 'Сдам' ?
                    RealtyObject::REALTY_OBJECT_TYPE_RENT : RealtyObject::REALTY_OBJECT_TYPE_SELL;
                $this->region = LocationHelper::getRegionByName($object->region2);
                $this->city = LocationHelper::getCityByName($object->city_name, $this->region);
                $this->street = $object->addr;
                $this->class_building = $object->sale_parametr7 == 'Вторичка' ?
                    RealtyObject::REALTY_OBJECT_CLASS_TYPE_SECONDARY :
                    ($object->sale_parametr7 == 'Новостройка' ? RealtyObject::REALTY_OBJECT_CLASS_TYPE_NEW : null);
                switch ($object->sale_parametr2) {
                    case 'Кирпичный' :
                        $this->type_building = RealtyObject::REALTY_OBJECT_BUILD_TYPE_BRICK;
                        break;
                    case 'Панельный' :
                        $this->type_building = RealtyObject::REALTY_OBJECT_BUILD_TYPE_PANEL;
                        break;
                    case 'Блочный' :
                        $this->type_building = RealtyObject::REALTY_OBJECT_BUILD_TYPE_BLOCK;
                        break;
                    case 'Монолитный' :
                        $this->type_building = RealtyObject::REALTY_OBJECT_BUILD_TYPE_MONOLIT;
                        break;
                    default :
                        $this->type_building = null;
                        break;
                }
                $this->floor = intval($object->etazh) > 0 ? intval($object->etazh) : '';
                $this->total_floor = intval($object->etazhnost) > 0 ? intval($object->etazhnost) : '';
                $this->total_area = intval($object->metr) > 0 ? intval($object->metr) : '';
                $this->price = intval($object->price) > 0 ? intval($object->price) : '';
                $this->pledge = intval($object->pledge) > 0 ? intval($object->pledge) : '';
                $this->name = $object->seller;
                $this->phone = $object->phone;
                $this->nd = $object->nd;
                $this->title = $object->title;
                $this->description = $object->description;
                $this->source = 1;  // парсер
                $this->images = $object->images;
                $this->status = RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC;

                $this->copy_id = $object->id;
                $this->room_object = $object;
            }
        } else {
            $this->status = RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [[ 'region', 'city', 'street', 'home',  'name', 'phone',   'price'], 'required'],
            [['category', 'property_type', 'type', 'region', 'city', 'district_id', 'apartment_number', 'class_building', 'type_building', 'floor', 'total_floor', 'total_area', 'living_area', 'kitchen_area', 'utility', 'pledge', 'manager', 'stage', 'source', 'repair', 'furniture'], 'integer'],
            [['call_back', 'trade', 'release', 'use_telegram', 'use_whatsapp', 'use_viber', 'use_vk'], 'integer'],
            [['title', 'description', 'service_info'], 'string'],
            [['call_back_date', 'release_date'], 'date', 'format' => 'dd.mm.yyyy HH:mm'],
            [['call_back_date', 'release_date'], 'default', 'value' => null],
            [[ 'description','cadastral', 'floor', 'total_floor', 'total_area', 'utility','property_type', 'type', 'category','id', 'status', 'copy_id', 'title'], 'safe'],
            [['street', 'home', 'cadastral', 'name', 'email', 'telegram', 'vk'], 'string', 'max' => 255],
            [['phone', 'phone_2', 'whatsapp', 'viber'], PhoneValidator::class],
            [['email'], 'email'],
            [['nd'], 'boolean'],
            [['images', 'images_order'], 'string'],
            [['image_files'], 'each', 'rule' => ['image', 'extensions' => 'png, jpg, jpeg']],
        ];
    }


    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->image_files = UploadedFile::getInstances($this, 'image_files');
            return true;
        }
        return false;
    }


    public function uploadImages()
    {
        $path = 'images/objects/' . $this->id . '/';

        if (!file_exists($path)) {
            mkdir($path);
        }

        if ($this->copy_id) {

            $image_files = array_unique(array_filter(array_map(function ($value) {
                return trim($value);
            }, $this->old_images)));

            $loc_images = [];

            foreach ($image_files as $image_file) {

                // $file_name = basename($image_file);
                $file_name = StrHelper::translit(pathinfo($image_file, PATHINFO_FILENAME)) . '.' . pathinfo($image_file, PATHINFO_EXTENSION);

                if (!file_exists($path . $file_name)) {
                    try {
                        if (copy($image_file, $path . $file_name)) {
                            $loc_images[] = '/' . $path . $file_name;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            // $this->images = implode(',', $loc_images);

        } else {

            $old_images = array_filter(explode(',', $this->images));

            if ($this->old_images) {

                foreach ($old_images as $key => $image) {

                    if (!in_array($image, $this->old_images)) {

                        $img_file = substr($image, 1);

                        if (file_exists($img_file) /*&& !is_dir($img_file)*/) {
                            unlink($img_file);
                        }
                        unset($old_images[$key]);
                    }
                }

            } else {

                foreach ($old_images as $image) {

                    $img_file = substr($image, 1);

                    if (file_exists($img_file) /*&& !is_dir($img_file)*/) {
                        unlink($img_file);
                    }
                }
                $old_images = [];
            }

            // $this->images = implode(',', $old_images);
        }


        foreach ($this->image_files as $key => $image) {

            $file_name = StrHelper::translit($image->baseName) . '.' . $image->extension;
            $image->saveAs($path . $file_name);
            // $this->images .= ($this->images ? ',' : '') . '/' . $path . $file_name;
        }


        $images_order = array_filter(explode(',', $this->images_order));


        foreach ($images_order as $key => $image) {

            $file_name = StrHelper::translit(pathinfo($image, PATHINFO_FILENAME)) . '.' . pathinfo($image, PATHINFO_EXTENSION);
            $images_order[$key] = '/' . $path . $file_name;
        }


        $new_images = implode(',', $images_order);
        $this->images_updated = $this->images != $new_images;
        $this->images = $new_images;
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Категория',
            'property_type' => 'Тип недв.',
            'type' => 'Сдам/Продам',
            'trade' => 'Торг',
            'release' => 'Освободится',
            'release_date' => 'Дата',
            'repair' => 'Ремонт',
            'furniture' => 'Мебель',
            'region' => 'Область',
            'city' => 'Город',
            'district_id' => 'Район',
            'metro' => 'Метро',
            'street' => 'Улица',
            'home' => 'Дом',
            'apartment_number' => 'Квартира',
            'cadastral' => 'Кадастровый номер',
            'class_building' => 'Тип жилья',
            'type_building' => 'Тип дома',
            'floor' => 'Этаж',
            'total_floor' => 'Этажность',
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
            'call_back_date' => 'Дата',
            'images' => 'Фотографии',
            'image_files' => 'Фотографии',
            'status' => 'Статус',

            'moderate' => 'Moderate',
            'manager_added' => 'Manager Added',
            'manager_update' => 'Manager Update',
            'manager_fixed' => 'Manager Fixed',
            'id_company' => 'Id Company',
            'id_c' => 'Id C',
        ];
    }
}


