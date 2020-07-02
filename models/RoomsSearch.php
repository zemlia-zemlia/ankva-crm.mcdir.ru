<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rooms;
use app\models\Black;

/**
 * RoomsSearch represents the model behind the search form of `app\models\Rooms`.
 */
class RoomsSearch extends Rooms
{
    public $condition = null;

    public function __construct($condition = null, array $config = [])
    {
        parent::__construct($config);
        if ($condition) {
            $this->condition = $condition;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price', 'rooms', 'sale_parametr3', 'sale_parametr4', 'sale_parametr5', 'sale_parametr6', 'rent_parametr3', 'rent_parametr4', 'sale_room_parametr3', 'sale_room_parametr4', 'sale_room_parametr5', 'rent_room_parametr4', 'rent_room_parametr5', 'rent_room_parametr6', 'sale_home_parametr4', 'sale_home_parametr5', 'sale_home_parametr6', 'rent_home_parametr4', 'rent_home_parametr5', 'rent_home_parametr6', 'blackagent', 'id_task'], 'integer'],
            [['avito_id', 'title', 'phone_protected', 'km_do_metro', 'date_avito', 'is_company', 'pledge', 'description', 'href', 'seller', 'phone', 'city', 'region', 'addr', 'type', 'type_info', 'etazh', 'etazhnost', 'date_add', 'actual', 'source', 'yandex_id', 'sale_parametr1', 'sale_parametr2', 'rent_parametr1', 'rent_parametr2', 'sale_room_parametr1', 'sale_room_parametr2', 'sale_room_parametr6', 'rent_room_parametr1', 'rent_room_parametr2', 'rent_room_parametr3', 'rent_room_parametr7', 'sale_home_parametr1', 'sale_home_parametr2', 'sale_home_parametr3', 'sale_home_parametr7', 'rent_home_parametr1', 'rent_home_parametr2', 'rent_home_parametr3', 'rent_home_parametr7', 'rent_home_parametr8', 'sale_land_parametr1', 'sale_land_parametr2', 'sale_land_parametr3', 'sale_land_parametr4', 'rent_land_parametr1', 'rent_land_parametr2', 'rent_land_parametr3', 'rent_land_parametr4', 'sale_garage_parametr1', 'sale_garage_parametr2', 'sale_garage_parametr3', 'sale_garage_parametr4', 'sale_garage_parametr5', 'rent_garage_parametr1', 'rent_garage_parametr2', 'rent_garage_parametr3', 'rent_garage_parametr4', 'rent_garage_parametr5', 'rent_commerc_parametr1', 'rent_commerc_parametr2', 'rent_commerc_parametr3', 'rent_commerc_parametr4', 'rent_commerc_parametr5', 'sale_commerc_parametr1', 'sale_commerc_parametr2', 'sale_commerc_parametr3', 'sale_commerc_parametr4', 'sale_commerc_parametr5', 'dop', 'dop2', 'category_id', 'person_type', 'count_ads_same_phone', 'images'], 'safe'],
            [['metr'], 'number'],
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
        $query = Rooms::find();

        $companyRooms = CompanyRoom::find()->select('parser_id')->asArray()->column();
        $listBlack = Black::find()->select('phone')->asArray()->where(['id_user' => Yii::$app->user->id])->column();

        if (count($companyRooms) > 0) {
            $query->andWhere(['not in', 'id', $companyRooms]);
        }

        if (!Yii::$app->user->isGuest) {
            if (count($listBlack) > 0) {
                $query->andFilterWhere(['not in', 'phone', $listBlack]);
            }
        }

        if ($this->condition) {
            $query->andWhere($this->condition);
        }

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
            'price' => $this->price,
            'rooms' => $this->rooms,
            'metr' => $this->metr,
            'date_add' => $this->date_add,
            'phone' => $this->phone,
            'sale_parametr3' => $this->sale_parametr3,
            'sale_parametr4' => $this->sale_parametr4,
            'sale_parametr5' => $this->sale_parametr5,
            'sale_parametr6' => $this->sale_parametr6,
            'rent_parametr3' => $this->rent_parametr3,
            'rent_parametr4' => $this->rent_parametr4,
            'sale_room_parametr3' => $this->sale_room_parametr3,
            'sale_room_parametr4' => $this->sale_room_parametr4,
            'sale_room_parametr5' => $this->sale_room_parametr5,
            'rent_room_parametr4' => $this->rent_room_parametr4,
            'rent_room_parametr5' => $this->rent_room_parametr5,
            'rent_room_parametr6' => $this->rent_room_parametr6,
            'sale_home_parametr4' => $this->sale_home_parametr4,
            'sale_home_parametr5' => $this->sale_home_parametr5,
            'sale_home_parametr6' => $this->sale_home_parametr6,
            'rent_home_parametr4' => $this->rent_home_parametr4,
            'rent_home_parametr5' => $this->rent_home_parametr5,
            'rent_home_parametr6' => $this->rent_home_parametr6,
            'blackagent' => $this->blackagent,
            'id_task' => $this->id_task,
        ]);

        $query->andFilterWhere(['like', 'avito_id', $this->avito_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'date_avito', $this->date_avito])
            ->andFilterWhere(['like', 'is_company', $this->is_company])
            ->andFilterWhere(['like', 'pledge', $this->pledge])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'href', $this->href])
            ->andFilterWhere(['like', 'seller', $this->seller])
            // ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'type_info', $this->type_info])
            ->andFilterWhere(['like', 'etazh', $this->etazh])
            ->andFilterWhere(['like', 'etazhnost', $this->etazhnost])
            ->andFilterWhere(['like', 'actual', $this->actual])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'yandex_id', $this->yandex_id])
            ->andFilterWhere(['like', 'sale_parametr1', $this->sale_parametr1])
            ->andFilterWhere(['like', 'sale_parametr2', $this->sale_parametr2])
            ->andFilterWhere(['like', 'rent_parametr1', $this->rent_parametr1])
            ->andFilterWhere(['like', 'rent_parametr2', $this->rent_parametr2])
            ->andFilterWhere(['like', 'sale_room_parametr1', $this->sale_room_parametr1])
            ->andFilterWhere(['like', 'sale_room_parametr2', $this->sale_room_parametr2])
            ->andFilterWhere(['like', 'sale_room_parametr6', $this->sale_room_parametr6])
            ->andFilterWhere(['like', 'rent_room_parametr1', $this->rent_room_parametr1])
            ->andFilterWhere(['like', 'rent_room_parametr2', $this->rent_room_parametr2])
            ->andFilterWhere(['like', 'rent_room_parametr3', $this->rent_room_parametr3])
            ->andFilterWhere(['like', 'rent_room_parametr7', $this->rent_room_parametr7])
            ->andFilterWhere(['like', 'sale_home_parametr1', $this->sale_home_parametr1])
            ->andFilterWhere(['like', 'sale_home_parametr2', $this->sale_home_parametr2])
            ->andFilterWhere(['like', 'sale_home_parametr3', $this->sale_home_parametr3])
            ->andFilterWhere(['like', 'sale_home_parametr7', $this->sale_home_parametr7])
            ->andFilterWhere(['like', 'rent_home_parametr1', $this->rent_home_parametr1])
            ->andFilterWhere(['like', 'rent_home_parametr2', $this->rent_home_parametr2])
            ->andFilterWhere(['like', 'rent_home_parametr3', $this->rent_home_parametr3])
            ->andFilterWhere(['like', 'rent_home_parametr7', $this->rent_home_parametr7])
            ->andFilterWhere(['like', 'rent_home_parametr8', $this->rent_home_parametr8])
            ->andFilterWhere(['like', 'sale_land_parametr1', $this->sale_land_parametr1])
            ->andFilterWhere(['like', 'sale_land_parametr2', $this->sale_land_parametr2])
            ->andFilterWhere(['like', 'sale_land_parametr3', $this->sale_land_parametr3])
            ->andFilterWhere(['like', 'sale_land_parametr4', $this->sale_land_parametr4])
            ->andFilterWhere(['like', 'rent_land_parametr1', $this->rent_land_parametr1])
            ->andFilterWhere(['like', 'rent_land_parametr2', $this->rent_land_parametr2])
            ->andFilterWhere(['like', 'rent_land_parametr3', $this->rent_land_parametr3])
            ->andFilterWhere(['like', 'rent_land_parametr4', $this->rent_land_parametr4])
            ->andFilterWhere(['like', 'sale_garage_parametr1', $this->sale_garage_parametr1])
            ->andFilterWhere(['like', 'sale_garage_parametr2', $this->sale_garage_parametr2])
            ->andFilterWhere(['like', 'sale_garage_parametr3', $this->sale_garage_parametr3])
            ->andFilterWhere(['like', 'sale_garage_parametr4', $this->sale_garage_parametr4])
            ->andFilterWhere(['like', 'sale_garage_parametr5', $this->sale_garage_parametr5])
            ->andFilterWhere(['like', 'rent_garage_parametr1', $this->rent_garage_parametr1])
            ->andFilterWhere(['like', 'rent_garage_parametr2', $this->rent_garage_parametr2])
            ->andFilterWhere(['like', 'rent_garage_parametr3', $this->rent_garage_parametr3])
            ->andFilterWhere(['like', 'rent_garage_parametr4', $this->rent_garage_parametr4])
            ->andFilterWhere(['like', 'rent_garage_parametr5', $this->rent_garage_parametr5])
            ->andFilterWhere(['like', 'rent_commerc_parametr1', $this->rent_commerc_parametr1])
            ->andFilterWhere(['like', 'rent_commerc_parametr2', $this->rent_commerc_parametr2])
            ->andFilterWhere(['like', 'rent_commerc_parametr3', $this->rent_commerc_parametr3])
            ->andFilterWhere(['like', 'rent_commerc_parametr4', $this->rent_commerc_parametr4])
            ->andFilterWhere(['like', 'rent_commerc_parametr5', $this->rent_commerc_parametr5])
            ->andFilterWhere(['like', 'sale_commerc_parametr1', $this->sale_commerc_parametr1])
            ->andFilterWhere(['like', 'sale_commerc_parametr2', $this->sale_commerc_parametr2])
            ->andFilterWhere(['like', 'sale_commerc_parametr3', $this->sale_commerc_parametr3])
            ->andFilterWhere(['like', 'sale_commerc_parametr4', $this->sale_commerc_parametr4])
            ->andFilterWhere(['like', 'sale_commerc_parametr5', $this->sale_commerc_parametr5])
            ->andFilterWhere(['like', 'dop', $this->dop])
            ->andFilterWhere(['like', 'km_do_metro', $this->km_do_metro])
            ->andFilterWhere(['like', 'phone_protected', $this->dop])

            ->andFilterWhere(['like', 'dop2', $this->dop2])
            ->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['like', 'person_type', $this->person_type])
            ->andFilterWhere(['like', 'count_ads_same_phone', $this->count_ads_same_phone])
            ->andFilterWhere(['like', 'images', $this->images]);

        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function filter($params) {
        
        if ( !Yii::$app->user->isGuest ) {
            $currentUser = Yii::$app->user->identity->id;
            $listBlack = Black::find()->select('phone')->asArray()->where(['id_user' => $currentUser])->column();
        }

        $companyRooms = CompanyRoom::find()->select('parser_id')->asArray()->column();
        
        $query = Rooms::find()
            ->filterWhere([
                'cat2_id' => $params['catSearch'],
                'nedvigimost_type_id' => $params['typeAds'],
                'source' => $params['sourceSearch'],
                'sale_parametr1' => @$params['saleparametr1'],
                'sale_parametr2' => @$params['saleparametr2'],
                'sale_parametr7' => @$params['saleparametr7'],
                'rent_parametr1' => @$params['rentparametr1'],
                'rent_parametr2' => @$params['rentparametr2'],
                'rent_parametr7' => @$params['rentparametr7'],
                'sale_room_parametr1' => @$params['saleroomparametr1'],
                'sale_room_parametr2' => @$params['saleroomparametr2'],
                'rent_room_parametr2' => @$params['rentroomparametr2'],
                'rent_room_parametr3' => @$params['rentroomparametr3'],
                'rent_room_parametr8' => @$params['rentroomparametr8'],
                'sale_home_parametr1' => @$params['salehomeparametr1'],
                'rent_home_parametr1' => @$params['renthomeparametr1'],
                'rent_home_parametr9' => @$params['renthomeparametr9'],
                'sale_land_parametr1' => @$params['salelandparametr1'],
                'rent_land_parametr1' => @$params['rentlandparametr1'],
                'sale_commerc_parametr1' => @$params['salecommercparametr1'],
                'rent_commerc_parametr1' => @$params['rentcommercparametr1'],
            ])
            ->andFilterWhere(['like', 'source', $params['sourceSearch']])

            ->andFilterWhere(['like', 'region', $params['metroSearch']])
            ->andFilterWhere(['like', 'title', $params['titleSearch']])
            ->andFilterWhere(['like', 'addr', $params['addrSearch']])
            ->andFilterWhere(['like', 'phone', $params['phoneSearch']]);
        
        if ( !Yii::$app->user->isGuest ) {
            if ( count($listBlack) > 0 ) {
                 $query->andFilterWhere(['not in', 'phone', $listBlack]);
            }
        }

        if ( count($companyRooms) > 0 ) {
            $query->andFilterWhere(['not in', 'id', $companyRooms]);
        }
        
        if ( $params['districtSearch'] && @$params['citySearch'] ) {
            $query->andFilterWhere( [ 'city_name' => $params['cityNameSearch'] ] );
        } 
        if ( @$params['districtSearch'] && @$params['citySearch'] == 'Город' || $params['districtSearch'] && @$params['citySearch'] == '' ) {
            $query->andFilterWhere( [ 'region2' => $params['districtNameSearch'] ] );
        }
        if ( $params['imageYesSearch'] == 1 ) {
            $query->andWhere(['<>', 'images', '']);
        }
        if ( $params['imageNoSearch'] == 1 ) {
            $query->andWhere(['=', 'images', '']);
        }
        if ( $params['priceBegin'] !== "" ) {
            $i = (int)$params['priceBegin'];
            $query->andWhere(['>=', 'price', $i]);
        }
        if ( $params['priceEnd'] !== "" ) {
            $i = (int)$params['priceEnd'];
            $query->andWhere(['<=', 'price', $i]);
        }
        if ( $params['dateBegin'] !== "" ) {
            $dateStart = strtotime($params['dateBegin']);
            $dateStart = date('Y-m-d 00:00:00', $dateStart);
            $query->andWhere([ '>=', 'date_avito', $dateStart ]);
        }
        if ( $params['dateEnd'] !== "" ) {
            $dateFinish = strtotime($params['dateEnd']);
            $dateFinish = date('Y-m-d 23:59:59', $dateFinish);
            $query->andWhere([ '<=', 'date_avito', $dateFinish ]);
        }
        
        
        // квартиры
        if ( isset($params['saleparametr5']) && $params['saleparametr5'] !== "" ) {
            if ( $params['saleparametr5'] == '200+' || isset($params['saleparametr5_2']) && $params['saleparametr5_2'] == "200+" ) {
                $query->andWhere(['>', 'sale_parametr5', '200']);
            } else {
                $i = (int)$params['saleparametr5'];
                $query->andWhere(['>=', 'sale_parametr5', $i]);
            }
        }
        if ( isset($params['saleparametr5_2']) && $params['saleparametr5_2'] !== "" ) {
            if( $params['saleparametr5_2'] !== "200+" ) {
                $i = (int)$params['saleparametr5_2'];
                $query->andWhere(['<=', 'sale_parametr5', $i]);
            }
        }
        if ( isset($params['saleparametr3']) && $params['saleparametr3'] !== "" ) {
            if ( $params['saleparametr3'] == '31+' || isset($params['saleparametr3_2']) && $params['saleparametr3_2'] == "31+" ) {
                $query->andWhere(['>', 'sale_parametr5', '30']);
            } else {
                $i = (int)$params['saleparametr3'];
                $query->andWhere(['>=', 'sale_parametr3', $i]);
            }
        }
        if ( isset($params['saleparametr3_2']) && $params['saleparametr3_2'] !== "" ) {
            if( $params['saleparametr3_2'] !== "31+" ) {
                $i = (int)$params['saleparametr3_2'];
                $query->andWhere(['<=', 'sale_parametr3', $i]);
            }
        }
        if ( isset($params['saleparametr4']) && $params['saleparametr4'] !== "" ) {
            if ( $params['saleparametr4'] == '31+' || isset($params['saleparametr4_2']) && $params['saleparametr4_2'] == "31+" ) {
                $query->andWhere(['>', 'sale_parametr5', '30']);
            } else {
                $i = (int)$params['saleparametr4'];
                $query->andWhere(['>=', 'sale_parametr4', $i]);
            }
        }
        if ( isset($params['saleparametr4_2']) && $params['saleparametr4_2'] !== "" ) {
            if( $params['saleparametr4_2'] !== "31+" ) {
                $i = (int)$params['saleparametr4_2'];
                $query->andWhere(['<=', 'sale_parametr4', $i]);
            }
        }
        
        if ( isset($params['metr']) && $params['metr'] !== "" ) {
            if ( $params['metr'] == '200+' || isset($params['metr_2']) && $params['metr_2'] == "200+" ) {
                $query->andWhere(['>', 'metr', '200']);
            } else {
                $i = (int)$params['metr'];
                $query->andWhere(['>=', 'metr', $i]);
            }
        }
        if ( isset($params['metr_2']) && $params['metr_2'] !== "" ) {
            if( $params['metr_2'] !== "200+" ) {
                $i = (int)$params['metr_2'];
                $query->andWhere(['<', 'metr', $i]);
            }
        }
        if ( isset($params['rentparametr3']) && $params['rentparametr3'] !== "" ) {
            if ( $params['rentparametr3'] == '31+' || isset($params['rentparametr3_2']) && $params['rentparametr3_2'] == "31+" ) {
                $query->andWhere(['>', 'rent_parametr3', '30']);
            } else {
                $i = (int)$params['rentparametr3'];
                $query->andWhere(['>=', 'rent_parametr3', $i]);
            }
        }
        if ( isset($params['rentparametr3_2']) && $params['rentparametr3_2'] !== "" ) {
            if( $params['rentparametr3_2'] !== "31+" ) {
                $i = (int)$params['rentparametr3_2'];
                $query->andWhere(['<=', 'rent_parametr3', $i]);
            }
        }
        if ( isset($params['etazhnost']) && $params['etazhnost'] !== "" ) {
            if ( $params['etazhnost'] == '31+' || isset($params['etazhnost_2']) && $params['etazhnost_2'] == "31+" ) {
                $query->andWhere(['>', 'etazhnost', '30']);
            } else {
                $i = (int)$params['etazhnost'];
                $query->andWhere(['>', 'etazhnost', $i]);
            }
        }
        if ( isset($params['etazhnost_2']) && $params['etazhnost_2'] !== "" ) {
            if( $params['etazhnost_2'] !== "31+" ) {
                $i = (int)$params['etazhnost_2'];
                $query->andWhere(['<', 'etazhnost', $i]);
            }
        }
        
        
        
        if ( isset($params['saleroomparametr5']) && $params['saleroomparametr5'] !== "" ) {
            if ( $params['saleroomparametr5'] == '50+' || isset($params['saleroomparametr5_2']) && $params['saleroomparametr5_2'] == "50+" ) {
                $query->andWhere(['>', 'sale_room_parametr5', '50']);
            } else {
                $i = (int)$params['saleroomparametr5'];
                $query->andWhere(['>=', 'sale_room_parametr5', $i]);
            }
        }
        if ( isset($params['saleroomparametr5_2']) && $params['saleroomparametr5_2'] !== "" ) {
            if( $params['saleroomparametr5_2'] !== "50+" ) {
                $i = (int)$params['saleroomparametr5_2'];
                $query->andWhere(['<=', 'sale_room_parametr5', $i]);
            }
        }
        if ( isset($params['saleroomparametr3']) && $params['saleroomparametr3'] !== "" ) {
            if ( $params['saleroomparametr3'] == '31+' || isset($params['saleroomparametr3_2']) && $params['saleroomparametr3_2'] == "31+" ) {
                $query->andWhere(['>', 'sale_room_parametr3', '30']);
            } else {
                $i = (int)$params['saleroomparametr3'];
                $query->andWhere(['>=', 'sale_room_parametr3', $i]);
            }
        }
        if ( isset($params['saleroomparametr3_2']) && $params['saleroomparametr3_2'] !== "" ) {
            if( $params['saleroomparametr3_2'] !== "31+" ) {
                $i = (int)$params['saleroomparametr3_2'];
                $query->andWhere(['<=', 'sale_room_parametr3', $i]);
            }
        }
        if ( isset($params['saleroomparametr4']) && $params['saleroomparametr4'] !== "" ) {
             if ( $params['saleroomparametr4'] == '31+' || isset($params['saleroomparametr4_2']) && $params['saleroomparametr4_2'] == "31+" ) {
                $query->andWhere(['>', 'sale_room_parametr4', '30']);
            } else {
                $i = (int)$params['saleroomparametr4'];
                $query->andWhere(['>=', 'sale_room_parametr4', $i]);
             }
        }
        if ( isset($params['saleroomparametr4_2']) && $params['saleroomparametr4_2'] !== "" ) {
            if( $params['saleroomparametr4_2'] !== "31+" ) {
                $i = (int)$params['saleroomparametr4_2'];
                $query->andWhere(['<=', 'sale_room_parametr4', $i]);
            }
        }
        if ( isset($params['rentroomparametr6']) && $params['rentroomparametr6'] !== "" ) {
            if ( $params['rentroomparametr6'] == '50+' || isset($params['rentroomparametr6_2']) && $params['rentroomparametr6_2'] == "50+" ) {
                $query->andWhere(['>', 'rent_room_parametr6', '50']);
            } else {
                $i = (int)$params['rentroomparametr6'];
                $query->andWhere(['>=', 'rent_room_parametr6', $i]);
            }
        }
        if ( isset($params['rentroomparametr6_2']) && $params['rentroomparametr6_2'] !== "" && $params['rentroomparametr6_2'] !== "50+" ) {
            $i = (int)$params['rentroomparametr6_2'];
            $query->andWhere(['<=', 'rent_room_parametr6', $i]);
        }
        if ( isset($params['rentroomparametr4']) && $params['rentroomparametr4'] !== "" ) {
            if ( $params['rentroomparametr4'] == '31+' || isset($params['rentroomparametr4_2']) && $params['rentroomparametr4_2'] == "31+" ) {
                $query->andWhere(['>', 'rent_room_parametr4', '30']);
            } else {
                $i = (int)$params['rentroomparametr4'];
                $query->andWhere(['>=', 'rent_room_parametr4', $i]);
            }
        }
        if ( isset($params['rentroomparametr4_2']) && $params['rentroomparametr4_2'] !== "" && $params['rentroomparametr4_2'] !== "31+" ) {
            $i = (int)$params['rentroomparametr4_2'];
            $query->andWhere(['<=', 'rent_room_parametr4', $i]);
        }
        if ( isset($params['rentroomparametr5']) && $params['rentroomparametr5'] !== "" ) {
            if ( $params['rentroomparametr5'] == '31+' || isset($params['rentroomparametr5_2']) && $params['rentroomparametr5_2'] == "31+" ) {
                $query->andWhere(['>', 'rent_room_parametr5', '30']);
            } else {
                $i = (int)$params['rentroomparametr5'];
                $query->andWhere(['>=', 'rent_room_parametr5', $i]);
            }
        }
        if ( isset($params['rentroomparametr5_2']) && $params['rentroomparametr5_2'] !== "" && $params['rentroomparametr5_2'] !== "31+" ) {
            $i = (int)$params['rentroomparametr5_2'];
            $query->andWhere(['<=', 'rent_room_parametr5', $i]);
        }
        
        
        
        if ( isset($params['salehomeparametr5']) && $params['salehomeparametr5'] !== "" ) {
            if ( $params['salehomeparametr5'] == '500+' || isset($params['salehomeparametr5_2']) && $params['salehomeparametr5_2'] == "500+" ) {
                $query->andWhere(['>', 'sale_home_parametr5', '500']);
            } else {
                $i = (int)$params['salehomeparametr5'];
                $query->andWhere(['>=', 'sale_home_parametr5', $i]);
            }
        }
        if ( isset($params['salehomeparametr5_2']) && $params['salehomeparametr5_2'] !== "" && $params['salehomeparametr5_2'] !== "500+" ) {
            $i = (int)$params['salehomeparametr5_2'];
            $query->andWhere(['<=', 'sale_home_parametr5', $i]);
        }
        if ( isset($params['salehomeparametr4']) && $params['salehomeparametr4'] !== "" ) {
            if ( $params['salehomeparametr4'] == '100+' || isset($params['salehomeparametr4_2']) && $params['salehomeparametr4_2'] == "100+" ) {
                $query->andWhere(['>', 'sale_home_parametr4', '100']);
            } else {
                $i = (int)$params['salehomeparametr4'];
                $query->andWhere(['>=', 'sale_home_parametr4', $i]);
            }
        }
        if ( isset($params['salehomeparametr4_2']) && $params['salehomeparametr4_2'] !== "" && $params['salehomeparametr4_2'] !== "100+" ) {
            $i = (int)$params['salehomeparametr4_2'];
            $query->andWhere(['<=', 'sale_home_parametr4', $i]);
        }
        if ( isset($params['salehomeparametr2']) && $params['salehomeparametr2'] !== "" ) {
            if ( $params['salehomeparametr2'] == '5+' || isset($params['salehomeparametr2_2']) && $params['salehomeparametr2_2'] == "5+" ) {
                $query->andWhere(['>', 'sale_home_parametr2', '5']);
            } else {
                $i = (int)$params['salehomeparametr2'];
                $query->andWhere(['>=', 'sale_home_parametr2', $i]);
            }
        }
        if ( isset($params['salehomeparametr2_2']) && $params['salehomeparametr2_2'] !== "" && $params['salehomeparametr2_2'] !== "5+" ) {
            $i = (int)$params['salehomeparametr2_2'];
            $query->andWhere(['<=', 'sale_home_parametr2', $i]);
        }
        if ( isset($params['salehomeparametr6']) && $params['salehomeparametr6'] !== "" ) {
            if ( $params['salehomeparametr6'] == '100+' || isset($params['salehomeparametr6_2']) && $params['salehomeparametr6_2'] == "100+" ) {
                $query->andWhere(['>', 'sale_home_parametr6', '100']);
            } else {
                $i = (int)$params['salehomeparametr6'];
                $query->andWhere(['>=', 'sale_home_parametr6', $i]);
            }
        }
        if ( isset($params['salehomeparametr6_2']) && $params['salehomeparametr6_2'] !== "" && $params['salehomeparametr6_2'] !== "100+" ) {
            $i = (int)$params['salehomeparametr6_2'];
            $query->andWhere(['<=', 'sale_home_parametr6', $i]);
        }
        
        if ( isset($params['renthomeparametr5']) && $params['renthomeparametr5'] !== "" ) {
            if ( $params['renthomeparametr5'] == '500+' || isset($params['renthomeparametr5_2']) && $params['renthomeparametr5_2'] == "500+" ) {
                $query->andWhere(['>', 'rent_home_parametr5', '500']);
            } else {
                $i = (int)$params['renthomeparametr5'];
                $query->andWhere(['>=', 'rent_home_parametr5', $i]);
            }
        }
        if ( isset($params['renthomeparametr5_2']) && $params['renthomeparametr5_2'] !== "" && $params['renthomeparametr5_2'] !== "500+" ) {
            $i = (int)$params['renthomeparametr5_2'];
            $query->andWhere(['<=', 'rent_home_parametr5', $i]);
        }
        if ( isset($params['renthomeparametr4']) && $params['renthomeparametr4'] !== "" ) {
            if ( $params['renthomeparametr4'] == '100+' || isset($params['renthomeparametr4_2']) && $params['renthomeparametr4_2'] == "100+" ) {
                $query->andWhere(['>', 'rent_home_parametr4', '100']);
            } else {
                $i = (int)$params['renthomeparametr4'];
                $query->andWhere(['>=', 'rent_home_parametr4', $i]);
            }
        }
        if ( isset($params['renthomeparametr4_2']) && $params['renthomeparametr4_2'] !== "" && $params['renthomeparametr4_2'] !== "100+" ) {
            $i = (int)$params['renthomeparametr4_2'];
            $query->andWhere(['<=', 'rent_home_parametr4', $i]);
        }
        if ( isset($params['renthomeparametr2']) && $params['renthomeparametr2'] !== "" ) {
            if ( $params['renthomeparametr2'] == '5+' || isset($params['renthomeparametr2_2']) && $params['renthomeparametr2_2'] == "5+" ) {
                $query->andWhere(['>', 'rent_home_parametr2', '5']);
            } else {
                $i = (int)$params['renthomeparametr2'];
                $query->andWhere(['>=', 'rent_home_parametr2', $i]);
            }
        }
        if ( isset($params['renthomeparametr2_2']) && $params['renthomeparametr2_2'] !== "" && $params['renthomeparametr2_2'] !== "5+" ) {
            $i = (int)$params['renthomeparametr2_2'];
            $query->andWhere(['<=', 'rent_home_parametr2', $i]);
        }
        if ( isset($params['renthomeparametr6']) && $params['renthomeparametr6'] !== "" ) {
            if ( $params['renthomeparametr6'] == '100+' || isset($params['renthomeparametr6_2']) && $params['renthomeparametr6_2'] == "100+" ) {
                $query->andWhere(['>', 'rent_home_parametr6', '100']);
            } else {
                $i = (int)$params['renthomeparametr6'];
                $query->andWhere(['>=', 'rent_home_parametr6', $i]);
            }
        }
        if ( isset($params['renthomeparametr6_2']) && $params['renthomeparametr6_2'] !== "" && $params['renthomeparametr6_2'] !== "100+" ) {
            $i = (int)$params['renthomeparametr6_2'];
            $query->andWhere(['<=', 'rent_home_parametr6', $i]);
        }
        
        
        if ( isset($params['salelandparametr3']) && $params['salelandparametr3'] !== "" ) {
            if ( $params['salelandparametr3'] == '1000+' || isset($params['salelandparametr3_2']) && $params['salelandparametr3_2'] == "1000+" ) {
                $query->andWhere(['>', 'sale_land_parametr3', '1000']);
            } else {
                $i = (int)$params['salelandparametr3'];
                $query->andWhere(['>=', 'sale_land_parametr3', $i]);
            }
        }
        if ( isset($params['salelandparametr3_2']) && $params['salelandparametr3_2'] !== "" && $params['salelandparametr3_2'] !== "1000+" ) {
            $i = (int)$params['salelandparametr3_2'];
            $query->andWhere(['<=', 'sale_land_parametr3', $i]);
        }
        if ( isset($params['salelandparametr2']) && $params['salelandparametr2'] !== "" ) {
            if ( $params['salelandparametr2'] == '100+' || isset($params['salelandparametr2_2']) && $params['salelandparametr2_2'] == "100+" ) {
                $query->andWhere(['>', 'sale_land_parametr2', '100']);
            } else {
                $i = (int)$params['salelandparametr2'];
                $query->andWhere(['>=', 'sale_land_parametr2', $i]);
            }
        }
        if ( isset($params['salelandparametr2_2']) && $params['salelandparametr2_2'] !== "" && $params['salelandparametr2_2'] !== "100+" ) {
            $i = (int)$params['salelandparametr2_2'];
            $query->andWhere(['<=', 'sale_land_parametr2', $i]);
        }
        if ( isset($params['rentlandparametr2']) && $params['rentlandparametr2'] !== "" ) {
            if ( $params['rentlandparametr2'] == '100+' || isset($params['rentlandparametr2_2']) && $params['rentlandparametr2_2'] == "100+" ) {
                $query->andWhere(['>', 'rent_land_parametr2', '100']);
            } else {
                $i = (int)$params['rentlandparametr2'];
                $query->andWhere(['>=', 'rent_land_parametr2', $i]);
            }
        }
        if ( isset($params['rentlandparametr2_2']) && $params['rentlandparametr2_2'] !== "" && $params['rentlandparametr2_2'] !== "100+" ) {
            $i = (int)$params['rentlandparametr2_2'];
            $query->andWhere(['<=', 'rent_land_parametr2', $i]);
        }
        if ( isset($params['rentlandparametr3']) && $params['rentlandparametr3'] !== "" ) {
            if ( $params['rentlandparametr3'] == '1000+' || isset($params['rentlandparametr3_2']) && $params['rentlandparametr3_2'] == "1000+" ) {
                $query->andWhere(['>', 'rent_land_parametr3', '1000']);
            } else {
                $i = (int)$params['rentlandparametr3'];
                $query->andWhere(['>=', 'rent_land_parametr3', $i]);
            }
        }
        if ( isset($params['rentlandparametr3_2']) && $params['rentlandparametr3_2'] !== "" ) {
            if( $params['rentlandparametr3_2'] !== "1000+" ) {
                $i = (int)$params['rentlandparametr3_2'];
                $query->andWhere(['<=', 'rent_land_parametr3', $i]);
             }
        }
        
        
        
        if ( isset($params['salecommercparametr4']) && $params['salecommercparametr4'] !== "" ) {
            if ( $params['salecommercparametr4'] == '10000+' || isset($params['salecommercparametr4_2']) && $params['salecommercparametr4_2'] == "10000+" ) {
                $query->andWhere(['>', 'sale_commerc_parametr4', '10000']);
            } else {
                $i = (int)$params['salecommercparametr4'];
                $query->andWhere(['>', 'sale_commerc_parametr4', $i]);
            }
        }
        if ( isset($params['salecommercparametr4_2']) && $params['salecommercparametr4_2'] !== "" ) {
            if(  $params['salecommercparametr4_2'] !== "10000+" ) {
                $i = (int)$params['salecommercparametr4_2'];
                $query->andWhere(['<', 'sale_commerc_parametr4', $i]);
            }
        }
        if ( isset($params['rentcommercparametr4']) && $params['rentcommercparametr4'] !== "" ) {
            if ( $params['rentcommercparametr4'] == '10000+' || isset($params['rentcommercparametr4_2']) && $params['rentcommercparametr4_2'] == "10000+" ) {
                $query->andWhere(['>', 'rent_commerc_parametr4', '10000']);
            } else {
            $i = (int)$params['rentcommercparametr4'];
            $query->andWhere(['>=', 'rent_commerc_parametr4', $i]);
            }
        }
        if ( isset($params['rentcommercparametr4_2']) && $params['rentcommercparametr4_2'] !== "" ) {
            if( $params['rentcommercparametr4_2'] !== "10000+" && isset($params['rentcommercparametr4']) && $params['rentcommercparametr4'] !== "10000+" ) {
                $i = (int)$params['rentcommercparametr4_2'];
                $query->andWhere(['<=', 'rent_commerc_parametr4', $i]);
            }
        }
        
        
        
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

//         grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'rooms' => $this->rooms,
            'metr' => $this->metr,
            'date_add' => $this->date_add,
            'sale_parametr3' => $this->sale_parametr3,
            'sale_parametr4' => $this->sale_parametr4,
            'sale_parametr5' => $this->sale_parametr5,
            'sale_parametr6' => $this->sale_parametr6,
            'rent_parametr3' => $this->rent_parametr3,
            'rent_parametr4' => $this->rent_parametr4,
            'sale_room_parametr3' => $this->sale_room_parametr3,
            'sale_room_parametr4' => $this->sale_room_parametr4,
            'sale_room_parametr5' => $this->sale_room_parametr5,
            'rent_room_parametr4' => $this->rent_room_parametr4,
            'rent_room_parametr5' => $this->rent_room_parametr5,
            'rent_room_parametr6' => $this->rent_room_parametr6,
            'sale_home_parametr4' => $this->sale_home_parametr4,
            'sale_home_parametr5' => $this->sale_home_parametr5,
            'sale_home_parametr6' => $this->sale_home_parametr6,
            'rent_home_parametr4' => $this->rent_home_parametr4,
            'rent_home_parametr5' => $this->rent_home_parametr5,
            'rent_home_parametr6' => $this->rent_home_parametr6,
            'blackagent' => $this->blackagent,
            'id_task' => $this->id_task,
        ]);

        $query->andFilterWhere(['like', 'avito_id', $this->avito_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'date_avito', $this->date_avito])
            ->andFilterWhere(['like', 'is_company', $this->is_company])
            ->andFilterWhere(['like', 'pledge', $this->pledge])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'href', $this->href])
            ->andFilterWhere(['like', 'seller', $this->seller])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'type_info', $this->type_info])
            ->andFilterWhere(['like', 'etazh', $this->etazh])
            ->andFilterWhere(['like', 'etazhnost', $this->etazhnost])
            ->andFilterWhere(['like', 'actual', $this->actual])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'yandex_id', $this->yandex_id])
            ->andFilterWhere(['like', 'sale_parametr1', $this->sale_parametr1])
            ->andFilterWhere(['like', 'sale_parametr2', $this->sale_parametr2])
            ->andFilterWhere(['like', 'rent_parametr1', $this->rent_parametr1])
            ->andFilterWhere(['like', 'rent_parametr2', $this->rent_parametr2])
            ->andFilterWhere(['like', 'sale_room_parametr1', $this->sale_room_parametr1])
            ->andFilterWhere(['like', 'sale_room_parametr2', $this->sale_room_parametr2])
            ->andFilterWhere(['like', 'sale_room_parametr6', $this->sale_room_parametr6])
            ->andFilterWhere(['like', 'rent_room_parametr1', $this->rent_room_parametr1])
            ->andFilterWhere(['like', 'rent_room_parametr2', $this->rent_room_parametr2])
            ->andFilterWhere(['like', 'rent_room_parametr3', $this->rent_room_parametr3])
            ->andFilterWhere(['like', 'rent_room_parametr7', $this->rent_room_parametr7])
            ->andFilterWhere(['like', 'sale_home_parametr1', $this->sale_home_parametr1])
            ->andFilterWhere(['like', 'sale_home_parametr2', $this->sale_home_parametr2])
            ->andFilterWhere(['like', 'sale_home_parametr3', $this->sale_home_parametr3])
            ->andFilterWhere(['like', 'sale_home_parametr7', $this->sale_home_parametr7])
            ->andFilterWhere(['like', 'rent_home_parametr1', $this->rent_home_parametr1])
            ->andFilterWhere(['like', 'rent_home_parametr2', $this->rent_home_parametr2])
            ->andFilterWhere(['like', 'rent_home_parametr3', $this->rent_home_parametr3])
            ->andFilterWhere(['like', 'rent_home_parametr7', $this->rent_home_parametr7])
            ->andFilterWhere(['like', 'rent_home_parametr8', $this->rent_home_parametr8])
            ->andFilterWhere(['like', 'sale_land_parametr1', $this->sale_land_parametr1])
            ->andFilterWhere(['like', 'sale_land_parametr2', $this->sale_land_parametr2])
            ->andFilterWhere(['like', 'sale_land_parametr3', $this->sale_land_parametr3])
            ->andFilterWhere(['like', 'sale_land_parametr4', $this->sale_land_parametr4])
            ->andFilterWhere(['like', 'rent_land_parametr1', $this->rent_land_parametr1])
            ->andFilterWhere(['like', 'rent_land_parametr2', $this->rent_land_parametr2])
            ->andFilterWhere(['like', 'rent_land_parametr3', $this->rent_land_parametr3])
            ->andFilterWhere(['like', 'rent_land_parametr4', $this->rent_land_parametr4])
            ->andFilterWhere(['like', 'sale_garage_parametr1', $this->sale_garage_parametr1])
            ->andFilterWhere(['like', 'sale_garage_parametr2', $this->sale_garage_parametr2])
            ->andFilterWhere(['like', 'sale_garage_parametr3', $this->sale_garage_parametr3])
            ->andFilterWhere(['like', 'sale_garage_parametr4', $this->sale_garage_parametr4])
            ->andFilterWhere(['like', 'sale_garage_parametr5', $this->sale_garage_parametr5])
            ->andFilterWhere(['like', 'rent_garage_parametr1', $this->rent_garage_parametr1])
            ->andFilterWhere(['like', 'rent_garage_parametr2', $this->rent_garage_parametr2])
            ->andFilterWhere(['like', 'rent_garage_parametr3', $this->rent_garage_parametr3])
            ->andFilterWhere(['like', 'rent_garage_parametr4', $this->rent_garage_parametr4])
            ->andFilterWhere(['like', 'rent_garage_parametr5', $this->rent_garage_parametr5])
            ->andFilterWhere(['like', 'rent_commerc_parametr1', $this->rent_commerc_parametr1])
            ->andFilterWhere(['like', 'rent_commerc_parametr2', $this->rent_commerc_parametr2])
            ->andFilterWhere(['like', 'rent_commerc_parametr3', $this->rent_commerc_parametr3])
            ->andFilterWhere(['like', 'rent_commerc_parametr4', $this->rent_commerc_parametr4])
            ->andFilterWhere(['like', 'rent_commerc_parametr5', $this->rent_commerc_parametr5])
            ->andFilterWhere(['like', 'sale_commerc_parametr1', $this->sale_commerc_parametr1])
            ->andFilterWhere(['like', 'sale_commerc_parametr2', $this->sale_commerc_parametr2])
            ->andFilterWhere(['like', 'sale_commerc_parametr3', $this->sale_commerc_parametr3])
            ->andFilterWhere(['like', 'sale_commerc_parametr4', $this->sale_commerc_parametr4])
            ->andFilterWhere(['like', 'sale_commerc_parametr5', $this->sale_commerc_parametr5])
            ->andFilterWhere(['like', 'dop', $this->dop])
            ->andFilterWhere(['like', 'dop2', $this->dop2])
            ->andFilterWhere(['like', 'km_do_metro', $this->km_do_metro])
            ->andFilterWhere(['like', 'phone_protected', $this->phone_protected])

            ->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['like', 'person_type', $this->person_type])
            ->andFilterWhere(['like', 'count_ads_same_phone', $this->count_ads_same_phone])
            ->andFilterWhere(['like', 'images', $this->images]);

        return $dataProvider;
    }
}
