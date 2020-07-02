<?php

namespace app\models\client;

use Yii;

/**
 * This is the model class for table "upload_file".
 *
 * @property int $id
 * @property string $name
 * @property int $object_id
 */
class UploadFile1 extends \yii\db\ActiveRecord
{

    public $foto;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upload_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_id'], 'required'],
            [['object_id'], 'integer'],
            [['name'], 'string', 'max' => 1024],
            [['foto'], 'image']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'object_id' => 'Object ID',
        ];
    }
}
