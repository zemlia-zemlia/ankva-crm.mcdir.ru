<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\ClientPayment;

/**
 * ClientPaymentSearch represents the model behind the search form of `app\models\client\ClientPayment`.
 */
class ClientPaymentSearch extends ClientPayment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'payment_id', 'staff_id', 'date', 'status', 'summ', 'type'], 'integer'],
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
        $query = ClientPayment::find();

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
            'client_id' => $this->client_id,
            'payment_id' => $this->payment_id,
            'staff_id' => $this->staff_id,
            'date' => $this->date,
            'status' => $this->status,
            'summ' => $this->summ,
            'type' => $this->type,
        ]);

        return $dataProvider;
    }
}
