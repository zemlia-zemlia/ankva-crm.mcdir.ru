<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\Client;

/**
 * ClientSearch represents the model behind the search form of `app\models\client\Client`.
 */
class ClientSearch extends Client
{
    public $staffname;
    public $date_from;
    public $date_to;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'balance', 'access_from', 'access_to',
                'demo', 'id_company', 'mobile', 'dop_tel', 'region', 'district', 'city_id',
                'typeproperty', 'price_from', 'price_to', 'client_type','staff_id', 'date_from', 'date_to' ], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email',
                'role', 'firstname', 'lastname', 'middlename', 'source', 'staffname' ], 'safe'],
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
        $query = Client::find()->joinWith('staff');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'created_at',
                    'mobile',
                    'source',
                    //'fullname',

                    'staffname' => [
                        'asc' => ['staff.username' => SORT_ASC],
                        'desc' => ['staff.username' => SORT_DESC],
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'balance' => $this->balance,
            'access_from' => $this->access_from,
            'access_to' => $this->access_to,
            'demo' => $this->demo,
            'id_company' => $this->id_company,
            'mobile' => $this->mobile,
            'dop_tel' => $this->dop_tel,
            'region' => $this->region,
            'district' => $this->district,
            'city_id' => $this->city_id,
            'typeproperty' => $this->typeproperty,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'client_type' => $this->client_type,

        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'staff.username', $this->staffname])
            ->andFilterWhere(['like', 'source', $this->source]);
        if (!empty($this->created_at) and !empty($this->created_at))
            $query->andFilterWhere(['and',['>', 'created_at', $this->date_from], ['<', 'created_at', $this->date_to]]);

        return $dataProvider;
    }
}
