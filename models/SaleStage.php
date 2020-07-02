<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_funnel".
 *
 * @property int $id
 * @property string $name
 * @property int $color
 */
class SaleStage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_funnel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'color'], 'required'],
            [['id', 'color'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'color' => 'Color',
        ];
    }
}
