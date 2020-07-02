<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\RealtyObject;

/**
 * RealtyObjectSearch represents the model behind the search form of `app\models\client\RealtyObject`.
 */
class RealtyObjectSearch extends RealtyObject
{

    public $staffname;
    public $address;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_type', 'region_id', 'city_id', 'district_id',  'floor', 'total_floor', 'total_area',
                'living_area', 'kitchen_area',  'price', 'staff',  'status', 'created_at', 'updated_at'], 'integer'],
            [['street', 'home', 'name', 'phone', 'phone_2', 'description', 'service_info', 'staffname', 'images', 'id', 'address', 'district_id','source'], 'safe'],
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
        $query = RealtyObject::find()->joinWith('staffObj')->joinWith(['city'])->joinWith(['region']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' =>
            [
                'staffname' => [
                    'asc' => ['staff.lastname' => SORT_ASC],
                    'desc' => ['staff.lastname' => SORT_DESC],
                    'default' => SORT_DESC,

                ],
                'address' => [
                    'asc' => ['region.name' => SORT_ASC],
                    'desc' => ['region.name' => SORT_DESC],
                    'default' => SORT_DESC,

                ],
            ]
                ]
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
            'property_type' => $this->property_type,

            'region_id' => $this->region_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,

            'floor' => $this->floor,
            'total_floor' => $this->total_floor,
            'total_area' => $this->total_area,
            'living_area' => $this->living_area,
            'kitchen_area' => $this->kitchen_area,

            'price' => $this->price,
            'staff' => $this->staff,
            'source' => $this->source,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andWhere('staff.lastname LIKE "%' . $this->staffname . '%" ' .
            'OR staff.firstname LIKE "%' . $this->staffname . '%"'
        )
            ->andWhere('city.name LIKE "%' . $this->address . '%" ' .
                'OR region.name LIKE "%' . $this->address . '%"' . 'OR street LIKE "%' . $this->address . '%" '
            )
        ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'home', $this->home])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'phone_2', $this->phone_2])
            ->andFilterWhere(['like', 'description', $this->description]);


        return $dataProvider;
    }
}
