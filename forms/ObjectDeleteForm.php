<?php

namespace app\forms;

use yii\base\Model;

class ObjectDeleteForm extends Model
{
    public $object_id;
    public $reason_text;
    public $target = 'index';

    public function rules()
    {
        return [
            [['object_id'], 'required', 'message' => 'Необходимо указать объект'],
            [['object_id', 'target'], 'string'],
            [['reason_text'], 'required', 'message' => 'Необходимо указать причину'],
            [['reason_text'], 'string', 'min' => 5, 'tooShort' => 'Минимальная длина 5 символов'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'object_id' => 'Объект',
            'reason_text' => 'Причина удаления',
        ];
    }
}