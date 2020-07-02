<?php

namespace app\models\client;

use yii\base\Model;
use app\models\User;
use yii\data\ActiveDataProvider;
use app\models\client\Client;

/**
 * ClientSearch represents the model behind the search form of `app\models\client\Client`.
 */
class ClientSearch extends Client
{
    public $fullName;
    public $staffname;
    public $date_from;
    public $date_to;
    public  $cityAndRegion;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status',  'mobile', 'dop_tel', 'region', 'district', 'city_id',
                'typeproperty', 'price_from', 'price_to', 'client_type','staff_id', 'date_from', 'date_to' ], 'integer'],
            [['firstname', 'lastname', 'middlename', 'source', 'staffname' , 'fullName', 'cityAndRegion'], 'safe'],
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
        $query = Client::find()->joinWith('staff')->joinWith(['city'])->joinWith(['regionObj'])->joinWith(['userObj']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    //'created_at',
//                    'mobile',
                   // 'source',
                    'fullName' => [
                'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],

                'default' => SORT_ASC
            ],

                    'staffname' => [
                        'asc' => ['staff.lastname' => SORT_ASC],
                        'desc' => ['staff.lastname' => SORT_DESC],
                        'default' => SORT_DESC,

                    ],
                    'cityAndRegion' => [
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

//            $query->joinWith(['city']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'status' => $this->status,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'balance' => $this->balance,
//            'access_from' => $this->access_from,
//            'access_to' => $this->access_to,
//            'demo' => $this->demo,
//            'id_company' => $this->id_company,
//            'mobile' => $this->mobile,
            'dop_tel' => $this->dop_tel,
            'region' => $this->region,
            'district' => $this->district,
//            'city_id' => $this->city_id,
            'typeproperty' => $this->typeproperty,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'client_type' => $this->client_type,
            'staff.id' => $this->staff_id,
            'client.status' => $this->status

        ]);

        $query
            ->andWhere('client.firstname LIKE "%' . $this->fullName . '%" ' .
                'OR client.lastname LIKE "%' . $this->fullName . '%"'
            )
            ->andWhere('city.name LIKE "%' . $this->cityAndRegion . '%" ' .
                'OR region.name LIKE "%' . $this->cityAndRegion . '%"'
            )
            ->andWhere('staff.lastname LIKE "%' . $this->staffname . '%" ' .
                'OR staff.firstname LIKE "%' . $this->staffname . '%"'
            )


//            ->andFilterWhere(['like', 'staff.lastname', $this->staffname])
//            ->andFilterWhere(['like', 'city.name', $this->cityAndRegion])
//            ->andFilterWhere(['like', 'region.name', $this->cityAndRegion])
            ->andFilterWhere(['like', 'user.username', $this->mobile]);
//        if (!empty($this->created_at) and !empty($this->created_at))
//            $query->andFilterWhere(['and',['>', 'created_at', $this->date_from], ['<', 'created_at', $this->date_to]]);

        return $dataProvider;
    }
}
