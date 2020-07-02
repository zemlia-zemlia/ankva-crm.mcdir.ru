<?php

namespace app\helpers;

use app\models\Country;
use app\models\City;
use app\models\District;
use app\models\MetroStation;
use app\models\MoscowMetro;
use app\models\MoscowMetroLine;
use app\models\Region;
use app\models\SpbMetro;
use app\models\SpbMetroLine;
use yii\helpers\ArrayHelper;

class LocationHelper
{
    public static function countryList()
    {
        $country = Country::find()->select(['id', 'name'])->asArray()->all();
        return ArrayHelper::map($country, 'id', 'name');
    }
    public static function regionList()
    {
        $regions = Region::find()->select(['id', 'name'])->asArray()->where(['country_id' => 1])->all();
        return ArrayHelper::map($regions, 'id', 'name');
    }


    public static function regionName($region_id)
    {
        /** @var Region $region */
        $region = Region::findOne($region_id);
        return $region->name;
    }


    public static function getRegionByName($name)
    {
        $region = Region::find()->where(['name' => $name])->one();
        return $region ? $region->id : '';
    }


    public static function cityList($region_id = null)
    {
        if ($region_id) {
            $cities = City::find()->select(['id', 'name'])->asArray()->where(['region_id' => $region_id])->all();
            return ArrayHelper::map($cities, 'id', 'name');
        }
        return [];
    }


    public static function cityName($city_id)
    {
        /** @var City $city */
        $city = City::findOne($city_id);
        return $city->name;
    }


    public static function getCityByName($name, $region_id)
    {
        $city = City::find()->where(['name' => $name, 'region_id' => $region_id])->one();
        return $city ? $city->id : '';
    }


    public static function districtList($city_id = null)
    {
        if ($city_id) {

            /** @var City $city */
            if ($city = City::findOne($city_id)) {

                $districts = District::find()->select(['id', 'login'])->asArray()->where(['citys' => $city->name])->all();
                return ArrayHelper::map($districts, 'id', 'login');
            }
        }
        return [];
    }


    public static function districtName($district_id)
    {
        if ($district = District::findOne($district_id)) {
            return $district->login;
        }
        return '';
    }


    public static function metroList($city_id = null, $selected_stations = null)
    {
        if ($city_id == null)$city_id = 1;
        /** @var City $city */
        $city = City::findOne($city_id);
//var_dump($city_id);die;
        if (is_array($selected_stations)) {
            $selected = array_map(function ($value) {
                return intval($value);
            }, $selected_stations);
        } else {
            $selected = [];
        }

        $select = '';

        if ($city->name == 'Москва') {

            $metro = MoscowMetro::find()->all();
            $metro_line = MoscowMetroLine::find()->all();

            /** @var MoscowMetroLine $line */
            foreach ($metro_line as $line) {

                $select .= '<optgroup label="' . $line->title . '">';

                $stations = array_filter($metro, function (MoscowMetro $metro_item) use ($line) {

                    if ($metro_item->loc_metro_line_id == $line->id) {
                        return true;
                    }
                    return false;
                });

                /** @var MoscowMetro $station */
                foreach ($stations as $station) {

                    $select .= '<option data-bgcolor="' . $line->color . '" value="' . $station->id . '"' .
                        (in_array($station->id, $selected) ? ' selected="selected"' : '') . '>' . $station->title . '</option>';
                }

                $select .= '</optgroup>';

            }
        } elseif ($city->name == 'Санкт-Петербург') {

            $metro = SpbMetro::find()->all();
            $metro_line = SpbMetroLine::find()->all();

            /** @var MoscowMetroLine $line */
            foreach ($metro_line as $line) {

                $select .= '<optgroup label="' . $line->title . '">';

                $stations = array_filter($metro, function (SpbMetro $metro_item) use ($line) {

                    if ($metro_item->loc_metro_line_id == $line->id) {
                        return true;
                    }
                    return false;
                });

                /** @var MoscowMetro $station */
                foreach ($stations as $station) {

                    $select .= '<option data-bgcolor="' . $line->color . '" value="' . $station->id . '"' .
                        (in_array($station->id, $selected) ? ' selected="selected"' : '') . '>' . $station->title . '</option>';
                }

                $select .= '</optgroup>';

            }
        } else {

            $stations = MetroStation::find()->where(['city' => $city->name])->all();
            // $metro_line = SpbMetroLine::find()->all();

            if ($stations) {

                /** @var MetroStation $station */
                foreach ($stations as $station) {

                    $select .= '<option data-bgcolor="' . $station->color . '" value="' . $station->id . '"' .
                        (in_array($station->id, $selected) ? ' selected="selected"' : '') . '>' . $station->title . '</option>';
                }
            }
        }

        return $select;
    }

    public static function metroStationName($city_id, $station_id)
    {
        /** @var City $city */
        $city = City::findOne($city_id);

        if ($city->name == 'Москва') {

            $station = MoscowMetro::findOne($station_id);
            return $station->title;
        }

        return '';
    }
}