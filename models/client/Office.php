<?php

namespace app\models\client;

use Yii;
use app\models\City;
use app\models\Region;

/**
 * This is the model class for table "office".
 *
 * @property int $id Id
 * @property int $name Офис
 * @property int $city_id Город
 * @property int $region Region
 * @property City $city
 */
class Office extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city_id'], 'required'],
            [['city_id', 'region_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Адрес',
            'city_id' => 'Город',
            'region_id' => 'Регион',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getOfficeCity()
    {
        return $this->city->name;
    }
    public static function getOfficeList()
    {
        $_list = Office::find()->all();
        $list = [];
        foreach ($_list as $l)  $list[] = ['id' => $l->id, 'name' => $l->city->name.'---'.$l->name];


        return \yii\helpers\ArrayHelper::map($list,'id','name');
    }





    /**
     * {@inheritdoc}
     * @return OfficeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OfficeQuery(get_called_class());
    }
}
