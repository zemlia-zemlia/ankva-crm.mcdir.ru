<?php

namespace lav45\activityLogger;

use yii\base\Behavior;
use yii\base\InvalidValueException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Class ActiveLogBehavior
 * @package lav45\activityLogger
 *
 * ======================= Example usage ======================
 *
 *  // Recommended
 *  public function transactions()
 *  {
 *      return [
 *          ActiveRecord::SCENARIO_DEFAULT => ActiveRecord::OP_ALL,
 *      ];
 *  }
 *
 *  public function behaviors()
 *  {
 *      return [
 *          [
 *              'class' => 'lav45\activityLogger\ActiveLogBehavior',
 *              'attributes' => [
 *                  // simple attribute
 *                  'title',
 *
 *                  // the value of the attribute is a item in the list
 *                  'status' => [
 *                      // => $this->getStatusList()
 *                      'list' => 'statusList'
 *                  ],
 *
 *                  // the attribute value is the [id] of the relation model
 *                  'owner_id' => [
 *                      'relation' => 'owner',
 *                      'attribute' => 'username',
 *                  ],
 *              ]
 *          ]
 *      ];
 *  }
 * ============================================================
 *
 * @property string $entityName
 * @property string $entityId
 * @property ActiveRecord $owner
 */
class ActiveLogBehavior extends Behavior
{
    use ManagerTrait;

    /**
     * @event MessageEvent an event that is triggered before inserting a record.
     * You may added in to the [[MessageEvent::append]] your custom log message.
     * @since 1.5.3
     */
    const EVENT_BEFORE_SAVE_MESSAGE = 'beforeSaveMessage';
    /**
     * @event Event an event that is triggered after inserting a record.
     * @since 1.5.3
     */
    const EVENT_AFTER_SAVE_MESSAGE = 'afterSaveMessage';

    /**
     * @var bool
     */
    public $softDelete = false;
    /**
     * @var array
     *  - create
     *  - update
     *  - delete
     */
    public $actionLabels = [
        'create' => 'created',
        'update' => 'updated',
        'delete' => 'removed',
    ];
    /**
     * @var array [
     *  // simple attribute
     *  'title',
     *
     *  // simple boolean attribute
     *  'is_publish',
     *
     *  // the value of the attribute is a item in the list
     *  // => $this->getStatusList()
     *  'status' => [
     *      'list' => 'statusList'
     *  ],
     *
     *  // the attribute value is the [id] of the relation model
     *  'owner_id' => [
     *      'relation' => 'user',
     *      'attribute' => 'username'
     *  ]
     * ]
     */
    public $attributes = [];
    /**
     * @var bool
     */
    public $identicalAttributes = false;
    /**
     * @var callable a PHP callable that replaces the default implementation of [[isEmpty()]].
     * @since 1.5.2
     */
    public $isEmpty;
    /**
     * @var \Closure|array|string custom method to getEntityName
     * the callback function must return a string
     */
    public $getEntityName;
    /**
     * @var \Closure|array|string custom method to getEntityId
     * the callback function can return a string or array
     */
    public $getEntityId;
    /**
     * @var array [
     *  'title' => [
     *      'new' => ['value' => 'New title'],
     *  ],
     *  'is_publish' => [
     *      'old' => ['value' => false],
     *      'new' => ['value' => true],
     *  ],
     *  'status' => [
     *      'old' => ['id' => 0, 'value' => 'Disabled'],
     *      'new' => ['id' => 1, 'value' => 'Active'],
     *  ],
     *  'owner_id' => [
     *      'old' => ['id' => 1, 'value' => 'admin'],
     *      'new' => ['id' => 2, 'value' => 'lucy'],
     *  ]
     * ]
     */
    private $changedAttributes = [];
    /**
     * @var string
     */
    private $actionName;

    /**
     * Initializes the object.
     */
    public function init()
    {
        $this->initAttributes();
    }

    private function initAttributes()
    {
        foreach ($this->attributes as $key => $value) {
            if (is_int($key)) {
                unset($this->attributes[$key]);
                $this->attributes[$value] = null;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        if ($this->getLogger()->enabled === false) {
            return [];
        }

        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function beforeSave()
    {
        $this->changedAttributes = $this->prepareChangedAttributes();
        $this->actionName = $this->getActionLabel($this->owner->getIsNewRecord() ? 'create' : 'update');
    }

    public function afterSave()
    {
        if (empty($this->changedAttributes)) {
            return;
        }
        $this->saveMessage($this->actionName, $this->changedAttributes);
    }

    public function beforeDelete()
    {
        if ($this->softDelete === false) {
            $this->getLogger()->delete($this->getEntityName(), $this->getEntityId());
        }

        $this->saveMessage($this->getActionLabel('delete'), $this->prepareChangedAttributes(true));
    }

    /**
     * @param string $label
     * @return string|null
     */
    private function getActionLabel($label)
    {
        return ArrayHelper::getValue($this->actionLabels, $label);
    }

    /**
     * @param bool $unset
     * @return array
     */
    private function prepareChangedAttributes($unset = false)
    {
        $result = [];
        foreach ($this->attributes as $attribute => $options) {
            $old = $this->owner->getOldAttribute($attribute);
            $new = $unset === false ? $this->owner->getAttribute($attribute) : null;

            if ($this->isEmpty($old) && $this->isEmpty($new)) {
                continue;
            }
            if ($unset === false && $this->isAttributeChanged($attribute) === false) {
                continue;
            }

            $result[$attribute] = $this->resolveStoreValues($old, $new, $options);
        }
        return $result;
    }

    /**
     * @param string $attribute
     * @return bool
     */
    private function isAttributeChanged($attribute)
    {
        return $this->owner->isAttributeChanged($attribute, $this->identicalAttributes);
    }

    /**
     * @param array $data
     * @return array
     */
    private function filterStoreValues(array $data)
    {
        if (isset($data['old']) && !isset($data['old']['value'])) {
            unset($data['old']);
        }
        return $data;
    }

    /**
     * @param string|int $old_id
     * @param string|int $new_id
     * @param array $options
     * @return array
     */
    protected function resolveStoreValues($old_id, $new_id, $options)
    {
        if (isset($options['list'])) {
            $value = $this->resolveListValues($old_id, $new_id, $options['list']);
        } elseif (isset($options['relation'], $options['attribute'])) {
            $value = $this->resolveRelationValues($old_id, $new_id, $options['relation'], $options['attribute']);
        } else {
            $value = $this->resolveSimpleValues($old_id, $new_id);
        }
        return $this->filterStoreValues($value);
    }

    /**
     * @param string|int $old_id
     * @param string|int $new_id
     * @return array
     */
    private function resolveSimpleValues($old_id, $new_id)
    {
        return [
            'old' => ['value' => $old_id],
            'new' => ['value' => $new_id],
        ];
    }

    /**
     * @param string|int $old_id
     * @param string|int $new_id
     * @param string $listName
     * @return array
     */
    private function resolveListValues($old_id, $new_id, $listName)
    {
        $old['id'] = $old_id;
        $new['id'] = $new_id;

        $old['value'] = ArrayHelper::getValue($this->owner, [$listName, $old_id]);
        $new['value'] = ArrayHelper::getValue($this->owner, [$listName, $new_id]);

        return [
            'old' => $old,
            'new' => $new
        ];
    }

    /**
     * @param string|int $old_id
     * @param string|int $new_id
     * @param string $relation
     * @param string $attribute
     * @return array
     */
    private function resolveRelationValues($old_id, $new_id, $relation, $attribute)
    {
        $old['id'] = $old_id;
        $new['id'] = $new_id;

        $relationQuery = clone $this->owner->getRelation($relation);
        $relationQuery->primaryModel = null;
        $idAttribute = array_keys($relationQuery->link)[0];
        $targetId = array_filter([$old_id, $new_id]);

        $relationModels = $relationQuery
            ->where([$idAttribute => $targetId])
            ->indexBy($idAttribute)
            ->limit(count($targetId))
            ->all();

        $old['value'] = ArrayHelper::getValue($relationModels, [$old_id, $attribute]);
        $new['value'] = ArrayHelper::getValue($relationModels, [$new_id, $attribute]);

        return [
            'old' => $old,
            'new' => $new
        ];
    }

    /**
     * @param string $action
     * @param array $data
     */
    protected function saveMessage($action, array $data)
    {
        $data = $this->beforeSaveMessage($data);

        $this->getLogger()->log($this->getEntityName(), $data, $action, $this->getEntityId());

        $this->afterSaveMessage();
    }

    /**
     * @param array $data
     * @return array
     * @since 1.5.3
     */
    public function beforeSaveMessage($data)
    {
        $name = self::EVENT_BEFORE_SAVE_MESSAGE;

        if (method_exists($this->owner, $name)) {
            return $this->owner->$name($data);
        }

        $event = new MessageEvent();
        $event->logData = $data;
        $this->owner->trigger($name, $event);
        return $event->logData;
    }

    /**
     * @since 1.5.3
     */
    public function afterSaveMessage()
    {
        $name = self::EVENT_AFTER_SAVE_MESSAGE;

        if (method_exists($this->owner, $name)) {
            $this->owner->$name();
        } else {
            $this->owner->trigger($name);
        }
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        if ($this->getEntityName !== null) {
            return call_user_func($this->getEntityName);
        }
        $class = StringHelper::basename(get_class($this->owner));
        return Inflector::camel2id($class, '_');
    }

    /**
     * @return string
     */
    public function getEntityId()
    {
        if ($this->getEntityId === null) {
            $result = $this->owner->getPrimaryKey();
        } else {
            $result = call_user_func($this->getEntityId);
        }
        if (empty($result)) {
            throw new InvalidValueException('the property "entityId" can not be empty');
        }
        if (is_array($result)) {
            ksort($result);
            $result = json_encode($result, 320);
        }
        return $result;
    }

    /**
     * Checks if the given value is empty.
     * A value is considered empty if it is null, an empty array, or an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     * @param mixed $value the value to be checked
     * @return bool whether the value is empty
     * @since 1.5.2
     */
    public function isEmpty($value)
    {
        if ($this->isEmpty !== null) {
            return call_user_func($this->isEmpty, $value);
        }
        return $value === null || $value === '';
    }
}
