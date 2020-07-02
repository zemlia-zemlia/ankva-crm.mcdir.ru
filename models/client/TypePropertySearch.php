<?php

namespace app\models\client;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TypeProperty;

/**
 * TypePropertySearch represents the model behind the search form of `app\models\TypeProperty`.
 */
class TypePropertySearch extends TypeProperty
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', 'id_company', 'feed_type'], 'integer'],
            [['name', 'city', 'reduced', 'rang', 'name_href', 'name_full'], 'safe'],
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
        $query = TypeProperty::find();

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
            'active' => $this->active,

            'feed_type' => $this->feed_type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'reduced', $this->reduced])
            ->andFilterWhere(['like', 'rang', $this->rang])
            ->andFilterWhere(['like', 'name_href', $this->name_href])
            ->andFilterWhere(['like', 'name_full', $this->name_full]);

        $query->andWhere(['id_company' => Yii::$app->user->identity->id_company]);

        return $dataProvider;
    }
}
