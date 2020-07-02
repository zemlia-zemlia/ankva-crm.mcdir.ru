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
class Pagesite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'titlehref', 'content'], 'required'],
            [[ 'id_company'], 'integer'],
            [['published'], 'integer'],
            [['alias'], 'string', 'max' => 25],

            [['titlehref'], 'string', 'max' => 25],
            [['title'], 'string', 'max' => 255],
            [['title_browser'], 'string', 'max' => 255],
            [['meta_keywords'], 'string', 'max' => 255],
            [['meta_description'], 'string', 'max' => 255],
            [['created_at'], 'string', 'max' => 255],
            [['updated_at'], 'string', 'max' => 255],

            [['content'], 'string', 'max' => 5000],

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
            'titlehref' => 'Наименование ссылки',
            'alias' => 'Алиас URL',
            'meta_keywords' => 'Ключевые слова',
            'meta_description' => 'Description',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',

            'content' => 'Контент',
            'published' => 'Публикация',



        ];
    }
}
