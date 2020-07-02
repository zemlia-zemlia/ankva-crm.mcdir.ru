<?php
/**
 * User: execut
 * Date: 07.07.15
 * Time: 11:26
 */

namespace execut\actions\action\adapter;


use execut\actions\action\Adapter;
use execut\actions\action\adapter\helper\FormLoader;
use execut\actions\action\adapter\viewRenderer\DynaGrid;
use yii\helpers\Html;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;
use yii\log\Logger;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class GridView
 * @package execut\actions\action
 * @property Model $filter
 */
class GridView extends \execut\actions\action\adapter\Form
{
    public $attributes = null;

    protected $_isValidate = false;

    public $scenario = ActiveRecord::SCENARIO_DEFAULT;

    protected $_filterForm = null;

    protected $handlers = [];

    public function setFilterForm($form) {
        if (is_string($form)) {
            $form = ['class' => $form];
        }

        if (is_array($form)) {
            $form = \yii::createObject($form);
        }

        $this->_filterForm = $form;

        return $this;
    }

    public function getFilterForm() {
        return $this->_filterForm;
    }

    /**
     * @return Model
     */
    protected function loadAndValidateFilter()
    {
        $model = $this->getFilterForm();
        if ($model === null) {
            return;
        }

        $helper = new FormLoader();
        $helper->data = $this->getData();
        $helper->model = $model;
        $helper->filesAttributes = $this->filesAttributes;
        $result = $helper->run();
        if ($result === false && $this->actionParams->isAjax && !$this->actionParams->isPjax && !$this->isDisableAjax) {
            return ActiveForm::validate($model);
        }

        return $result;
    }

    protected function getAttributes() {
        $attributes = $this->attributes;
        if ($attributes === null) {
            $class = $this->model->className();
            $attributes = [
                'id' => current($class::primaryKey()),
                'text' => 'name',
            ];
        }

        return $attributes;
    }

    public function setHandlers($handlers) {
        foreach ($handlers as $key => $handler) {
            if (is_array($handler)) {
                $handlers[$key] = \yii::createObject($handler);
            }
        }

        $this->handlers = $handlers;
    }

    public function getHandlers() {
        return $this->handlers;
    }

    protected function _run() {
        \yii::beginProfile('Run action', 'execut.yii2-actions');
        /**
         * @var ActiveRecord $filter
         */
        $filter = $this->model;
//        if ($filter->getBehavior('relationsSaver')) {
//            $filter->detachBehavior('relationsSaver');
//        }

        if ($this->scenario !== ActiveRecord::SCENARIO_DEFAULT) {
            $filter->scenario = $this->scenario;
        }

        parent::_run();

        $isValid = $filter->validate();
        $this->loadAndValidateFilter();
        /**
         * @var ArrayDataProvider $dataProvider
         */
        $dataProvider = $filter->search($this->filterForm);
        if (!$isValid && $dataProvider) {
            $dataProvider->query->where = 'false';
        }

        if (!empty($this->actionParams->get['handle'])) {
            $handlerKey = $this->actionParams->get['handle'];
            $handlers = $this->handlers;
            if (!empty($handlers[$handlerKey])) {
                $handler = $handlers[$handlerKey];
                $handler->dataProvider = $dataProvider;
                if (($result = $handler->run()) !== null) {
                    return $result;
                }
            }
        }

        $actionParams = $this->actionParams;
        $response = $this->getResponse();
        if ($actionParams->isAjax && !$actionParams->isPjax && !$this->isDisableAjax && $dataProvider) {
            if (isset($this->actionParams->get['depdrop_parents'])) {
                $key = 'output';
                $dataProvider->pagination->pageSize = 500;
            } else {
                $key = 'results';
            }

            $result = [];
            foreach ($dataProvider->models as $row) {
                $attributes = $this->getAttributes();
                $modelAttributes = array_values($attributes);
                if ($row instanceof Model) {
                    $row = $row->getAttributes($modelAttributes);
                }
                $res = [];
                foreach ($attributes as $targetKey => $attribute) {
                    if (is_int($targetKey)) {
                        $targetKey = $attribute;
                    }

                    $res[$targetKey] = $row[$attribute];
                }

                $result[] = $res;
            }

            $pagination = $dataProvider->pagination;
            $response->content = [
                $key => $result,
                'pagination' => [
                    'more' => $pagination ? ($pagination->page < $pagination->pageCount - 1) : false,
                ],
                'totalCount' => $pagination->totalCount,
            ];

            $response->format = Response::FORMAT_JSON;
        } else {
            $response->content = [
                'filter' => $filter,
                'dataProvider' => $dataProvider,
                'filterForm' => $this->filterForm,
            ];
        }

        \yii::endProfile('Run action', 'execut.yii2-actions');

        return $response;
    }

    public function getDefaultViewRendererConfig()
    {
        return [
            'class' => DynaGrid::class,
//            'title' => $this->model->getModelLabelOld(2),
            'modelClass' => $this->model->className(),
        ];
    }
}