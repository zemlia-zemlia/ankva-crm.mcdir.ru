<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Newscrm;

/**
 * NewscrmSearch represents the model behind the search form of `app\models\Newscrm`.
 */
class NewscrmSearch extends Newscrm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_post', 'id_tag'], 'integer'],
            [['title', 'message'], 'safe'],
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
        $query = Newscrm::find();

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
            'id_post' => $this->id_post,

            'id_tag' => $this->id_tag,
       //     'created_at' => $this->created_at,
       //     'updated_at' => $this->updated_at,
       //     'manager_added' => $this->manager_added,
       //     'manager_updated' => $this->manager_updated,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
