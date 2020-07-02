<?php

namespace app\controllers;

use Yii;
use app\helpers\LocationHelper;
use yii\web\Controller;

class LocationController extends SiteController
{
    public function actionRegionSelectorChange()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->get();
            $region = $query['region'];

            $cities = LocationHelper::cityList($region);

            $cities_html = '<option value="">---</option>';

            foreach ($cities as $key => $value) {
                $cities_html .= '<option value="' . $key . '">' . $value . '</option>';
            }

            $city_selectbox = [
                'cities' => $cities_html,
                'disabled' => (!$region || count($cities) == 0) ? 1 : 0,
            ];

            return json_encode($city_selectbox);
        }

        return null;
    }
    public function actionCitySelectorChange()
    {
        if (Yii::$app->request->isAjax) {

            $query = Yii::$app->request->get();
//            var_dump($query);die;
            $city_id = $query['city'];

            $districts = LocationHelper::districtList($city_id);

            $districts_html = '';

            foreach ($districts as $key => $value) {
                $districts_html .= '<option value="' . $key . '">' . $value . '</option>';
            }

            $metro_html = LocationHelper::metroList($city_id);

            $result = [
                'districts' => $districts_html,
                'district_disabled' => (!$city_id || count($districts) == 0) ? 1 : 0,
                'metro' => $metro_html,
                'metro_disabled' => (!$city_id || $metro_html == '') ? 1 : 0,
            ];

            return json_encode($result);
        }

        return null;
    }
}