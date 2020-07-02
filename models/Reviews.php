<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles_company".
 *
 * @property int $id
 * @property int $id_company
 * @property string $title
 * @property string $description
 * @property int $category
 * @property string $created_at
 * @property string $updated_at
 * @property int $manager_added
 * @property int $manager_updated
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['phone', 'id_company', 'status'], 'integer'],
            [['email'], 'string'],
            [['name'], 'string', 'max' => 55],
            [['text'], 'string', 'max' => 255],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_company' => 'Id Company',
            'name' => 'Имя',
            'text' => 'Отзыв',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'date' => 'Дата',
            'status' => 'Показывать отзыв на сайте',


        ];
    }
}
