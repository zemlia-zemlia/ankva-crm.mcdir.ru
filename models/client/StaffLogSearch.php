<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\StaffLog;

/**
 * StaffLogSearch represents the model behind the search form of `app\models\client\StaffLog`.
 */
class StaffLogSearch extends StaffLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'staff_id', 'created_at'], 'integer'],
            [['ip', 'url', 'data'], 'safe'],
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
        $query = StaffLog::find();

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
            'user_id' => $this->user_id,
            'type' => $this->type,
            'staff_id' => $this->staff_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
