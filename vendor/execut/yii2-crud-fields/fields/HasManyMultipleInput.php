<?php
/**
 */

namespace execut\crudFields\fields;


use detalika\clients2\models\Contacts;
use execut\oData\ActiveRecord;
use kartik\detail\DetailView;
use kartik\grid\BooleanColumn;
use kartik\grid\GridView;
use execut\crudFields\widgets\Select2;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\pgsql\Schema;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

class HasManyMultipleInput extends Field
{
    public $url = null;
    public $gridOptions = [];
    public $columns = [
        'id' => [
            'attribute' => 'id',
        ],
        'name' => [
            'attribute' => 'name',
        ],
        'visible' => [
            'class' => BooleanColumn::class,
            'attribute' => 'visible'
        ],
    ];

    public $isRenderFilter = false;
    public $mainAttribute = 'name';

    public $isGridInColumn = false;

    public $toAttribute = null;

    public $viaColumns = [
    ];

    public $isGridForOldRecords = false;
    public $multipleInputType = MultipleInput::class;
    public $defaultMultipleInputColumnConfig = [];

    public function attach() {
        return parent::attach();
    }
    public function getFields($isWithRelationsFields = true)
    {
        if ($this->isGridForOldRecords && !$this->model->isNewRecord) {
            return [
                $this->attribute . 'Group' => [
                    'group' => true,
                    'label' => $this->getLabel(),
                    'groupOptions' => [
                        'class' => 'success',
                    ],
                ],
                $this->attribute => $this->getGrid(),
            ];
        }

        return parent::getFields($isWithRelationsFields); // TODO: Change the autogenerated stub
    }

    public function getField()
    {
        $field = parent::getField();
        if (!is_array($field)) {
            return $field;
        }

        $widgetOptions = $this->getMultipleInputWidgetOptions();

        $attribute = $this->relation;
        return ArrayHelper::merge([
            'type' => DetailView::INPUT_WIDGET,
            'attribute' => $attribute,
//            'label' => $this->getLabel(),
            'format' => 'raw',
            'value' => function () {
                $dataProvider = new ActiveDataProvider();
//                $query = $this->model->getRelation($this->relation);
//                $dataProvider->query = $query;
//                return GridView::widget([
//                    'dataProvider' => $dataProvider,
//                    'columns' => $this->columns,
//                ]);
            },
            'widgetOptions' => $widgetOptions,
        ], $field);
    }

    protected function getGrid() {
        return [
//            'attribute' => $this->attribute,
            'value' => '',
            'format' => 'raw',
            'displayOnly' => true,
//            'labelColOptions' => [
//                'style' => 'display:none',
//            ],
//            'valueColOptions' => [
//                'colspan' => 2,
//                'style' => [
//                    'padding' => 0,
//                ],
//            ],
            'group' => true,
            'groupOptions' => [
                'style' => [
                    'padding' => 0,
                ],
            ],
            'label' => function () {
                $model = $this->model;
                $relationName = $this->getRelationObject()->getName();
                $dataProvider = new ActiveDataProvider([
                    'query' => $model->getRelation($relationName),
                ]);

//                $models = $model->$relationName;
//                $models = ArrayHelper::map($models, function ($row) {
//                    return $row->primaryKey;
//                }, function ($row) {
//                    return $row;
//                });
//                $dataProvider = new ArrayDataProvider([
//                    'allModels' => $models,
//                ]);
                $widgetClass = GridView::class;
                $gridOptions = $this->getGridOptions();

                if (!empty($gridOptions['class'])) {
                    $widgetClass = $gridOptions['class'];
                }

                return $widgetClass::widget(ArrayHelper::merge([
                    'dataProvider' => $dataProvider,
                    'layout' => '{toolbar}{summary}{items}{pager}',
                    'bordered' => false,
                    'toolbar' => '',
//                    'caption' => $this->getLabel(),
//                    'captionOptions' => [
//                        'class' => 'success',
//                    ],
                    'columns' => $this->getRelationObject()->getRelationModel()->getGridColumns(),
                    'showOnEmpty' => true,
                ], $gridOptions));
            },
        ];
    }

    protected function getGridOptions() {
        $gridOptions = $this->gridOptions;
        if (is_callable($gridOptions)) {
            $gridOptions = $gridOptions();
        }

        return $gridOptions;
    }

    public $nameParam = null;

    /**
     * @TODO Copy past from HasOneSelect2
     *
     * @return null|string
     */
    public function getNameParam() {
        if ($this->nameParam !== null) {
            return $this->nameParam;
        }

        $formName = $this->getRelationObject()->getRelationFormName();

        return $formName . '[' . $this->nameAttribute . ']';
    }

    public function applyScopes(ActiveQuery $query)
    {
        /**
         * @TODO Учесть with=false
         */
        if ($this->columnRecordsLimit === null || $this->columnRecordsLimit === false) {
            $query->with($this->getRelationObject()->getWith());
        }

        if ($this->scope === false) {
            return $query;
        }

        if (!empty($this->model->errors)) {
            return $query->andWhere('false');
        }

        $relatedModelClass = $this->getRelationObject()->getRelationModelClass();
        $relatedModel = new $relatedModelClass;

        foreach ($this->value as $rowModel) {
            $isHasRelationAttribute = $this->isHasRelationAttribute;
            if ($isHasRelationAttribute && in_array($rowModel->$isHasRelationAttribute, ['0', '1'])) {
                $relationQuery = $this->getRelationObject()->getRelationQuery();
                $relationQuery->primaryModel = null;
                if ($rowModel->$isHasRelationAttribute == '1') {
                    $operator = 'IN';
                    $relationQuery->select(key($relationQuery->link));
                    $query->andWhere([
                        $operator,
                        current($relationQuery->link),
                        $relationQuery,
                    ]);
                } else {
                    $relationQuery->andWhere([
                        $relatedModel->tableName() . '.' . key($relationQuery->link) => new Expression($this->model->tableName() . '.' . current($relationQuery->link)),
                    ])->select(new Expression( '1'));
                    $query->andWhere([
                        'NOT EXISTS',
                        $relationQuery
                    ]);
                }
            } else {
                $row = array_filter($rowModel->attributes);
                if (!empty($row)) {
                    $relatedModel->scenario = Field::SCENARIO_GRID;
                    $relatedModel->attributes = $row;
                    $relationQuery = $this->getRelationObject()->getRelationQuery();
                    $relationQuery = $relatedModel->applyScopes($relationQuery);

                    $relationQuery->select(key($relationQuery->link));
                    $relationQuery->indexBy = key($relationQuery->link);


                    if (!($this->model instanceof ActiveRecord)) {
                        $attributePrefix = $this->model->tableName() . '.';
                    } else {
                        $attributePrefix = '';
                    }

                    $relatedAttribute = current($relationQuery->link);
                    $relationQuery->primaryModel = null;
                    $relationQuery->link = null;

                    $query->andWhere([
                        $attributePrefix . $relatedAttribute => $relationQuery,
                    ]);
                }
            }
        }

//        return $query;
        return $query;
    }


    public function getColumn() {
        $column = parent::getColumn();
        if ($column === false) {
            return false;
        }

//        $sourceInitText = $this->getRelationObject()->getSourcesText();

//        $sourcesNameAttribute = $modelClass::getFormAttributeName('name');
        if ($this->isGridInColumn) {
            $valueClosure = function ($row) {
                /**
                 * @var \yii\db\ActiveRecord $row
                 */
                $relationName = $this->getRelationObject()->getName();
                if ($row->isRelationPopulated($relationName)) {
                    $allModels = $row->$relationName;
                } else {
                    $limit = $this->columnRecordsLimit;
                    $q = $row->getRelation($relationName);

                    if ($limit !== false) {
                        if ($limit === null) {
                            $limit = 10;
                        }

                        $q->limit($limit);
                    }

                    $allModels = $q->all();
                }

                if (!$allModels) {
                    return '';
                }
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $allModels,
                ]);

                //                $models = $model->$relationName;
                //                $models = ArrayHelper::map($models, function ($row) {
                //                    return $row->primaryKey;
                //                }, function ($row) {
                //                    return $row;
                //                });
                //                $dataProvider = new ArrayDataProvider([
                //                    'allModels' => $models,
                //                ]);
                $widgetClass = GridView::class;
                $gridOptions = $this->getGridOptions();
                if (!empty($gridOptions['class'])) {
                    $widgetClass = $gridOptions['class'];
                }

                $gridColumns = $this->getRelationObject()->getRelationModel()->getGridColumns();
                unset($gridColumns['actions']);
                return $widgetClass::widget(ArrayHelper::merge([
                    'dataProvider' => $dataProvider,
                    'layout' => '{items}',
                    'export' => false,
                    'resizableColumns' => false,
//                    'layout' => '{toolbar}{summary}{items}{pager}',
                    'bordered' => false,
                    'toolbar' => '',
                    //                    'caption' => $this->getLabel(),
                    //                    'captionOptions' => [
                    //                        'class' => 'success',
                    //                    ],
                    'columns' => $gridColumns,
                    'showOnEmpty' => true,
                ], $gridOptions));
            };
        } else {
            $valueClosure = function ($row) {
                return $this->getRelationObject()->getColumnValue($row);
                /**
                 * @TODO Equal functional from HasOneSelect2
                 */
                $attribute = $this->attribute;
                $result = [];
                $pk = $this->getRelationObject()->getRelationPrimaryKey();
                foreach ($row->$attribute as $vsKeyword) {
                    $value = ArrayHelper::getValue($vsKeyword, $this->nameAttribute);

                    if (($url = $this->url) !== null) {
                        if (is_array($url)) {
                            $url = $url[0];
                        } else {
                            $url = str_replace('/index', '', $url);
                        }

                        $currentUrl = [$url . '/update'];
                        $pkValue = $vsKeyword->$pk;
                        if (is_array($pkValue)) {
                            $currentUrl = array_merge($currentUrl, $pkValue);
                        } else {
                            $currentUrl = array_merge($currentUrl, ['id' => $pkValue]);
                        }

                        $value = $value . '&nbsp;' . Html::a('>>>', Url::to($currentUrl));
                    }

                    $result[] = $value;
                }

                return implode(', ', $result);
            };
        }

        $column = ArrayHelper::merge([
            'attribute' => $this->attribute,
            'format' => 'html',
            'value' => $valueClosure,
//                /**
//                 * @TODO Equal functional from HasOneSelect2
//                 */
//                $attribute = $this->attribute;
//                $result = [];
//                $pk = $this->getRelationObject()->getRelationPrimaryKey();
//                foreach ($row->$attribute as $vsKeyword) {
//                    $value = ArrayHelper::getValue($vsKeyword, $this->nameAttribute);
//
//                    if (($url = $this->url) !== null) {
//                        if (is_array($url)) {
//                            $url = $url[0];
//                        } else {
//                            $url = str_replace('/index', '', $url);
//                        }
//
//                        $currentUrl = [$url . '/update', 'id' => $vsKeyword->$pk];
//                        $value = $value . '&nbsp;' . Html::a('>>>', Url::to($currentUrl));
//                    }
//
//                    $result[] = $value;
//                }
//
//                return implode(', ', $result);

//            'value' => function ($row) {
//                $url = $this->url;
//                if (is_array($url)) {
//                    $url = $url[0];
//                } else {
//                    $url = str_replace('/index', '', $url);
//                }
//
//                $attribute = $this->attribute;
//
//                $url = [$url . '/update', 'id' => $row->$attribute];
//
//                $valueAttribute = $this->getRelationObject()->getColumnValue();
//                $value = ArrayHelper::getValue($row, $valueAttribute);
//
//                return Html::a($value, Url::to($url));
//            },
//                'value' => function () {
//                    return 'asdasd';
//                },
//                [
////                'language' => $this->getLanguage(),
//                'initValueText' => $sourceInitText,
//                'options' => [
//                    'multiple' => true,
//                ],
//                'pluginOptions' => [
//                    'allowClear' => true,
//                    'ajax' => [
//                        'cache' => true,
//                        'url' => Url::to($this->url),
//                        'dataType' => 'json',
//                        'data' => new JsExpression(<<<JS
//function (params) {
//  return {
//    "$nameParam": params.term,
//    page: params.page
//  };
//}
//JS
//                        )
//
//                    ],
//                ],
//            ],
        ], $column);

        if (!array_key_exists('filter', $column) || $column['filter'] !== false) {
            $multipleInputWidgetOptions = $this->getMultipleInputWidgetOptions(true);
            if (!$this->isRenderFilter) {
                if ($this->isHasRelationAttribute !== false && !empty($multipleInputWidgetOptions['columns'][$this->isHasRelationAttribute])) {
                    $multipleInputWidgetOptions['columns'] = [
                        'id' => $multipleInputWidgetOptions['columns']['id'],
                        $this->isHasRelationAttribute => $multipleInputWidgetOptions['columns'][$this->isHasRelationAttribute],
                    ];
                } else {
                    $column['filter'] = false;

                    return $column;
                }
            }

            $column = ArrayHelper::merge([
                'filter' => '',//$sourceInitText,
                'filterType' => MultipleInput::class,
                'filterWidgetOptions' => ArrayHelper::merge($multipleInputWidgetOptions, [
                    'max' => 1,
                    'min' => 1,
                    'addButtonPosition' => MultipleInput::POS_ROW,
                ]),
            ], $column);
        }

        return $column;
    }

//    public function getValue()
//    {
//        return false;
//    }

    /**
     * @param $column
     * @return array
     */
    protected function getMultipleInputWidgetOptions($isWithoutMainAttribute = false): array
    {
        $nameParam = $this->getNameParam();
        $relation = $this->getRelationObject();
        if ($relation->isVia()) {
            $fromAttribute = $relation->getViaFromAttribute();
            $toAttribute = $relation->getViaToAttribute();
            $sourceInitText = $relation->getSourcesText();
            $viaRelationModelClass = $relation->getRelationModelClass();
            $viaRelationModel = new $viaRelationModelClass;
            $changeEvent = new JsExpression(<<<JS
    function () {
        var el = $(this),
            inputs = el.parent().parent().parent().find('input, select');
        if (el.val()) {
            inputs.not(el).attr('disabled', 'disabled');
        } else {
            inputs.not(el).attr('disabled', false);
        }
    }
JS
            );
            $targetFields = [
                'id' => [
                    'name' => 'id',
                    'type' => Select2::class,
                    'defaultValue' => null,
                    'value' => $sourceInitText,
                    'headerOptions' => [
                        'style' => 'width: 150px;',
                    ],
                    'options' => [
                        'initValueText' => $sourceInitText,
                        'pluginEvents' => [
                            'change' => $changeEvent,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => '',
                            'ajax' => [
                                'url' => Url::to($this->url),
                                'dataType' => 'json',
                                'data' => new JsExpression(<<<JS
    function(params) {
        return {
            "$nameParam": params.term
        };
    }
JS
                                )
                            ],
                        ],
                    ],
                ],
            ];
            $columns = ArrayHelper::merge($targetFields, $viaRelationModel->getMultipleInputFields(), $this->viaColumns);

            foreach ($columns as &$column) {
                if (empty($column['title']) && !empty($column['name'])) {
                    $column['title'] = Html::activeLabel($viaRelationModel, $column['name']);
                }
            }
        } else {
            $viaRelationModel = $this->getRelationObject()->getRelationModel(true);
            $pksFields = [];
            foreach ($viaRelationModel->primaryKey() as $primaryKey) {
                $pksFields[$primaryKey] = [
                    'type' => MultipleInputColumn::TYPE_HIDDEN_INPUT,
                    'name' => $primaryKey,
                ];
            }

            $multipleInputColumns = $viaRelationModel->getMultipleInputFields();
//            foreach ($multipleInputColumns as $multipleInputColumn) {
//                if (!empty($multipleInputColumn['type']) && $multipleInputColumn['type'] === Select2::class) {
//                    $sourceInitText = $this->getRelationSourceText($multipleInputColumn['name']);
//                    $multipleInputColumn['options']['initValueText'] = $sourceInitText;
//                }
//            }

            $columns = ArrayHelper::merge($pksFields, $multipleInputColumns, $this->viaColumns);
        }

//        if ($isWithoutMainAttribute && $this->mainAttribute) {
//            unset($columns[$this->mainAttribute]);
//        }

        foreach ($columns as $key => $column) {
            $columns[$key] = ArrayHelper::merge($column, $this->defaultMultipleInputColumnConfig);
        }

        $widgetOptions = [
            'class' => MultipleInput::class,
            'allowEmptyList' => true,
            'model' => $viaRelationModel,
            'addButtonPosition' => MultipleInput::POS_HEADER,
            'columns' => $columns
        ];
        return $widgetOptions;
    }

    public function getMultipleInputField() {
        if ($this->multipleInputField === false || !$this->attribute) {
            return false;
        }

        $field = parent::getMultipleInputField();
        unset($field['options']['placeholder']);
        $options = $this->getMultipleInputWidgetOptions();
        return ArrayHelper::merge($field, [
            'options' => $options,
        ]);
    }

//    public function getRelationSourceText($attribute) {
//        $models = $this->getValue();
//        $result = ArrayHelper::map($models, $attribute, 'name');
//
//        return $result;
//    }
}