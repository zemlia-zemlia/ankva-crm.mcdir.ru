<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\ClientNotes;

/**
 * ClientNotesSearch represents the model behind the search form of `app\models\client\ClientNotes`.
 */
class ClientNotesSearch extends ClientNotes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'client_id', 'date'], 'integer'],
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
        $query = ClientNotes::find();

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
            'staff_id' => $this->staff_id,
            'client_id' => $this->client_id,
            'date' => $this->date,
            'message' => $this->message,
        ]);

        return $dataProvider;
    }
}
