<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
class NewsCrm extends \yii\db\ActiveRecord
{

    public $file;
    public $del_img;

     /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'message', 'id_tag', 'activ' ], 'required'],


            [['id_tag'], 'integer'],
            [['message', 'image'], 'string'],

            [['file'], 'file', 'extensions' => 'png, jpg, jpeg',  'checkExtensionByMimeType' => true,
                'maxSize' => 512000],
            [['title'], 'string', 'max' => 255],

            [['file'], 'file', 'extensions' => 'png, jpg'],
            [['del_img'], 'boolean'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_post' => 'ID',
            'title' => 'Наименование',
            'message' => 'Описание',
            'id_tag' => 'Категория',
            'icon' => 'Изображение',
            'file' => 'Изображение',
            'logo' => 'Изображение',
            'file2' => 'Изображение',

        ];
    }




}
