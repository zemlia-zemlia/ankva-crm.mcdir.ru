<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $contentOptions = [
        'style' => 'white-space: nowrap; text-align: center; width: 150px',
    ];


    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'times', [
            'data-confirm' => Yii::t('yii', 'Вы действительно хотите удалить этот элемент?'),
            'data-method' => 'post',
        ]);
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        $btnClass = 'primary';
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        $btnClass = 'primary';
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $btnClass = 'danger';
                        break;
                    default:
                        $title = ucfirst($name);
                        $btnClass = 'primary';
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);

                return Html::a(Html::tag('span', Html::tag('i', '', ['class' => "fa fa-$iconName"]), ['class' => "btn btn-action btn-$btnClass"]), $url, $options);
            };
        }
    }
}