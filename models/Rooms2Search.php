<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rooms2;

/**
 * Rooms2Search represents the model behind the search form of `app\models\Rooms2`.
 */
class Rooms2Search extends Rooms2
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'rooms', 'sale_parametr3', 'sale_parametr4', 'sale_parametr5', 'sale_parametr6', 'rent_parametr3', 'rent_parametr4', 'sale_room_parametr3', 'sale_room_parametr4', 'sale_room_parametr5', 'rent_room_parametr4', 'rent_room_parametr5', 'rent_room_parametr6', 'sale_home_parametr4', 'sale_home_parametr5', 'sale_home_parametr6', 'rent_home_parametr4', 'rent_home_parametr5', 'rent_home_parametr6', 'blackagent', 'id_task', 'id_ads'], 'integer'],
            [['avito_id', 'title', 'date_avito', 'is_company', 'pledge', 'description', 'href', 'seller', 'phone', 'city', 'region', 'addr', 'type', 'type_info', 'etazh', 'etazhnost', 'date_add', 'actual', 'source', 'yandex_id', 'sale_parametr1', 'sale_parametr2', 'rent_parametr1', 'rent_parametr2', 'sale_room_parametr1', 'sale_room_parametr2', 'sale_room_parametr6', 'rent_room_parametr1', 'rent_room_parametr2', 'rent_room_parametr3', 'rent_room_parametr7', 'sale_home_parametr1', 'sale_home_parametr2', 'sale_home_parametr3', 'sale_home_parametr7', 'rent_home_parametr1', 'rent_home_parametr2', 'rent_home_parametr3', 'rent_home_parametr7', 'rent_home_parametr8', 'sale_land_parametr1', 'sale_land_parametr2', 'sale_land_parametr3', 'sale_land_parametr4', 'rent_land_parametr1', 'rent_land_parametr2', 'rent_land_parametr3', 'rent_land_parametr4', 'sale_garage_parametr1', 'sale_garage_parametr2', 'sale_garage_parametr3', 'sale_garage_parametr4', 'sale_garage_parametr5', 'rent_garage_parametr1', 'rent_garage_parametr2', 'rent_garage_parametr3', 'rent_garage_parametr4', 'rent_garage_parametr5', 'rent_commerc_parametr1', 'rent_commerc_parametr2', 'rent_commerc_parametr3', 'rent_commerc_parametr4', 'rent_commerc_parametr5', 'sale_commerc_parametr1', 'sale_commerc_parametr2', 'sale_commerc_parametr3', 'sale_commerc_parametr4', 'sale_commerc_parametr5', 'dop', 'dop2', 'category_id', 'person_type', 'count_ads_same_phone', 'images'], 'safe'],
            [['metr'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Rooms2::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'rooms' => $this->rooms,
            'metr' => $this->metr,
            'date_add' => $this->date_add,
            'sale_parametr3' => $this->sale_parametr3,
            'sale_parametr4' => $this->sale_parametr4,
            'sale_parametr5' => $this->sale_parametr5,
            'sale_parametr6' => $this->sale_parametr6,
            'rent_parametr3' => $this->rent_parametr3,
            'rent_parametr4' => $this->rent_parametr4,
            'sale_room_parametr3' => $this->sale_room_parametr3,
            'sale_room_parametr4' => $this->sale_room_parametr4,
            'sale_room_parametr5' => $this->sale_room_parametr5,
            'rent_room_parametr4' => $this->rent_room_parametr4,
            'rent_room_parametr5' => $this->rent_room_parametr5,
            'rent_room_parametr6' => $this->rent_room_parametr6,
            'sale_home_parametr4' => $this->sale_home_parametr4,
            'sale_home_parametr5' => $this->sale_home_parametr5,
            'sale_home_parametr6' => $this->sale_home_parametr6,
            'rent_home_parametr4' => $this->rent_home_parametr4,
            'rent_home_parametr5' => $this->rent_home_parametr5,
            'rent_home_parametr6' => $this->rent_home_parametr6,
            'blackagent' => $this->blackagent,
            'id_task' => $this->id_task,
            'id_ads' => $this->id_ads,
        ]);

        $query->andFilterWhere(['like', 'avito_id', $this->avito_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'date_avito', $this->date_avito])
            ->andFilterWhere(['like', 'is_company', $this->is_company])
            ->andFilterWhere(['like', 'pledge', $this->pledge])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'href', $this->href])
            ->andFilterWhere(['like', 'seller', $this->seller])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'type_info', $this->type_info])
            ->andFilterWhere(['like', 'etazh', $this->etazh])
            ->andFilterWhere(['like', 'etazhnost', $this->etazhnost])
            ->andFilterWhere(['like', 'actual', $this->actual])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'yandex_id', $this->yandex_id])
            ->andFilterWhere(['like', 'sale_parametr1', $this->sale_parametr1])
            ->andFilterWhere(['like', 'sale_parametr2', $this->sale_parametr2])
            ->andFilterWhere(['like', 'rent_parametr1', $this->rent_parametr1])
            ->andFilterWhere(['like', 'rent_parametr2', $this->rent_parametr2])
            ->andFilterWhere(['like', 'sale_room_parametr1', $this->sale_room_parametr1])
            ->andFilterWhere(['like', 'sale_room_parametr2', $this->sale_room_parametr2])
            ->andFilterWhere(['like', 'sale_room_parametr6', $this->sale_room_parametr6])
            ->andFilterWhere(['like', 'rent_room_parametr1', $this->rent_room_parametr1])
            ->andFilterWhere(['like', 'rent_room_parametr2', $this->rent_room_parametr2])
            ->andFilterWhere(['like', 'rent_room_parametr3', $this->rent_room_parametr3])
            ->andFilterWhere(['like', 'rent_room_parametr7', $this->rent_room_parametr7])
            ->andFilterWhere(['like', 'sale_home_parametr1', $this->sale_home_parametr1])
            ->andFilterWhere(['like', 'sale_home_parametr2', $this->sale_home_parametr2])
            ->andFilterWhere(['like', 'sale_home_parametr3', $this->sale_home_parametr3])
            ->andFilterWhere(['like', 'sale_home_parametr7', $this->sale_home_parametr7])
            ->andFilterWhere(['like', 'rent_home_parametr1', $this->rent_home_parametr1])
            ->andFilterWhere(['like', 'rent_home_parametr2', $this->rent_home_parametr2])
            ->andFilterWhere(['like', 'rent_home_parametr3', $this->rent_home_parametr3])
            ->andFilterWhere(['like', 'rent_home_parametr7', $this->rent_home_parametr7])
            ->andFilterWhere(['like', 'rent_home_parametr8', $this->rent_home_parametr8])
            ->andFilterWhere(['like', 'sale_land_parametr1', $this->sale_land_parametr1])
            ->andFilterWhere(['like', 'sale_land_parametr2', $this->sale_land_parametr2])
            ->andFilterWhere(['like', 'sale_land_parametr3', $this->sale_land_parametr3])
            ->andFilterWhere(['like', 'sale_land_parametr4', $this->sale_land_parametr4])
            ->andFilterWhere(['like', 'rent_land_parametr1', $this->rent_land_parametr1])
            ->andFilterWhere(['like', 'rent_land_parametr2', $this->rent_land_parametr2])
            ->andFilterWhere(['like', 'rent_land_parametr3', $this->rent_land_parametr3])
            ->andFilterWhere(['like', 'rent_land_parametr4', $this->rent_land_parametr4])
            ->andFilterWhere(['like', 'sale_garage_parametr1', $this->sale_garage_parametr1])
            ->andFilterWhere(['like', 'sale_garage_parametr2', $this->sale_garage_parametr2])
            ->andFilterWhere(['like', 'sale_garage_parametr3', $this->sale_garage_parametr3])
            ->andFilterWhere(['like', 'sale_garage_parametr4', $this->sale_garage_parametr4])
            ->andFilterWhere(['like', 'sale_garage_parametr5', $this->sale_garage_parametr5])
            ->andFilterWhere(['like', 'rent_garage_parametr1', $this->rent_garage_parametr1])
            ->andFilterWhere(['like', 'rent_garage_parametr2', $this->rent_garage_parametr2])
            ->andFilterWhere(['like', 'rent_garage_parametr3', $this->rent_garage_parametr3])
            ->andFilterWhere(['like', 'rent_garage_parametr4', $this->rent_garage_parametr4])
            ->andFilterWhere(['like', 'rent_garage_parametr5', $this->rent_garage_parametr5])
            ->andFilterWhere(['like', 'rent_commerc_parametr1', $this->rent_commerc_parametr1])
            ->andFilterWhere(['like', 'rent_commerc_parametr2', $this->rent_commerc_parametr2])
            ->andFilterWhere(['like', 'rent_commerc_parametr3', $this->rent_commerc_parametr3])
            ->andFilterWhere(['like', 'rent_commerc_parametr4', $this->rent_commerc_parametr4])
            ->andFilterWhere(['like', 'rent_commerc_parametr5', $this->rent_commerc_parametr5])
            ->andFilterWhere(['like', 'sale_commerc_parametr1', $this->sale_commerc_parametr1])
            ->andFilterWhere(['like', 'sale_commerc_parametr2', $this->sale_commerc_parametr2])
            ->andFilterWhere(['like', 'sale_commerc_parametr3', $this->sale_commerc_parametr3])
            ->andFilterWhere(['like', 'sale_commerc_parametr4', $this->sale_commerc_parametr4])
            ->andFilterWhere(['like', 'sale_commerc_parametr5', $this->sale_commerc_parametr5])
            ->andFilterWhere(['like', 'dop', $this->dop])
            ->andFilterWhere(['like', 'dop2', $this->dop2])
            ->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['like', 'person_type', $this->person_type])
            ->andFilterWhere(['like', 'count_ads_same_phone', $this->count_ads_same_phone])
            ->andFilterWhere(['like', 'images', $this->images]);

        return $dataProvider;
    }
}
