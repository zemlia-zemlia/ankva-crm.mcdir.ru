<?php

namespace app\models\client;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\client\Staff;


/**
 * StaffSearch represents the model behind the search form of `app\models\client\Staff`.
 */
class StaffSearch extends Staff
{

    public $fullName;
    public $officeName;
    public $cityName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',  'mobile'], 'integer'],
            [['fullName', 'officeName', 'firstname', 'lastname', 'middlename', 'birthday', 'passport', 'parent_info', 'cityName', 'office', 'userStatus'], 'safe'],
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
        $query = Staff::find()->joinWith('user')->joinWith('city');

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

                    'officeName' => [
                        'asc' => ['office.name' => SORT_ASC],
                        'desc' => ['office.name' => SORT_DESC],
                        'default' => SORT_DESC,

                    ],
                    'cityName' => [
                        'asc' => ['city.name' => SORT_ASC],
                        'desc' => ['city.name' => SORT_DESC],
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

            'mobile' => $this->mobile,
            'birthday' => $this->birthday,
//            'userStatus' => $this->userStatus,
        ]);

        $query
            ->andWhere('firstname LIKE "%' . $this->fullName . '%" ' .
                'OR lastname LIKE "%' . $this->fullName . '%"'
            )
            ->andFilterWhere(['like', 'passport', $this->passport])
            ->andFilterWhere(['like', 'parent_info', $this->parent_info])
            ->andFilterWhere(['like', 'office.name', $this->officeName])
            ->andFilterWhere(['like', 'city.name', $this->cityName]);
//
        return $dataProvider;
    }
}
