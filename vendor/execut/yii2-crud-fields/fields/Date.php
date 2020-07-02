<?php
/**
 */

namespace execut\crudFields\fields;


use detalika\requests\helpers\DateTimeHelper;
use kartik\daterange\DateRangePicker;
use kartik\detail\DetailView;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class Date extends Field
{
    public $isTime = false;
    public $fieldType = null;
    public $displayOnly = true;
    public $showIfEmpty = false;
    public $isWithMicroseconds = false;

    public function getColumn()
    {
        $parentColumn = parent::getColumn();
        if ($parentColumn === false) {
            return false;
        }

        $widgetOptions = $this->getWidgetOptions();

        $column = [
            'format' => function ($value) {
                return $this->formatDateValue($value);
            },
        ];

        if ($this->rules !== false) {
            $column['filter'] = DateRangePicker::widget($widgetOptions);
        }

        return ArrayHelper::merge($column, $parentColumn);
    }

    protected function formatDateValue($value) {
        if (!empty($value)) {
            $dateTime = \DateTime::createFromFormat($this->getDatabaseFormat(true), $value, new \DateTimeZone(\yii::$app->formatter->defaultTimeZone));
            if (!$dateTime) {
                $dateTime = \DateTime::createFromFormat($this->getDatabaseFormat(false), $value, new \DateTimeZone(\yii::$app->formatter->defaultTimeZone));
            }
            if (!$dateTime) {
                throw new Exception('Failed to format date ' . $value . ' to format ' . $this->getDatabaseFormat(false));
            }

            return $dateTime->format($this->getFormat());
        }
    }

    public function getField()
    {
        if (empty($this->getValue()) && $this->displayOnly) {
            if ($this->showIfEmpty) {
                return [
                    'label' => $this->getLabel(),
                    'displayOnly' => true,
                    'value' => '-',
                ];
            } else {
                return false;
            }
        }

        $field = parent::getField();
        if ($field === false) {
            return false;
        }

        if ($this->displayOnly) {
            return array_merge($field, [
                'displayOnly' => true,
                'value' => function () {
                    $value = $this->getValue();
                    if (!empty($value)) {
                        return $this->formatDateValue($value);
                    }
                },
            ]);
        }

        if ($this->isTime) {
            $type = DetailView::INPUT_DATETIME;
        } else {
            $type = DetailView::INPUT_DATE;
        }

        if ($this->fieldType !== null) {
            $type = $this->fieldType;
        }

        return [
            'type' => $type,
            'attribute' => $this->attribute,
            'format' => ['date', $this->getFormat()],
            'widgetOptions' => $this->getWidgetOptions(),
        ];
    }

    public function getMultipleInputField()
    {
        if ($this->displayOnly) {
            return false;
        }

        return parent::getMultipleInputField(); // TODO: Change the autogenerated stub
    }

    protected function _applyScopes(ActiveQuery $query)
    {
        $modelClass = $query->modelClass;
        $attribute = $this->attribute;
        $t = $modelClass::tableName();
        $value = $this->model->$attribute;
        if (!empty($value) && strpos($value, ' - ') !== false) {
            list($from, $to) = explode(' - ', $value);
            if (!$this->isTime) {
                $from = $from . ' 00:00:00';
                $to = $to . ' 23:59:59';
            }

            $dateTimeFormat = $this->getFormat(false, false);
            $fromUtc = self::convertToUtc($from, $dateTimeFormat);
            $dateTimeFormat = $this->getFormat(false, false);
            $toUtc = self::convertToUtc($to, $dateTimeFormat);

            $query->andFilterWhere(['>=', $t . '.' . $attribute, $fromUtc])
                ->andFilterWhere(['<=', $t . '.' . $attribute, $toUtc]);
        }
    }

    public static function convertToUtc($dateTimeStr, $format)
    {
        $dateTime = \DateTime::createFromFormat(
            $format,
            $dateTimeStr,
            self::getApplicationTimeZone()
        );

        $dateTime->setTimezone(new \DateTimeZone(self::getDatabaseTimeZone()));
        return $dateTime->format('Y-m-d H:i:s.u');
    }

    protected static function getDatabaseTimeZone() {
        return 'Europe/Moscow';
    }

    private static function getApplicationTimeZone()
    {
        return (new \DateTimeZone(\Yii::$app->timeZone));
    }

    /**
     * @return array
     */
    protected function getWidgetOptions(): array
    {
        $format = $this->getFormat(false, false);
        $pluginOptions = [
            'format' => $this->getFormat(true),
            'locale' => ['format' => $format, 'separator' => ' - '],
            'todayHightlight' => true,
            'showSeconds' => true,
            'minuteStep' => 1,
            'secondStep' => 1,
        ];

        if ($this->isTime) {
            $pluginOptions = ArrayHelper::merge($pluginOptions, [
                'timePicker' => true,
                'timePickerIncrement' => 15,
            ]);
        }

        $widgetOptions = [
            'attribute' => $this->attribute,
            'model' => $this->model,
            'convertFormat' => true,
            'pluginOptions' => $pluginOptions
        ];
        return $widgetOptions;
    }

    /**
     * @return string
     */
    protected function getFormat($isForJs = false, $isWithMicroseconds = null): string
    {
        if ($isForJs) {
            $format = 'yyyy-MM-dd';
        } else {
            $format = 'd.m.Y';
        }

        if ($this->isTime) {
            if ($isForJs) {
                $isWithMicroseconds = false;
            }

            $format .= ' ' . $this->getTimeFormat($isWithMicroseconds);
        }

        return $format;
    }

    protected function getDatabaseFormat($isWithMicroseconds = null) {
        $format = 'Y-m-d';
        if ($this->isTime) {
            $format .= ' ' . $this->getTimeFormat($isWithMicroseconds);
        }

        return $format;
    }

    /**
     * @return string
     */
    protected function getTimeFormat($isWithMicroseconds = null): string
    {
        if (!$this->isTime) {
            return false;
        }

        $format = 'H:i:s';
        if ($isWithMicroseconds || $isWithMicroseconds === null && $this->isWithMicroseconds) {
            $format .= '.u';
        }

        return $format;
    }
}