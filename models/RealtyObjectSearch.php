<?php

namespace app\models;

use Yii;
use app\helpers\LocationHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class RealtyObjectSearch extends RealtyObject
{
    public $condition = null;

    public $address;
    public $floors;

    public $districtName;
    public $date_from;
    public $date_to;
    public $floor_from;
    public $floor_to;
    public $total_floor_from;
    public $total_floor_to;
    public $total_area_from;
    public $total_area_to;
    public $living_area_from;
    public $living_area_to;
    public $kitchen_area_from;
    public $kitchen_area_to;
    public $release_date_from;
    public $release_date_to;
    public $price_from;
    public $price_to;
    public $pledge_from;
    public $pledge_to;

    public $prop_type;
    public $district2;

    public static $counter = 0;
    public $index;

    public function __construct($condition = null, array $config = [])
    {
        parent::__construct($config);
        if ($condition) {
            $this->condition = $condition;
        }
        $this->index = static::$counter++;  // счетчик созданных объектов этого класса
    }

    public function rules()
    {
        return [
            [['id', 'category', 'property_type', 'type', 'region', 'city', 'district_id', 'apartment_number',
                'class_building', 'type_building', 'floor', 'total_floor', 'total_area', 'living_area', 'kitchen_area',
                'utility', 'pledge', 'manager', 'stage', 'source', 'call_back_date', 'created_at', 'updated_at', 'status',
                'furniture', 'repair', 'moderate', 'manager_added', 'manager_update', 'id_company', 'id_c', 'price', 'manager_fixed',
                'floor_from', 'floor_to', 'total_floor_from', 'total_floor_to', 'total_area_from', 'total_area_to',
                'living_area_from', 'living_area_to', 'kitchen_area_from', 'kitchen_area_to', 'price_from', 'price_to',
                'pledge_from', 'pledge_to', 'trade', 'actual_date'], 'integer'],

            [['street', 'home', 'cadastral', 'title', 'description', 'service_info', 'images', 'address', 'floors', 'districtName'], 'safe'],

            [['name', 'phone', 'phone_2', 'email', 'telegram', 'whatsapp', 'viber', 'vk', 'metro'], 'string', 'max' => 255],
            [['metro_titles'], 'string'],
            [['prop_type', 'district2'], 'each', 'rule' => ['integer']],

            [['date_from', 'date_to', 'release_date_from', 'release_date_to'], 'date', 'format' => 'dd.mm.yyyy HH:mm'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = RealtyObject::find()->alias('ob');

        if (!Yii::$app->user->isGuest) {

            $black_list = BlacklistObject::find()->select('phone')->asArray()->where(['user_id' => Yii::$app->user->id])->column();

            if (count($black_list) > 0) {
                $query->andFilterWhere(['not in', 'phone', $black_list]);
            }
        }

        if ($this->condition) {
            $query->andWhere($this->condition);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->validate()) {

            if ($this->condition) {

                $query->joinWith(['region r', 'city c', 'district d']);
            }

        } else {
            $query->where('0=1');
            return $dataProvider;
        }


        $dataProvider->setSort([
            'attributes' => [
                'id',
                'actual_date',
                // 'district_id',
                'districtName' => [
                    'asc' => ['ob.district_id' => SORT_ASC],
                    'desc' => ['ob.district_id' => SORT_DESC],
                ],
                'type',
                'property_type',
                'phone',
                'address' => [
                    'asc' => ['CONCAT_WS(" ", r.name, c.name, d.login, ob.street, ob.home, ob.apartment_number)' => SORT_ASC],
                    'desc' => ['CONCAT_WS(" ", r.name, c.name, d.login, ob.street, ob.home, ob.apartment_number)' => SORT_DESC],
                ],
                'description',
                'price',
                'floors' => [
                    'asc' => ['CONCAT_WS(" / ", ob.floor, ob.total_floor)' => SORT_ASC],
                    'desc' => ['CONCAT_WS(" / ", ob.floor, ob.total_floor)' => SORT_DESC],
                ],
                'furniture',
                'repair',
                'total_area',
            ],
            'defaultOrder' => ['actual_date' => SORT_DESC],
        ]);

        $this->load($params);

        $metro = ArrayHelper::getValue($this, 'metro');
        $stations = [];

        if ($metro) {
            $stations = array_map(function ($station_id) {
                return LocationHelper::metroStationName($this->city, $station_id);
            }, $metro);
        }




        // $prop_types = ArrayHelper::getValue($this, 'prop_type');




        $query->andFilterWhere([
            'ob.id' => $this->id,
            'ob.category' => $this->category,
            'ob.property_type' => $this->property_type,
            'ob.type' => $this->type,
            'ob.trade' => $this->trade,
            'ob.release' => $this->release,
            'ob.release_date' => $this->release_date,
            'ob.region' => $this->region,
            'ob.city' => $this->city,
            'ob.district_id' => $this->district_id,
            // 'ob.metro' => $this->metro,
            'ob.apartment_number' => $this->apartment_number,
            'ob.class_building' => $this->class_building,
            'ob.type_building' => $this->type_building,
            'ob.floor' => $this->floor,
            'ob.total_floor' => $this->total_floor,
            'ob.total_area' => $this->total_area,
            'ob.living_area' => $this->living_area,
            'ob.kitchen_area' => $this->kitchen_area,
            'ob.utility' => $this->utility,
            'ob.pledge' => $this->pledge,
            'ob.manager' => $this->manager,
            'ob.stage' => $this->stage,
            'ob.source' => $this->source,
            'ob.call_back_date' => $this->call_back_date,
            'ob.actual_date' => $this->actual_date,
            'ob.created_at' => $this->created_at,
            'ob.updated_at' => $this->updated_at,
            'ob.status' => $this->status,
            'ob.furniture' => $this->furniture,
            'ob.repair' => $this->repair,
            'ob.moderate' => $this->moderate,
            'ob.manager_added' => $this->manager_added,
            'ob.manager_update' => $this->manager_update,
            'ob.manager_fixed' => $this->manager_fixed,
            'ob.id_company' => $this->id_company,
            'ob.id_c' => $this->id_c,
            'ob.price' => $this->price,
        ]);

        // поиск по адресу
        $query
            ->andFilterWhere(['like', 'CONCAT_WS(" ", r.name, c.name, d.login, ob.street, ob.home, ob.apartment_number)', $this->address])
            ->andFilterWhere(['like', 'd.login', $this->districtName]);


        $query
            ->andFilterWhere(['like', 'ob.street', $this->street])
            ->andFilterWhere(['like', 'ob.home', $this->home])
            ->andFilterWhere(['like', 'ob.cadastral', $this->cadastral])
            ->andFilterWhere(['like', 'ob.name', $this->name])
            ->andFilterWhere(['like', 'ob.phone', $this->phone])
            ->andFilterWhere(['like', 'ob.phone_2', $this->phone_2])
            ->andFilterWhere(['like', 'ob.email', $this->email])
            ->andFilterWhere(['like', 'ob.telegram', $this->telegram])
            ->andFilterWhere(['like', 'ob.whatsapp', $this->whatsapp])
            ->andFilterWhere(['like', 'ob.viber', $this->viber])
            ->andFilterWhere(['like', 'ob.vk', $this->vk])
            ->andFilterWhere(['or', ['like', 'ob.title', $this->description], ['like', 'ob.description', $this->description]])
            ->andFilterWhere(['like', 'ob.service_info', $this->service_info])
            ->andFilterWhere(['like', 'ob.images', $this->images]);




        // расширеный поиск
        $query
            ->andFilterWhere(['>=', 'ob.actual_date', $this->date_from ? strtotime($this->date_from) : null])
            ->andFilterWhere(['<=', 'ob.actual_date', $this->date_to ? strtotime($this->date_to) : null])
            ->andFilterWhere(['>=', 'ob.release_date', $this->release_date_from ? strtotime($this->release_date_from) : null])
            ->andFilterWhere(['<=', 'ob.release_date', $this->release_date_to ? strtotime($this->release_date_to) : null])
            ->andFilterWhere(['>=', 'ob.floor', $this->floor_from ? $this->floor_from : null])
            ->andFilterWhere(['<=', 'ob.floor', $this->floor_to ? $this->floor_to : null])
            ->andFilterWhere(['>=', 'ob.total_floor', $this->total_floor_from ? $this->total_floor_from : null])
            ->andFilterWhere(['<=', 'ob.total_floor', $this->total_floor_to ? $this->total_floor_to : null])
            ->andFilterWhere(['>=', 'ob.total_area', $this->total_area_from ? $this->total_area_from : null])
            ->andFilterWhere(['<=', 'ob.total_area', $this->total_area_to ? $this->total_area_to : null])
            ->andFilterWhere(['>=', 'ob.living_area', $this->living_area_from ? $this->living_area_from : null])
            ->andFilterWhere(['<=', 'ob.living_area', $this->living_area_to ? $this->living_area_to : null])
            ->andFilterWhere(['>=', 'ob.kitchen_area', $this->kitchen_area_from ? $this->kitchen_area_from : null])
            ->andFilterWhere(['<=', 'ob.kitchen_area', $this->kitchen_area_to ? $this->kitchen_area_to : null])
            ->andFilterWhere(['>=', 'ob.price', $this->price_from ? $this->price_from : null])
            ->andFilterWhere(['<=', 'ob.price', $this->price_to ? $this->price_to : null])
            ->andFilterWhere(['>=', 'ob.pledge', $this->pledge_from ? $this->pledge_from : null])
            ->andFilterWhere(['<=', 'ob.pledge', $this->pledge_to ? $this->pledge_to : null]);

             $query->andWhere(['ob.id_company' => Yii::$app->user->identity->id_company]);
        // поиск по метро
        if ($stations) {
            $expr = ['or'];
            foreach ($stations as $station) {
                $expr[] = "`ob`.`metro_titles` LIKE '%" . $station . "%'";
            }
            $query->andFilterWhere($expr);
        }

        // поиск по типу недвижимости
        if ($this->prop_type) {
            $query->andFilterWhere(['in', 'ob.property_type', $this->prop_type]);
        }

        // поиск по району
        if ($this->district2) {
            $query->andFilterWhere(['in', 'ob.district_id', $this->district2]);
        }

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Статус',
            'property_type' => 'Тип недвижимости',
            'prop_type' => 'Тип недвижимости',
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
            'district2' => 'Район',
            'metro' => 'Метро',
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
            'status' => 'Статус',
            'actual_date' => 'Дата',

            'date_from' => 'Дата с',
            'date_to' => 'Дата по',
            'floor_from' => 'Этаж',
            'floor_to' => 'Этаж по',
            'total_floor_from' => 'Всего этажей',
            'total_floor_to' => 'Всего этажей по',
            'price_from' => 'Стоимость',
            'price_to' => 'Стоимость',
            'pledge_from' => 'Залог',
            'pledge_to' => 'Залог',
            'release_date_from' => 'Освобождается',
            'release_date_to' => 'Освобождается',
        ];
    }
}
