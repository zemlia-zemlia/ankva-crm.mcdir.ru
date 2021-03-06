<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 12/15/17
 * Time: 12:34 PM
 */

namespace execut\crudFields\fields;


use kartik\detail\DetailView;
use unclead\multipleinput\MultipleInputColumn;
use yii\helpers\ArrayHelper;

class Hidden extends Field
{
    public function getField()
    {
        return ArrayHelper::merge(parent::getField(), [
            'type' => DetailView::INPUT_HIDDEN,
            'rowOptions' => [
                'class' => 'hidden kv-edit-hidden kv-view-hidden',
            ],
        ]); // TODO: Change the autogenerated stub
    }

    public function getMultipleInputField()
    {
        return ArrayHelper::merge(parent::getMultipleInputField(), [
            'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
        ]); // TODO: Change the autogenerated stub
    }

    public function getColumn()
    {
        return false;
    }
}