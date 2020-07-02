<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\db\ActiveRecord;

class Company extends Widget
{
    public $message;

    public function init(){
        parent::init();
        if ($this->message === null){
            $this->message = 'CRM';
        }
    }

    public function run(){
        $model = Company::find() -> limit(10) -> all();

        return $this -> render('news', ['news' => $model]);
    }
}