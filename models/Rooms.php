<?php

namespace app\models;
use corpsepk\yml\behaviors\YmlCategoryBehavior;
use Yii;

/**
 * This is the model class for table "rooms".
 *
 * @property int $id
 * @property string $avito_id
 * @property string $title
 * @property string $date_avito
 * @property string $is_company
 * @property int $price
 * @property string $pledge
 * @property string $description
 * @property string $href
 * @property string $seller
 * @property string $phone
 * @property string $city
 * @property string $region
 * @property string $addr
 * @property string $type
 * @property string $type_info
 * @property int $rooms
 * @property string $etazh
 * @property string $etazhnost
 * @property double $metr
 * @property string $date_add
 * @property string $actual
 * @property string $source
 * @property string $yandex_id
 * @property string $nd
 * @property string $sale_parametr1
 * @property string $sale_parametr2
 * @property int $sale_parametr3
 * @property int $sale_parametr4
 * @property int $sale_parametr5
 * @property int $sale_parametr6
 * @property string $rent_parametr1
 * @property string $rent_parametr2
 * @property int $rent_parametr3
 * @property int $rent_parametr4
 * @property string $sale_room_parametr1
 * @property string $sale_room_parametr2
 * @property int $sale_room_parametr3
 * @property int $sale_room_parametr4
 * @property int $sale_room_parametr5
 * @property string $sale_room_parametr6
 * @property string $rent_room_parametr1
 * @property string $rent_room_parametr2
 * @property string $rent_room_parametr3
 * @property int $rent_room_parametr4
 * @property int $rent_room_parametr5
 * @property int $rent_room_parametr6
 * @property string $rent_room_parametr7
 * @property string $sale_home_parametr1
 * @property string $sale_home_parametr2
 * @property string $sale_home_parametr3
 * @property int $sale_home_parametr4
 * @property int $sale_home_parametr5
 * @property int $sale_home_parametr6
 * @property string $sale_home_parametr7
 * @property string $rent_home_parametr1
 * @property string $rent_home_parametr2
 * @property string $rent_home_parametr3
 * @property int $rent_home_parametr4
 * @property int $rent_home_parametr5
 * @property int $rent_home_parametr6
 * @property string $rent_home_parametr7
 * @property string $rent_home_parametr8
 * @property string $sale_land_parametr1
 * @property string $sale_land_parametr2
 * @property string $sale_land_parametr3
 * @property string $sale_land_parametr4
 * @property string $rent_land_parametr1
 * @property string $rent_land_parametr2
 * @property string $rent_land_parametr3
 * @property string $rent_land_parametr4
 * @property string $sale_garage_parametr1
 * @property string $sale_garage_parametr2
 * @property string $sale_garage_parametr3
 * @property string $sale_garage_parametr4
 * @property string $sale_garage_parametr5
 * @property string $rent_garage_parametr1
 * @property string $rent_garage_parametr2
 * @property string $rent_garage_parametr3
 * @property string $rent_garage_parametr4
 * @property string $rent_garage_parametr5
 * @property string $rent_commerc_parametr1
 * @property string $rent_commerc_parametr2
 * @property string $rent_commerc_parametr3
 * @property string $rent_commerc_parametr4
 * @property string $rent_commerc_parametr5
 * @property string $sale_commerc_parametr1
 * @property string $sale_commerc_parametr2
 * @property string $sale_commerc_parametr3
 * @property string $sale_commerc_parametr4
 * @property string $sale_commerc_parametr5
 * @property string $dop
 * @property string $dop2
 * @property string $category_id
 * @property string $person_type
 * @property string $count_ads_same_phone
 * @property int $blackagent
 * @property string $images
 * @property int $id_task
 */
class Rooms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rooms';
    }
    
    public $countrySearch;
    public $districtSearch;
    public $districtNameSearch;
    public $catSearch;
    public $typeAds;
    public $sourceSearch;
    public $cityNameSearch;
    public $citySearch;
    public $metroSearch;
    public $titleSearch;
    public $addrSearch;
    public $phoneSearch;
    public $imageYesSearch;
    public $imageNoSearch;
    public $priceBegin;
    public $priceEnd;
    public $dateBegin;
    public $dateEnd;
    public $sale_parametr5_2;
    public $sale_parametr3_2;
    public $sale_parametr4_2;
    public $sale_room_parametr3_2;
    public $sale_room_parametr4_2;
    public $rent_parametr3_2;
    public $metr_2;
    public $etazhnost_2;
    public $saleroomparametr5_2;
    public $rent_room_parametr6_2;
    public $rent_room_parametr4_2;
    public $rent_room_parametr5_2;
    public $sale_home_parametr2_2;
    public $sale_home_parametr4_2;
    public $sale_home_parametr5_2;
    public $sale_home_parametr6_2;
    public $rent_home_parametr2_2;
    public $rent_home_parametr4_2;
    public $rent_home_parametr5_2;
    public $rent_home_parametr6_2;
    public $sale_land_parametr2_2;
    public $sale_land_parametr3_2;
    public $rent_land_parametr2_2;
    public $rent_land_parametr3_2;
    public $sale_commerc_parametr4_2;
    public $rent_commerc_parametr4_2;
    public $typeproperty;
  //  public $km_do_metro;
  //  public $phone_protected;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'avito_id', 'title', 'date_avito', 'is_company', 'price', 'pledge', 'description', 'href', 'seller', 'phone', 'city', 'region', 'addr', 'type', 'type_info', 'rooms', 'etazh', 'actual', 'source', 'yandex_id', 'dop', 'dop2', 'category_id', 'person_type', 'count_ads_same_phone', 'blackagent', 'images', 'id_task', ], 'required'],
            [['id', 'price', 'rooms', 'sale_parametr3', 'sale_parametr4', 'sale_parametr5', 'sale_parametr6', 'rent_parametr3', 'rent_parametr4', 'sale_room_parametr3', 'sale_room_parametr4', 'sale_room_parametr5', 'rent_room_parametr4', 'rent_room_parametr5', 'rent_room_parametr6', 'sale_home_parametr4', 'sale_home_parametr5', 'sale_home_parametr6', 'rent_home_parametr4', 'rent_home_parametr5', 'rent_home_parametr6', 'blackagent', 'id_task', 'cat2_id', 'nedvigimost_type_id', 'source_id', 'priceBegin'], 'integer'],
            [['is_company', 'phone_protected', 'km_do_metro','typeproperty', 'pledge', 'description', 'etazh', 'etazhnost', 'actual', 'source', 'yandex_id', 'sale_parametr1', 'sale_parametr2', 'rent_parametr1', 'rent_parametr2', 'sale_room_parametr1', 'sale_room_parametr2', 'sale_room_parametr6', 'rent_room_parametr1', 'rent_room_parametr2', 'rent_room_parametr3', 'rent_room_parametr7', 'sale_home_parametr1', 'sale_home_parametr2', 'sale_home_parametr3', 'sale_home_parametr7', 'rent_home_parametr1', 'rent_home_parametr2', 'rent_home_parametr3', 'rent_home_parametr7', 'rent_home_parametr8', 'sale_land_parametr1', 'sale_land_parametr2', 'sale_land_parametr3', 'sale_land_parametr4', 'rent_land_parametr1', 'rent_land_parametr2', 'rent_land_parametr3', 'rent_land_parametr4', 'sale_garage_parametr1', 'sale_garage_parametr2', 'sale_garage_parametr3', 'sale_garage_parametr4', 'sale_garage_parametr5', 'rent_garage_parametr1', 'rent_garage_parametr2', 'rent_garage_parametr3', 'rent_garage_parametr4', 'rent_garage_parametr5', 'rent_commerc_parametr1', 'rent_commerc_parametr2', 'rent_commerc_parametr3', 'rent_commerc_parametr4', 'rent_commerc_parametr5', 'sale_commerc_parametr1', 'sale_commerc_parametr2', 'sale_commerc_parametr3', 'sale_commerc_parametr4', 'sale_commerc_parametr5', 'dop', 'dop2', 'category_id', 'person_type', 'count_ads_same_phone', 'images', 'metroSearch', 'districtNameSearch', 'cityNameSearch'], 'string'],
            [['nd'], 'boolean'],
            [['metr'], 'number'],
            [['date_add','catSearch', 'typeAds', 'sourceSearch', 'sourceSearch', 'titleSearch', 'dateBegin', 'dateEnd', 'countrySearch', 'districtSearch', 'imageYesSearch', 'imageNoSearch', 'sale_parametr5_2', 'sale_parametr3_2', 'sale_parametr4_2', 'metr_2', 'rent_parametr3_2', 'etazhnost_2', 'saleroomparametr5_2', 'sale_room_parametr3_2', 'sale_room_parametr4_2', 'rent_room_parametr6_2', 'rent_room_parametr4_2', 'sale_home_parametr2_2', 'sale_home_parametr5_2', 'sale_home_parametr4_2', 'sale_home_parametr6_2', 'rent_home_parametr2_2', 'rent_home_parametr5_2', 'rent_home_parametr4_2', 'rent_home_parametr6_2', 'sale_land_parametr2_2', 'sale_land_parametr3_2', 'rent_land_parametr2_2', 'rent_land_parametr3_2', 'sale_commerc_parametr4_2', 'rent_commerc_parametr4_2', 'districtSearch' ], 'safe'],
            [['avito_id'], 'string', 'max' => 25],
            [['title', 'href', 'seller', 'city', 'citySearch', 'region', 'regionSearch', 'addr', 'addrSearch', 'type', 'type_info'], 'string', 'max' => 255],
            [['date_avito'], 'string', 'max' => 50],
            [['phone', 'phoneSearch'], 'string', 'max' => 15],
            [['id'], 'unique'],
            [['districtSearch'], 'string', 'message'=>'Выберите область']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'avito_id' => 'Индификатор объявления',
            'title' => 'Наименование',
            'date_avito' => 'Дата подачи',
            'is_company' => 'Is Company',
            'price' => 'Стоимость',
            'pledge' => 'Залог',
            'description' => 'Описание',
            'href' => 'Ссылка на объявление',
            'seller' => 'Продавец',
            'phone' => 'Телефон',
            'city' => 'Регион / Город',
            'region' => 'Регион',
            'addr' => 'Адрес',
            'type' => 'Тип',
            'type_info' => 'Тип недвижимости',
            'rooms' => 'Комнат',
            'etazh' => 'Этаж',
            'etazhnost' => 'Этажность',
            'metr' => 'Площадь',
            'date_add' => 'Дата добавления',
            'actual' => 'Actual',
            'source' => 'Источник',
            'yandex_id' => 'Yandex ID',
            'nd' => 'Не дозвонились',
            'sale_parametr1' => 'Количество комнат',
            'sale_parametr2' => 'Тип дома',
            'sale_parametr3' => 'Этаж',
            'sale_parametr4' => 'Этажей в доме',
            'sale_parametr5' => 'Площадь',
            'sale_parametr6' => 'Адрес',
            'rent_parametr1' => 'Количество комнат',
            'rent_parametr2' => 'Тип дома',
            'rent_parametr3' => 'Этаж',
            'rent_parametr4' => 'Этажей в доме',
            'sale_room_parametr1' => 'Количество комнат',
            'sale_room_parametr2' => 'Тип дома',
            'sale_room_parametr3' => 'Этаж',
            'sale_room_parametr4' => 'Этажей в доме',
            'sale_room_parametr5' => 'Площадь комнаты',
            'sale_room_parametr6' => 'Адрес',
            'rent_room_parametr1' => 'Залог',
            'rent_room_parametr2' => 'Тип дома',
            'rent_room_parametr3' => 'Этаж',
            'rent_room_parametr4' => 'Этажей в доме',
            'rent_room_parametr5' => 'Площадь комнаты',
            'rent_room_parametr6' => 'Площадь комнаты',
            'rent_room_parametr7' => 'Адрес',
            'sale_home_parametr1' => 'Вид объекта',
            'sale_home_parametr2' => 'Тип дома',
            'sale_home_parametr3' => 'Материал стен',
            'sale_home_parametr4' => 'Расстояние до города',
            'sale_home_parametr5' => 'Площадь дома',
            'sale_home_parametr6' => 'Площадь участка',
            'sale_home_parametr7' => 'Адрес',
            'rent_home_parametr1' => 'Вид объекта',
            'rent_home_parametr2' => 'Этажей',
            'rent_home_parametr3' => 'Материал стен',
            'rent_home_parametr4' => 'Расстояние до города',
            'rent_home_parametr5' => 'Площадь дома',
            'rent_home_parametr6' => 'Площадь участка',
            'rent_home_parametr7' => 'Адрес',
            'rent_home_parametr8' => 'Залог',
            'sale_land_parametr1' => 'Категория земель',
            'sale_land_parametr2' => 'Расстояние до города',
            'sale_land_parametr3' => 'Площадь',
            'sale_land_parametr4' => 'Адрес',
            'rent_land_parametr1' => 'Категория земель',
            'rent_land_parametr2' => 'Расстояние до города',
            'rent_land_parametr3' => 'Площадь',
            'rent_land_parametr4' => 'Адрес',
            'sale_garage_parametr1' => 'Тип гаража',
            'sale_garage_parametr2' => 'Тип машиноместа',
            'sale_garage_parametr3' => 'Охрана',
            'sale_garage_parametr4' => 'Площадь',
            'sale_garage_parametr5' => 'Адрес',
            'rent_garage_parametr1' => 'Тип гаража',
            'rent_garage_parametr2' => 'Тип машиноместа',
            'rent_garage_parametr3' => 'Охрана',
            'rent_garage_parametr4' => 'Площадь',
            'rent_garage_parametr5' => 'Адрес',
            'rent_commerc_parametr1' => 'Вид объекта',
            'rent_commerc_parametr2' => 'Класс здания',
            'rent_commerc_parametr3' => 'Класс здания склад',
            'rent_commerc_parametr4' => 'Площадь',
            'rent_commerc_parametr5' => 'Адрес',
            'sale_commerc_parametr1' => 'Вид объекта',
            'sale_commerc_parametr2' => 'Класс здания',
            'sale_commerc_parametr3' => 'Класс здания склад',
            'sale_commerc_parametr4' => 'Площадь',
            'sale_commerc_parametr5' => 'Адрес',
            'dop' => 'Dop',
            'dop2' => 'Dop2',
            'category_id' => 'Category ID',
            'person_type' => 'Подал объявление',
            'count_ads_same_phone' => 'Кол-во номеров в архиве',
            'blackagent' => 'Blackagent',
            'images' => 'Изображения',
            'id_task' => 'Id Task',
            'imageYesSearch' => 'С фото',
            'imageNoSearch' => 'Без фото',
            'typeproperty' => 'typeproperty',
            'phone_protected' => 'Защищеный номер',
            'km_do_metro' => 'КМ до метро',

            'districtSearch' => 'Область'
        ];
    }
    
    public function searchUser() {
        
    }

    public function behaviors()
    {
        return [
            'ymlCategory' => [
                'class' => YmlCategoryBehavior::className(),
                'scope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->select(['id', 'name']);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'id' => $model->id,
                        'name' => $model->name,

                    ];
                }
            ],
        ];
    }


}
