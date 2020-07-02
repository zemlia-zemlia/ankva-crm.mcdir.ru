<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

class Notes extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'notes';
    }
    
    
    public function rules() {
        return [
            [['id', 'user_id', 'ads_id'], 'integer'],
            ['note', 'string'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'Id пользователя',
            'ads_id' => 'Id объявления',
            'note' => 'Текст заметки',
        ];
    }
}