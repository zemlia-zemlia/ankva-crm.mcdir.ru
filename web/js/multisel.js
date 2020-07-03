jQuery(function ($) {
    jQuery("#contragent_phone").inputmask(inputmask_e8a63036);
    jQuery("#realtyobjectform-phone_2").inputmask(inputmask_e8a63036);
    jQuery("#whatsapp_input").inputmask(inputmask_e8a63036);
    jQuery("#viber_input").inputmask(inputmask_e8a63036);
    jQuery("#dublication_search_phone").inputmask(inputmask_e8a63036);
    jQuery&&jQuery.pjax&&(jQuery.pjax.defaults.maxCacheLength=0);
    if (jQuery('#release_date').data('datetimepicker')) { jQuery('#release_date').datetimepicker('destroy'); }
    jQuery('#release_date-datetime').datetimepicker(datetimepicker_6ca80f2e);

    jQuery("#realtyobjectform-description").redactor({"lang":"ru","minHeight":200,"plugins":["fullscreen"],"uploadImageFields":{"_csrf":"6Bz-mcSRx4Xb2ie5KLkfFhWEGzm26V_9CX7-0gnYf8PdcI7UsPOj5Ou-Sowd_F5MUbZBScSLEaVnErOqO5keuw=="},"uploadFileFields":{"_csrf":"6Bz-mcSRx4Xb2ie5KLkfFhWEGzm26V_9CX7-0gnYf8PdcI7UsPOj5Ou-Sowd_F5MUbZBScSLEaVnErOqO5keuw=="}});
    jQuery("#realtyobjectform-service_info").redactor({"lang":"ru","minHeight":200,"plugins":["fullscreen"],"uploadImageFields":{"_csrf":"6Bz-mcSRx4Xb2ie5KLkfFhWEGzm26V_9CX7-0gnYf8PdcI7UsPOj5Ou-Sowd_F5MUbZBScSLEaVnErOqO5keuw=="},"uploadFileFields":{"_csrf":"6Bz-mcSRx4Xb2ie5KLkfFhWEGzm26V_9CX7-0gnYf8PdcI7UsPOj5Ou-Sowd_F5MUbZBScSLEaVnErOqO5keuw=="}});
    if (jQuery('#call_back_date').data('datetimepicker')) { jQuery('#call_back_date').datetimepicker('destroy'); }
    jQuery('#call_back_date-datetime').datetimepicker(datetimepicker_6ca80f2e);

    jQuery('#realty_object_form').yiiActiveForm(
        [{"id":"realtyobjectform-images","name":"images","container":".field-realtyobjectform-images","input":"#realtyobjectform-images",
            "validate":function (attribute, value, messages, deferred, $form)
            {yii.validation.string(value, messages, {"message":"Значение «Фотографии» должно быть строкой.","skipOnEmpty":1});}}
            ,{"id":"realtyobjectform-nd","name":"nd","container":".field-realtyobjectform-nd","input":"#realtyobjectform-nd",
            "validate":function (attribute, value, messages, deferred, $form)
            {yii.validation.boolean(value, messages, {"trueValue":"1","falseValue":"0","message":"Значение «Недоступен» должно быть равно «1» или «0».","skipOnEmpty":1});}},
            {"id":"realtyobjectform-images_order","name":"images_order","container":".field-images_order","input":"#images_order",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages,
                    {"message":"Значение «Images Order» должно быть строкой.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-category","name":"category","container":".field-category_list","input":"#category_list",
                "validate":function (attribute, value, messages, deferred, $form)
                {yii.validation.required(value, messages, {"message":"Необходимо заполнить «Категория»."});
                yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Категория» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-type","name":"type","container":".field-type_list","input":"#type_list","validate":
                    function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Необходимо заполнить «Сдам/Продам»."});
                    yii.validation.number(value, messages, {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Сдам\/Продам» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-name","name":"name","container":".field-realtyobjectform-name","input":"#realtyobjectform-name",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages,
                    {"message":"Значение «Имя» должно быть строкой.","max":255,"tooLong":"Значение «Имя» должно содержать максимум 255 символа.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-phone","name":"phone","container":".field-contragent_phone","input":"#contragent_phone","validate":
                    function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Необходимо заполнить «Телефон»."});
                    yii.validation.regularExpression(value, messages, {"pattern":/^\+7 \(9\d{2}\) \d{3} \d{2} \d{2}$/,
                        "not":false,"message":"Телефон указан неверно","skipOnEmpty":1});}},{"id":"realtyobjectform-phone_2",
            "name":"phone_2","container":".field-realtyobjectform-phone_2","input":"#realtyobjectform-phone_2",
            "validate":function (attribute, value, messages, deferred, $form)
            {yii.validation.regularExpression(value, messages, {"pattern":/^\+7 \(9\d{2}\) \d{3} \d{2} \d{2}$/,"not":false,"message":"Телефон указан неверно","skipOnEmpty":1});}},
            {"id":"realtyobjectform-email","name":"email","container":".field-realtyobjectform-email","input":"#realtyobjectform-email",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages,
                    {"message":"Значение «E-mail» должно быть строкой.","max":255,"tooLong":"Значение «E-mail» должно содержать максимум 255 символа.","skipOnEmpty":1});
                yii.validation.email(value, messages,
                    {"pattern":/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/,
                        "fullPattern":/^[^@]*<[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/,
                        "allowName":false,"message":"Значение «E-mail» не является правильным email адресом.","enableIDN":false,"skipOnEmpty":1});}},{"id":"realtyobjectform-use_telegram","name":"use_telegram","container":".field-telegram_checkbox",
            "input":"#telegram_checkbox","validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages,
                {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Telegram» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-telegram","name":"telegram","container":".field-telegram_input","input":"#telegram_input",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages,
                    {"message":"Значение «Telegram» должно быть строкой.","max":255,"tooLong":"Значение «Telegram» должно содержать максимум 255 символа.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-use_whatsapp","name":"use_whatsapp","container":".field-whatsapp_checkbox","input":"#whatsapp_checkbox",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages,
                    {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «WhatsApp» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-whatsapp","name":"whatsapp","container":".field-whatsapp_input","input":"#whatsapp_input",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.regularExpression(value, messages,
                    {"pattern":/^\+7 \(9\d{2}\) \d{3} \d{2} \d{2}$/,"not":false,"message":"Телефон указан неверно","skipOnEmpty":1});}},
            {"id":"realtyobjectform-use_viber","name":"use_viber","container":".field-viber_checkbox","input":"#viber_checkbox",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages,
                    {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Viber» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-viber","name":"viber","container":".field-viber_input","input":"#viber_input",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.regularExpression(value, messages,
                    {"pattern":/^\+7 \(9\d{2}\) \d{3} \d{2} \d{2}$/,"not":false,"message":"Телефон указан неверно","skipOnEmpty":1});}},
            {"id":"realtyobjectform-use_vk","name":"use_vk","container":".field-vk_checkbox","input":"#vk_checkbox",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages,
                    {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «ВКонтакте» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-vk","name":"vk","container":".field-vk_input","input":"#vk_input","validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages,
                    {"message":"Значение «ВКонтакте» должно быть строкой.","max":255,"tooLong":"Значение «ВКонтакте» должно содержать максимум 255 символа.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-region","name":"region","container":".field-location_region_selector","input":"#location_region_selector",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages,
                    {"message":"Необходимо заполнить «Область»."});yii.validation.number(value, messages,
                    {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Область» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-city","name":"city","container":".field-location_city_selector","input":"#location_city_selector",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages,
                    {"message":"Необходимо заполнить «Город»."});yii.validation.number(value, messages,
                    {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Город» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-district_id","name":"district_id","container":".field-location_district_selector","input":"#location_district_selector",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages,
                    {"pattern":/^\s*[+-]?\d+\s*$/,"message":"Значение «Район» должно быть целым числом.","skipOnEmpty":1});}},
            {"id":"realtyobjectform-street","name":"street","container":".field-street_address","input":"#street_address",
                "validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages,
                    {"message":"Необходимо заполнить «Улица»."});yii.validation.string(value, messages,
                    {"message":"Значение «Улица» должно быть строкой.","max":255,"tooLong":"Значение «Улица» должно содержать максимум 255 символа.","skipOnEmpty":1});}}])});
