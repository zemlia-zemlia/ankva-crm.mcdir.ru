<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "typeproperty".
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string $reduced
 * @property int $active
 * @property string $rang
 * @property string $name_href
 * @property string $name_full
 * @property int $id_company
 * @property int $feed_type
 */
class TypeProperty extends ActiveRecord
{
    public static function tableName()
    {
        return 'typeproperty';
    }

    public static function getList(){

      //  $query->andWhere(['id_company' => Yii::$app->user->identity->id_company]);
        return \yii\helpers\ArrayHelper::map(self::find() ->where(['id_company' => Yii::$app->user->identity->id_company])->all(),'id','name');

    }

    public function getXmlName()
    {
       $type  = [1 => 'квартира', 2 => 'квартира', 3 => 'квартира', 4 => 'квартира', 6 => 'квартира',
           5 => 'комната', 7 => 'комната', 8 => 'часть дома', 9 => 'дом',  ];

        return $type[$this->id];
    }
    public function rules() {
        return [

          [['id', 'name', 'city', 'reduced', 'active', 'rang', 'name_href', 'name_full', 'id_company', 'feed_type'] , 'safe']
        ];
    }



}
