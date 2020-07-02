<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pagesite;
use Yii;
/**
 * ArticlesSearch represents the model behind the search form of `app\models\Articles`.
 */
class PagesiteSearch extends Pagesite
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_company'], 'integer'],
            [['title', 'titlehref'], 'safe'],
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
        $query = Pagesite::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]

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
            'id_company' =>  Yii::$app->user->identity->id_company,

       //     'created_at' => $this->created_at,
       //     'updated_at' => $this->updated_at,
       //     'manager_added' => $this->manager_added,
       //     'manager_updated' => $this->manager_updated,
        ]);

        $query->andFilterWhere(['like', 'titlehref', $this->titlehref]);

        return $dataProvider;
    }
}
