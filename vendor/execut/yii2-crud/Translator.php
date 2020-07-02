<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 7/19/17
 * Time: 1:11 PM
 */

namespace execut\crud;


use execut\actions\Action;
use execut\actions\action\adapter\Edit;
use execut\actions\action\adapter\EditWithRelations;
use yii\base\BaseObject;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\helpers\Inflector;

class Translator extends BaseObject
{
    public $module = null;
    public $modelName = null;
    public $moduleName = null;
    /**
     * @param $moduleName
     * @return string
     */
    protected function moduleTranslate($message, $params = ['n' => 1])
    {
        if ($this->module === null) {
            return $message;
        }

        $category = 'execut/' . $this->module;
        $result = $this->translate($message, $params, $category);

        return $result;
    }

    /**
     * @param $moduleName
     * @return string
     */
    protected function crudTranslate($message, $params = []): string
    {
        $category = 'execut/crud/';
        $result = $this->translate($message, $params, $category);

        return $result;
    }

    protected function lcfirst($string, $encoding = "UTF-8")
    {
        $first = mb_convert_case(mb_substr($string, 0, 1, $encoding), MB_CASE_LOWER, $encoding);

        return $first . mb_substr($string, 1, null, $encoding);
    }

    public function getManyModelName($n = 22) {
        return $this->moduleTranslate($this->modelName, ['n' => $n]);
    }

    public function getCreateLabel() {
        return $this->crudTranslate('New') . ' ' . $this->lcfirst($this->getModelLabel(1));
    }

    public function getUpdateLabel() {
        $title = $this->getModelTitle();
        if ($title) {
            $title = $this->moduleTranslate($title);
        }

        return $this->getModelLabel(1) . ' ' . $title;
    }

    public function getModelTitle() {
        $controller = \yii::$app->controller;
        $action = $controller->action;
        if ($action instanceof Action && ($action->adapter instanceof Edit || $action->adapter instanceof EditWithRelations)) {
            $model = $action->adapter->getModel();

            return (string) $model;
        }
    }

    public function getModelLabel($n) {
        return $this->moduleTranslate($this->modelName, ['n' => $n]);
    }

    public function getModuleLabel() {
        return $this->moduleTranslate($this->moduleName, ['n' => 31]);
    }

    /**
     * @param $message
     * @param $params
     * @param $category
     * @return string
     */
    protected function translate($message, $params, $category)
    {
        $result = \yii::t($category, $message, $params);

        return $result;
    }
}