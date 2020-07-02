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
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_company', 'title', 'description', 'category',   'manager_added' ], 'required'],
            [['id_company', 'category', 'manager_added' ], 'integer'],
            [['description'], 'string'],

            [['title'], 'string', 'max' => 255],
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
            'title' => 'Наименование',
            'description' => 'Описание',
            'category' => 'Категория',
            'manager_added' => 'Добавил',

        ];
    }
}
