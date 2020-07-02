<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $ban_payment
 * @property int $city
 * @property string $smsc_login
 * @property string $smsc_password
 *
 *                 $image = Image::getImagine()->open('watermark/1/2391daca10352c1e16235d7b7ab197c7.png');
$watermark = Image::getImagine()->open('watermark/1/2391daca10352c1e16235d7b7ab197c7.png');

 *
 *
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }
    public $watermark;
    public $file;
    public $file2;

    public $logo;

    public $del_img;
    public $del_img2;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'url', 'smsc_login', 'smsc_password'], 'required'],
             ['watermark', 'image',
                'extensions' => ['jpg', 'jpeg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 512000,
                'tooBig' => 'Максимальный лимит загрузки изображения 500KB'
            ],
            [['file'], 'file', 'extensions' => 'png, jpg',  'checkExtensionByMimeType' => true,
                'maxSize' => 512000],
            [['file2'], 'file', 'extensions' => 'png, jpg',  'checkExtensionByMimeType' => true,
                'maxSize' => 512000],
            [['del_img' , 'del_img2'], 'boolean'],
            [['politica' , 'dogovor'], 'string'],

            [['ya_metrika_id', 'go_analitics_id', 'jivo_id' , 'chatra_id'], 'integer', 'max' => 25],

            [['id', 'ban_payment', 'city_id', 'region', 'multiregion', 'multirayon', 'residential_rent','residential_sale','commercial_rent' ,'commercial_sale', 'phone', 'cadastral', 'service_information', 'responsible', 'additional_contact'], 'integer'],
            [['smsc_login', 'smsc_password'], 'string', 'max' => 255],
            [['name', 'url', 'crm_name'], 'string', 'max' => 255],
            [['name_site', 'subname_site', 'description_site', 'keys_site'], 'string', 'max' => 255],
            [['address', 'phone', 'email', 'vk', 'instagram','whatsapp','viber' ,'telegram','facebook'], 'string', 'max' => 255],

            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'crm_name' => 'CRM название',
            'name_site' => 'Наименование сайта',
            'subname_site' => 'Слоган сайта',
            'description_site' => 'Описание сайта (Description)',
            'keys_site' => 'Ключи для сайта (Keys)',
            'del_img' => 'Удалить изображение',
            'del_img2' => 'Удалить изображение',

            'url' => 'Url сайта',
            'ban_payment' => 'Ban Payment',
            'region' => 'Регион',
            'city_id' => 'Город работы',
            'multiregion' => 'Мультирегиональность',
            'multirayon' => 'Работа по области',

            'smsc_login' => 'SMSC.ru Логин',
            'smsc_password' => 'SMSC.ru Пароль',
            'watermark' => 'Изображение',
            'file' => 'Изображение',
            'logo' => 'Изображение',
            'file2' => 'Изображение',

            'cadastral' => 'Кадастровый номер',
            'service_information' => 'Служебная информация',
            'responsible' => 'Ответственный и воронка',
            'additional_contact' => 'Дополнительные контакты собсвенника (Telegram, viber и тд)',

            'address' => 'Контактный адресс',
            'phone' => 'Контактный телефон',

            'residential_rent' => 'Жилая - Аренда',
            'residential_sale' => 'Жилая - Продажа',
            'commercial_rent' => 'Коммерческая - Аренда',
            'commercial_sale' => 'Коммерческая - Продажа',
            'politica' => 'Политика конфедициальности',
            'dogovor' => 'Договор - оферта',


            'ya_metrika_id' => 'Яндекс Метрика',
            'go_analitics_id' => 'Google Analytics',
            'jivo_id' => 'JivoSite (id)',
            'chatra_id' => 'Chatra (id)',




        ];
    }






}
