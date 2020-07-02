<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\UserLog;

/**
 * UserLogfSearch represents the model behind the search form of `app\models\client\UserLog`.
 */
class UserLogfSearch extends UserLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'login'], 'integer'],
            [['date', 'browser', 'ip'], 'safe'],
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
        $query = UserLog::find();

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
            'date' => $this->date,
            'login' => $this->login,
        ]);

        $query->andFilterWhere(['like', 'browser', $this->browser])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
