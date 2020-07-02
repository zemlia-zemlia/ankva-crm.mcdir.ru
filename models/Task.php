<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_object
 * @property int $date
 * @property int $date_add
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_object', 'date', 'date_add'], 'required'],
            [['id_user', 'id_object', 'date', 'date_add'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_object' => 'Id Object',
            'date' => 'Date',
            'date_add' => 'Date Add',
        ];
    }
}
