<?php

namespace app\helpers;

use Yii;
use app\models\CommercialTypeProperty;
use app\models\RealtyObject;
use app\models\TypeProperty;
use yii\helpers\Html;

class ObjectHelper
{
    public static function statusName($status)
    {
        switch ($status) {
            case RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC :
                return 'Актуален';
                break;
            case RealtyObject::REALTY_OBJECT_BOARD_STATUS_ARCHIVE :
                return 'В архиве';
                break;
            case RealtyObject::REALTY_OBJECT_BOARD_STATUS_DELETED :
                return 'Удален';
                break;
            default :
                return '';
                break;
        }
    }


    public static function statusLabel(RealtyObject $object)
    {
        switch ($object->status) {

            case RealtyObject::REALTY_OBJECT_BOARD_STATUS_PUBLIC :
                $class = 'label label-success';
                break;
            case RealtyObject::REALTY_OBJECT_BOARD_STATUS_ARCHIVE :
                $class = 'label label-warning';
                break;
            case RealtyObject::REALTY_OBJECT_BOARD_STATUS_DELETED :
                $class = 'label label-danger';
                break;
            default:
                $class = 'label';
        }

        return Html::tag('div', self::statusName($object->status), [
            'class' => $class,
        ]);
    }


    public static function categoryList()
    {
        return [
            RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL => 'Жилая недвижимость',
            RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL => 'Коммерческая недвижимость',
        ];
    }


    public static function categoryName($category)
    {
        switch ($category) {
            case RealtyObject::REALTY_OBJECT_CATEGORY_RESIDENTAL :
                return 'Жилая недвижимость';
                break;
            case RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL :
                return 'Коммерческая недвижимость';
                break;
            default :
                return '';
                break;
        }
    }


    public static function typeList()
    {
        return [
            RealtyObject::REALTY_OBJECT_TYPE_RENT => 'Сдам',
            RealtyObject::REALTY_OBJECT_TYPE_SELL => 'Продам',
        ];
    }


    public static function typeName($type)
    {
        switch ($type) {
            case RealtyObject::REALTY_OBJECT_TYPE_RENT :
                return 'Сдам';
                break;
            case RealtyObject::REALTY_OBJECT_TYPE_SELL :
                return 'Продам';
                break;
            default :
                return '';
                break;
        }
    }

    // Отображение на сайте и в карточках
    public static function typeNamePrint($type)
    {
        switch ($type) {
            case RealtyObject::REALTY_OBJECT_TYPE_RENT :
                return 'в аренду';
                break;
            case RealtyObject::REALTY_OBJECT_TYPE_SELL :
                return 'в продажу';
                break;
            default :
                return '';
                break;
        }
    }


    public static function propertyTypeList($category)
    {
        if ($category == RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL) {
            return self::commercialPropertyTypeList();
        } else {
            return self::residenralPropertyTypeList();
        }
    }


    public static function propertyTypeName($category, $type_id)
    {
        if ($category == RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL) {
            return self::commercialPropertyTypeName($type_id);
        } else {
            return self::residenralPropertyTypeName($type_id);
        }
    }


    private static function residenralPropertyTypeList($typeproperty_id = null)
    {
        /*
        if ($typeproperty_id) {
            $cities = TypeProperty::find()->select(['id', 'name'])->asArray()->where(['region_id' => $region_id])->all();
            return ArrayHelper::map($cities, 'id', 'name');
        }
*/
        $typeproperty_id = '1';
        $types = TypeProperty::find()->where(['id_company' => Yii::$app->user->identity->id_company])->all();
        $list = [];

        /** @var TypeProperty $type */
        foreach ($types as $type) {
            $list[$type->id] = $type->name;
        }

        return $list;

    }


    private static function commercialPropertyTypeList()
    {
        $types = CommercialTypeProperty::find()->all();
        $list = [];

        /** @var CommercialTypeProperty $type */
        foreach ($types as $type) {
            $list[$type->id] = $type->name;
        }

        return $list;
    }


    private static function residenralPropertyTypeName($type_id)
    {
        $type = TypeProperty::findOne($type_id);
        return $type->name;
    }


    private static function commercialPropertyTypeName($type_id)
    {
        $type = CommercialTypeProperty::findOne($type_id);
        return $type->name;
    }

    public static function propertyPrintTypeName($category, $type_id)
    {
        if ($category == RealtyObject::REALTY_OBJECT_CATEGORY_COMMERCIAL) {
            return self::commercialPrintPropertyTypeName($type_id);
        } else {
            return self::residenralPrintPropertyTypeName($type_id);
        }
    }

    private static function residenralPrintPropertyTypeName($type_id)
    {
        $type = TypeProperty::findOne($type_id);
        return $type->name_full;
    }


    private static function commercialPrintPropertyTypeName($type_id)
    {
        $type = CommercialTypeProperty::findOne($type_id);
        return $type->name_full;
    }



    public static function tradeList()
    {
        return [
            0 => 'Нет',
            1 => 'Да',
        ];
    }


    public static function tradeName($trade)
    {
        switch ($trade) {
            case '1' :
                return 'Да';
                break;
            case '0' :
                return 'Нет';
                break;
            default :
                return '';
                break;
        }
    }


    public static function checkName($check)
    {
        switch ($check) {
            case '1' :
                return 'Отмечено';
                break;
            case '0' :
                return 'Не отмечено';
                break;
            default :
                return '';
                break;
        }
    }


    public static function repairTypeList()
    {
        return [
            RealtyObject::REALTY_OBJECT_REPAIR_TYPE_SIMPLE => 'Обычный',
            RealtyObject::REALTY_OBJECT_REPAIR_TYPE_EURO => 'Евро',
            RealtyObject::REALTY_OBJECT_REPAIR_TYPE_COSMETIC => 'Косметический',
            RealtyObject::REALTY_OBJECT_REPAIR_TYPE_DRAFT => 'Черновой',
        ];
    }


    public static function repairName($reapir)
    {
        switch ($reapir) {
            case RealtyObject::REALTY_OBJECT_REPAIR_TYPE_SIMPLE :
                return 'Обычный';
                break;
            case RealtyObject::REALTY_OBJECT_REPAIR_TYPE_EURO :
                return 'Евро';
                break;
            case RealtyObject::REALTY_OBJECT_REPAIR_TYPE_COSMETIC :
                return 'Косметический';
                break;
            case RealtyObject::REALTY_OBJECT_REPAIR_TYPE_DRAFT :
                return 'Черновой';
                break;
            default :
                return '';
                break;
        }
    }


    public static function furnitureList()
    {
        return [
            RealtyObject::REALTY_OBJECT_FURNITURE_YES => 'Есть',
            RealtyObject::REALTY_OBJECT_FURNITURE_SOME => 'Частично',
            RealtyObject::REALTY_OBJECT_FURNITURE_NO => 'Нет',
        ];
    }


    public static function furnitureName($furniture)
    {
        switch ($furniture) {
            case RealtyObject::REALTY_OBJECT_FURNITURE_YES :
                return 'Есть';
                break;
            case RealtyObject::REALTY_OBJECT_FURNITURE_SOME :
                return 'Частично';
                break;
            case RealtyObject::REALTY_OBJECT_FURNITURE_NO :
                return 'Нет';
                break;
            default :
                return '';
                break;
        }
    }


    public static function classTypeList()
    {
        return [
            RealtyObject::REALTY_OBJECT_CLASS_TYPE_NEW => 'Новостройка',
            RealtyObject::REALTY_OBJECT_CLASS_TYPE_SECONDARY => 'Вторичка',
        ];
    }


    public static function classTypeName($class)
    {
        switch ($class) {
            case RealtyObject::REALTY_OBJECT_CLASS_TYPE_NEW :
                return 'Новостройка';
                break;
            case RealtyObject::REALTY_OBJECT_CLASS_TYPE_SECONDARY :
                return 'Вторичка';
                break;
            default :
                return '';
                break;
        }
    }


    public static function buildTypeList()
    {
        return [
            RealtyObject::REALTY_OBJECT_BUILD_TYPE_BRICK => 'Кирпичный',
            RealtyObject::REALTY_OBJECT_BUILD_TYPE_PANEL => 'Панельный',
            RealtyObject::REALTY_OBJECT_BUILD_TYPE_BLOCK => 'Блочный',
            RealtyObject::REALTY_OBJECT_BUILD_TYPE_MONOLIT => 'Монолитный',
            RealtyObject::REALTY_OBJECT_BUILD_TYPE_WOOD => 'Деревянный',
        ];
    }


    public static function buildTypeName($type)
    {
        switch ($type) {
            case RealtyObject::REALTY_OBJECT_BUILD_TYPE_BRICK :
                return 'Кирпичный';
                break;
            case RealtyObject::REALTY_OBJECT_BUILD_TYPE_PANEL :
                return 'Панельный';
                break;
            case RealtyObject::REALTY_OBJECT_BUILD_TYPE_BLOCK :
                return 'Блочный';
                break;
            case RealtyObject::REALTY_OBJECT_BUILD_TYPE_MONOLIT :
                return 'Монолитный';
                break;
            case RealtyObject::REALTY_OBJECT_BUILD_TYPE_WOOD :
                return 'Деревянный';
                break;
            default :
                return '';
                break;
        }
    }


    public static function utilityTypeList()
    {
        return [
            RealtyObject::REALTY_OBJECT_UTILITY_TYPE_NO => 'Нет',
            RealtyObject::REALTY_OBJECT_UTILITY_TYPE_ALL => 'Все',
            RealtyObject::REALTY_OBJECT_UTILITY_TYPE_COUNTERS => 'По приборам учета',
        ];
    }


    public static function utilityTypeName($type)
    {
        switch ($type) {
            case RealtyObject::REALTY_OBJECT_UTILITY_TYPE_NO :
                return 'Нет';
                break;
            case RealtyObject::REALTY_OBJECT_UTILITY_TYPE_ALL :
                return 'Все';
                break;
            case RealtyObject::REALTY_OBJECT_UTILITY_TYPE_COUNTERS :
                return 'По приборам учета';
                break;
            default :
                return '';
                break;
        }
    }
}