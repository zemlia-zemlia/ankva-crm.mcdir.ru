<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rooms_export".
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
 * @property int $id_ads
 */
class RoomsExport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rooms_export';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'avito_id', 'title', 'date_avito', 'is_company', 'price', 'pledge', 'description', 'href', 'seller', 'phone', 'city', 'region', 'addr', 'type', 'type_info', 'rooms', 'etazh', 'etazhnost', 'metr', 'actual', 'source', 'yandex_id', 'sale_parametr1', 'sale_parametr2', 'sale_parametr3', 'sale_parametr4', 'sale_parametr5', 'sale_parametr6', 'rent_parametr1', 'rent_parametr2', 'rent_parametr3', 'rent_parametr4', 'sale_room_parametr1', 'sale_room_parametr2', 'sale_room_parametr3', 'sale_room_parametr4', 'sale_room_parametr5', 'sale_room_parametr6', 'rent_room_parametr1', 'rent_room_parametr2', 'rent_room_parametr3', 'rent_room_parametr4', 'rent_room_parametr5', 'rent_room_parametr6', 'rent_room_parametr7', 'sale_home_parametr1', 'sale_home_parametr2', 'sale_home_parametr3', 'sale_home_parametr4', 'sale_home_parametr5', 'sale_home_parametr6', 'sale_home_parametr7', 'rent_home_parametr1', 'rent_home_parametr2', 'rent_home_parametr3', 'rent_home_parametr4', 'rent_home_parametr5', 'rent_home_parametr6', 'rent_home_parametr7', 'rent_home_parametr8', 'sale_land_parametr1', 'sale_land_parametr2', 'sale_land_parametr3', 'sale_land_parametr4', 'rent_land_parametr1', 'rent_land_parametr2', 'rent_land_parametr3', 'rent_land_parametr4', 'sale_garage_parametr1', 'sale_garage_parametr2', 'sale_garage_parametr3', 'sale_garage_parametr4', 'sale_garage_parametr5', 'rent_garage_parametr1', 'rent_garage_parametr2', 'rent_garage_parametr3', 'rent_garage_parametr4', 'rent_garage_parametr5', 'rent_commerc_parametr1', 'rent_commerc_parametr2', 'rent_commerc_parametr3', 'rent_commerc_parametr4', 'rent_commerc_parametr5', 'sale_commerc_parametr1', 'sale_commerc_parametr2', 'sale_commerc_parametr3', 'sale_commerc_parametr4', 'sale_commerc_parametr5', 'dop', 'dop2', 'category_id', 'person_type', 'count_ads_same_phone', 'blackagent', 'images', 'id_task', 'id_ads'], 'required'],
            [['id', 'price', 'rooms', 'sale_parametr3', 'sale_parametr4', 'sale_parametr5', 'sale_parametr6', 'rent_parametr3', 'rent_parametr4', 'sale_room_parametr3', 'sale_room_parametr4', 'sale_room_parametr5', 'rent_room_parametr4', 'rent_room_parametr5', 'rent_room_parametr6', 'sale_home_parametr4', 'sale_home_parametr5', 'sale_home_parametr6', 'rent_home_parametr4', 'rent_home_parametr5', 'rent_home_parametr6', 'blackagent', 'id_task', 'id_ads'], 'integer'],
            [['is_company', 'pledge', 'description', 'etazh', 'etazhnost', 'actual', 'source', 'yandex_id', 'sale_parametr1', 'sale_parametr2', 'rent_parametr1', 'rent_parametr2', 'sale_room_parametr1', 'sale_room_parametr2', 'sale_room_parametr6', 'rent_room_parametr1', 'rent_room_parametr2', 'rent_room_parametr3', 'rent_room_parametr7', 'sale_home_parametr1', 'sale_home_parametr2', 'sale_home_parametr3', 'sale_home_parametr7', 'rent_home_parametr1', 'rent_home_parametr2', 'rent_home_parametr3', 'rent_home_parametr7', 'rent_home_parametr8', 'sale_land_parametr1', 'sale_land_parametr2', 'sale_land_parametr3', 'sale_land_parametr4', 'rent_land_parametr1', 'rent_land_parametr2', 'rent_land_parametr3', 'rent_land_parametr4', 'sale_garage_parametr1', 'sale_garage_parametr2', 'sale_garage_parametr3', 'sale_garage_parametr4', 'sale_garage_parametr5', 'rent_garage_parametr1', 'rent_garage_parametr2', 'rent_garage_parametr3', 'rent_garage_parametr4', 'rent_garage_parametr5', 'rent_commerc_parametr1', 'rent_commerc_parametr2', 'rent_commerc_parametr3', 'rent_commerc_parametr4', 'rent_commerc_parametr5', 'sale_commerc_parametr1', 'sale_commerc_parametr2', 'sale_commerc_parametr3', 'sale_commerc_parametr4', 'sale_commerc_parametr5', 'dop', 'dop2', 'category_id', 'person_type', 'count_ads_same_phone', 'images'], 'string'],
            [['metr'], 'number'],
            [['date_add'], 'safe'],
            [['avito_id'], 'string', 'max' => 25],
            [['title', 'href', 'seller', 'city', 'region', 'addr', 'type', 'type_info'], 'string', 'max' => 255],
            [['date_avito'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'avito_id' => 'Avito ID',
            'title' => 'Title',
            'date_avito' => 'Date Avito',
            'is_company' => 'Is Company',
            'price' => 'Price',
            'pledge' => 'Pledge',
            'description' => 'Description',
            'href' => 'Href',
            'seller' => 'Seller',
            'phone' => 'Phone',
            'city' => 'City',
            'region' => 'Region',
            'addr' => 'Addr',
            'type' => 'Type',
            'type_info' => 'Type Info',
            'rooms' => 'Rooms',
            'etazh' => 'Etazh',
            'etazhnost' => 'Etazhnost',
            'metr' => 'Metr',
            'date_add' => 'Date Add',
            'actual' => 'Actual',
            'source' => 'Source',
            'yandex_id' => 'Yandex ID',
            'sale_parametr1' => 'Sale Parametr1',
            'sale_parametr2' => 'Sale Parametr2',
            'sale_parametr3' => 'Sale Parametr3',
            'sale_parametr4' => 'Sale Parametr4',
            'sale_parametr5' => 'Sale Parametr5',
            'sale_parametr6' => 'Sale Parametr6',
            'rent_parametr1' => 'Rent Parametr1',
            'rent_parametr2' => 'Rent Parametr2',
            'rent_parametr3' => 'Rent Parametr3',
            'rent_parametr4' => 'Rent Parametr4',
            'sale_room_parametr1' => 'Sale Room Parametr1',
            'sale_room_parametr2' => 'Sale Room Parametr2',
            'sale_room_parametr3' => 'Sale Room Parametr3',
            'sale_room_parametr4' => 'Sale Room Parametr4',
            'sale_room_parametr5' => 'Sale Room Parametr5',
            'sale_room_parametr6' => 'Sale Room Parametr6',
            'rent_room_parametr1' => 'Rent Room Parametr1',
            'rent_room_parametr2' => 'Rent Room Parametr2',
            'rent_room_parametr3' => 'Rent Room Parametr3',
            'rent_room_parametr4' => 'Rent Room Parametr4',
            'rent_room_parametr5' => 'Rent Room Parametr5',
            'rent_room_parametr6' => 'Rent Room Parametr6',
            'rent_room_parametr7' => 'Rent Room Parametr7',
            'sale_home_parametr1' => 'Sale Home Parametr1',
            'sale_home_parametr2' => 'Sale Home Parametr2',
            'sale_home_parametr3' => 'Sale Home Parametr3',
            'sale_home_parametr4' => 'Sale Home Parametr4',
            'sale_home_parametr5' => 'Sale Home Parametr5',
            'sale_home_parametr6' => 'Sale Home Parametr6',
            'sale_home_parametr7' => 'Sale Home Parametr7',
            'rent_home_parametr1' => 'Rent Home Parametr1',
            'rent_home_parametr2' => 'Rent Home Parametr2',
            'rent_home_parametr3' => 'Rent Home Parametr3',
            'rent_home_parametr4' => 'Rent Home Parametr4',
            'rent_home_parametr5' => 'Rent Home Parametr5',
            'rent_home_parametr6' => 'Rent Home Parametr6',
            'rent_home_parametr7' => 'Rent Home Parametr7',
            'rent_home_parametr8' => 'Rent Home Parametr8',
            'sale_land_parametr1' => 'Sale Land Parametr1',
            'sale_land_parametr2' => 'Sale Land Parametr2',
            'sale_land_parametr3' => 'Sale Land Parametr3',
            'sale_land_parametr4' => 'Sale Land Parametr4',
            'rent_land_parametr1' => 'Rent Land Parametr1',
            'rent_land_parametr2' => 'Rent Land Parametr2',
            'rent_land_parametr3' => 'Rent Land Parametr3',
            'rent_land_parametr4' => 'Rent Land Parametr4',
            'sale_garage_parametr1' => 'Sale Garage Parametr1',
            'sale_garage_parametr2' => 'Sale Garage Parametr2',
            'sale_garage_parametr3' => 'Sale Garage Parametr3',
            'sale_garage_parametr4' => 'Sale Garage Parametr4',
            'sale_garage_parametr5' => 'Sale Garage Parametr5',
            'rent_garage_parametr1' => 'Rent Garage Parametr1',
            'rent_garage_parametr2' => 'Rent Garage Parametr2',
            'rent_garage_parametr3' => 'Rent Garage Parametr3',
            'rent_garage_parametr4' => 'Rent Garage Parametr4',
            'rent_garage_parametr5' => 'Rent Garage Parametr5',
            'rent_commerc_parametr1' => 'Rent Commerc Parametr1',
            'rent_commerc_parametr2' => 'Rent Commerc Parametr2',
            'rent_commerc_parametr3' => 'Rent Commerc Parametr3',
            'rent_commerc_parametr4' => 'Rent Commerc Parametr4',
            'rent_commerc_parametr5' => 'Rent Commerc Parametr5',
            'sale_commerc_parametr1' => 'Sale Commerc Parametr1',
            'sale_commerc_parametr2' => 'Sale Commerc Parametr2',
            'sale_commerc_parametr3' => 'Sale Commerc Parametr3',
            'sale_commerc_parametr4' => 'Sale Commerc Parametr4',
            'sale_commerc_parametr5' => 'Sale Commerc Parametr5',
            'dop' => 'Dop',
            'dop2' => 'Dop2',
            'category_id' => 'Category ID',
            'person_type' => 'Person Type',
            'count_ads_same_phone' => 'Count Ads Same Phone',
            'blackagent' => 'Blackagent',
            'images' => 'Images',
            'id_task' => 'Id Task',
            'id_ads' => 'Id Ads',
        ];
    }
}
