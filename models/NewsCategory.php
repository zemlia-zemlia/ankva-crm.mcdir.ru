<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles_company_category".
 *
 * @property int $id
 * @property string $title
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
            'title' => 'Наименование',
        ];
    }



    public static function getCategory()
    {
        $list =  NewsCategory::find()->where(['id_company' => [Yii::$app->user->identity->id_company]])->select(['id','title'])->asArray()->all();
        $list1 = [];
        foreach($list as $staff) $list1[] = ['id' => $staff['id'], 'title' => $staff['title'] ];
        return \yii\helpers\ArrayHelper::map($list1, 'id', 'title');
    }


}
