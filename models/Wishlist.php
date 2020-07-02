<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

class Wishlist extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'wishlist';
    }
    
    
    public function rules() {
        return [
            ['id', 'integer'],
            [['username', 'ads'], 'string'],
            [['id'], 'unique'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'username' => 'Логин пользователя',
        ];
    }
}