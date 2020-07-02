<?php

namespace app\validators;

use yii\validators\RegularExpressionValidator;

class PhoneValidator extends RegularExpressionValidator
{
    public $pattern = '/^\+7 \(9\d{2}\) \d{3} \d{2} \d{2}$/';
    public $message = 'Телефон указан неверно';
}