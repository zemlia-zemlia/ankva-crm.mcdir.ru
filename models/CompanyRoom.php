<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_rooms".
 *
 * @property int $id
 * @property int $parser_id
 * @property int $object_id
 */
class CompanyRoom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_rooms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parser_id', 'object_id'], 'required'],
            [['id', 'parser_id', 'object_id'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parser_id' => 'Parser ID',
            'object_id' => 'Object ID',
        ];
    }
}
