<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\Payments;

/**
 * PaymentsSearch represents the model behind the search form of `app\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user'], 'integer'],
            [['operation_id', 'amount', 'withdraw_amount', 'currency', 'datetime', 'sender', 'id_company', 'label', 'sha1_hash', 'notification_type'], 'safe'],
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
        $query = Payments::find();

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
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'operation_id', $this->operation_id])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'withdraw_amount', $this->withdraw_amount])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'datetime', $this->datetime])
            ->andFilterWhere(['like', 'sender', $this->sender])
            ->andFilterWhere(['like', 'id_company', $this->id_company])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'sha1_hash', $this->sha1_hash])
            ->andFilterWhere(['like', 'notification_type', $this->notification_type]);

        return $dataProvider;
    }
}
