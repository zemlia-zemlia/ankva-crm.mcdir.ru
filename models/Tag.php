<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles_company_Tag".
 *
 * @property int $id
 * @property string $title
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
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



    public static function getTag()
    {
        $list =  Tag::find()->select(['id_tag','title'])->asArray()->all();
        $list1 = [];
        foreach($list as $staff) $list1[] = ['id_tag' => $staff['id_tag'], 'title' => $staff['title'] ];
        return \yii\helpers\ArrayHelper::map($list1, 'id_tag', 'title');
    }


}
