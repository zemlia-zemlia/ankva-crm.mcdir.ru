/* Theme Name:iDea - Clean & Powerful Bootstrap Theme
 * Author:HtmlCoder
 * Author URI:http://www.htmlcoder.me
 * Author e-mail:htmlcoder.me@gmail.com
 * Version: 1.5
 * Created:October 2014
 * License URI:http://support.wrapbootstrap.com/
 * File Description: Place here your custom scripts
 */

$(document).ready(function() {
    
    $('.btn-discription').on('click', function () {
        
        if ( this.getAttribute('data-do') === 'open-description' ) {
            var nextElement = this.nextSibling;
            $(nextElement).fadeIn(400);
            this.style.display = 'none';
        }
        
        if ( this.getAttribute('data-do') === 'close-description' ) {
            var parentElement = this.parentNode;
            var prevElement = parentElement.previousSibling;
            $(parentElement).fadeOut(400);
            prevElement.style.display = 'block';
        }
        
    });

    $('.description-btn').on('click', function () {

        var action = $(this).attr('data-do');
        var id = $(this).attr('data-id');
        var short_description = $('#short_description_' + id);
        var full_description = $('#full_description_' + id);

        if (action === 'open-description') {
            short_description.fadeOut('fast', function () {
                full_description.fadeIn();
            });
        }

        if (action === 'close-description') {
            full_description.fadeOut('fast', function () {
                short_description.fadeIn();
            });
        }
    });
    
    $("#gallery-wrapper").on("hidden.bs.modal", function () {
        
        var modalBody = document.getElementById('gallery-wrapper');
        var currentSlider = modalBody.querySelector('[class=modal-body]');
        
        currentSlider.innerHTML = '';
    });
    
    $('.notes-ads').on('click', function () {
        nextElement = this.nextSibling;
        $(nextElement).fadeIn();
    });
    
    $('.close-notes').on('click', function () {
        parentElement = this.parentNode;
        parentElement = parentElement.parentNode;
        $(parentElement).fadeOut();
    });
    
    $('.notes-wrapper').on('submit', function() {
        var data = $(this).serialize();
        var elem = this;
        
        $.ajax({
            url: '/rooms/notes',
            type: 'POST',
            data: data,
            success: function(res){
                if ( res === "success" ) {
                    txtarea = elem.querySelector('textarea');
                    txtarea.style.background = "#e7f7e7";
                    setTimeout(function(){
                        txtarea.style.background = "";
                    }, 2000);
                }
                console.log(elem.querySelector('textarea'));
            },
            error: function(){
                alert('Error!');
            }
        });
        return false;
    });
    
    $('.view-popup').on('click', function() {
        
        $('#view-popup').find('.modal-header').append('<h3>' + $(this).attr('data-title') + '</h3>');
        $('#view-popup').modal('show')
            .find('#full-view')
            .load($(this).attr('value'));
    });

    $('.view-popup-img').on('click', function() {

        $('#view-popup').find('.modal-header').append('<h3>' + $(this).attr('data-title') + '</h3>');
        $('#view-popup').modal('show')
            .find('#full-view')
            .load($(this).attr('value'));
    });
    
    $("#view-popup").on("hidden.bs.modal", function () {
        
        // var headerModal = this.querySelector('div.modal-header');
        var headerModal = $(this).find('.modal-header');

        // var removeElem = headerModal.querySelector('h3');
        // headerModal.removeChild(removeElem);


        var removeElements = headerModal.find('h3');
        removeElements.each(function () {
            $(this).remove();
        });
    });
});


// =======================================================


$('#realty_object_update_form_btn, #realty_object_create_form_btn, #realty_object_create_archive_form_btn').on('click', function () {

    var form = $('#realty_object_form');
    var action = $(this).attr('data-action');

    var sortable_items = form.find('#sortable').find('div.filestyler__item');
    var images = [];

    sortable_items.each(function () {
        images.push($(this).attr('data-image'));
    });

    form.find("#images_order").val(images.join(","));

    form.find('#form_action').val(action);

    if ($(this).attr('id') === 'realty_object_create_archive_form_btn') {
        form.find('#status').val('23');
    }

    form.submit();
});


$('#realty_object_actual_form_btn, #realty_object_favorite_form_btn,' +
    '#realty_object_unavailable_form_btn, #realty_object_archive_form_btn,' +
    '#realty_object_blacklist_form_btn, #realty_object_restore_form_btn').on('click', function () {

    if ($(this).attr('id') === 'realty_object_archive_form_btn') {
        if (!confirm('Вы действительно хотите переместить объект в архив?')) {
            return false;
        }
    }

    if ($(this).attr('id') === 'realty_object_restore_form_btn') {
        if (!confirm('Вы действительно хотите переместить объект в актуальные?')) {
            return false;
        }
    }

    if ($(this).attr('id') === 'realty_object_blacklist_form_btn') {

        var data_action = $(this).attr('data-action');

        if (data_action.slice(-3) === 'add') {

            if (!confirm('Вы действительно хотите добавить объект в черный список?')) {
                return false;
            }
        }
    }

    var form = $('#realty_object_form');
    var action = $(this).attr('data-action');

    form.find('#form_action').val(action);
    form.submit();
});


$('.object-delete-btn').on('click', function () {

    if (confirm('Вы действительно хотите удалить этот объект?')) {

        var object_id = $(this).attr('data-obj_id');

        showLoader();

        $.ajax({
            url: '/rooms/hide',
            type: 'post',
            data: {
                object_id: object_id
            },
            success: function(data) {

                var result = $.parseJSON(data);

                if (result.status === 'success') {

                    location.reload();
                }
            },
            error: function(data){
                console.log(data.responseText);
            },
            complete: function(){
                hideLoader();
            }
        });
    }
});


$('#room_object_nocall_btn').on('click', function () {

    var object_id = $(this).attr('data-room_object_id');

    showLoader();

    $.ajax({
        url: '/realty-object/room-object-nocall',
        type: 'post',
        data: {
            object_id: object_id
        },
        success: function(data) {

            var result = $.parseJSON(data);

            if (result.status === 'success') {

                goBack();
            }
        },
        error: function(data){
            console.log(data.responseText);
        },
        complete: function(){
            hideLoader();
        }
    });
});


$('#room_object_blacklist_btn').on('click', function () {

    if (confirm('Вы действительно хотите занести этот объект в черный список?')) {

        var object_phone = $(this).attr('data-room_object_phone');

        showLoader();

        $.ajax({
            url: '/realty-object/room-object-blacklist',
            type: 'post',
            data: {
                object_phone: object_phone
            },
            success: function(data) {

                var result = $.parseJSON(data);

                if (result.status === 'success') {

                    history.back();
                }
            },
            error: function(data){
                console.log(data.responseText);
            },
            complete: function(){
                hideLoader();
            }
        });
    }
});


$('#realty_object_form').on('beforeSubmit', function (e) {

    e.preventDefault();
    var formData = new FormData(this);
    formData.append('flash', 'true');

    var action = $(this).find('#form_action').val();
    var copy_id = $(this).find('#copy_id').val();

    showLoader();

    $.ajax({
        url: action,
        type: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,

        success: function(data) {
            console.log(data);

            if (data.status === 'success') {

                if (copy_id) {
                    goBack();
                } else {
                    location.replace('/realty-object/view?id=' + data.object_id);
                }
            } else {

                console.log(data.responseText);

            }
        },
        error: function(data){
            console.log(data.responseText);
        },
        complete: function(){
            hideLoader();
        }
    });
}).on('submit', function(e) {
    e.preventDefault();
});


$('#street_address').on('input', function (event) {

    // var index = $(this).attr('data-idx');

    var house_address = $('#house_address');
    var stg_house_address = house_address.suggestions();

    house_address.attr('disabled', null);

    stg_house_address.clear();
    stg_house_address.setOptions({
        hint: false,
        constraints: {
            label: false,
            locations: {
                city: $('#location_city_selector').find(":selected").text(),
                street: $(this).val()
            }
        },
        restrict_value: true
    });
});


$('#house_address').on('input', function (event) {

    // var index = $(this).attr('data-idx');

    var apartment = $('#apartment');

    if ($(this).val().length > 0) {
        apartment.attr('disabled', null);
    }
});


$('#category_list').on('change', function () {

    var category = $(this).val();
    var property_type_selector = $('#property_type_list');
    var apartment_number = $('#apartment_number');
    var class_building = $('#class_building');
    var type_building = $('#type_building');
    var living_area = $('#living_area');
    var kitchen_area = $('#kitchen_area');

    if (category === '1') {  // жилая
        apartment_number.css('display', 'inherit');
        class_building.css('display', 'inherit');
        type_building.css('display', 'inherit');
        living_area.css('display', 'inherit');
        kitchen_area.css('display', 'inherit');
    } else {
        apartment_number.css('display', 'none');
        class_building.css('display', 'none');
        type_building.css('display', 'none');
        living_area.css('display', 'none');
        kitchen_area.css('display', 'none');
    }

    property_type_selector.attr('disabled', 'disabled').html('<option>загрзка...</option>');

    $.get('/realty-object/category-selector-change', { category: category }, function(data) {

        property_type_selector.html(data.types);
        if (data.disabled === 0) {
            property_type_selector.attr('disabled', null);
        }

    }, 'json');
});


$('#location_region_selector').on('change', function () {

    // var index = $(this).attr('data-idx');

    var region = $(this).val();
    var city_selector = $('#location_city_selector');

    var district_selector = $('#location_district_selector');
    var district = $('#district_selector');
    var metro_selector = $('#location_metro_selector');
    var metro = $('#metro_selector');

    var street_address = $('#street_address');
    var house_address = $('#house_address');
    // var apartment = $('#apartment');

    var stg_street_address = street_address.suggestions();
    var stg_house_address = house_address.suggestions();

    district_selector.attr('disabled', 'disabled').html('<option value="">---</option>');
    district.css('display', 'none');
    metro_selector.attr('disabled', 'disabled').html('');
    metro.css('display', 'none');

    // street_address.attr('disabled', 'disabled');
    // house_address.attr('disabled', 'disabled');
    // apartment.val('').attr('disabled', 'disabled');

    // stg_street_address.clear();

    if (stg_street_address) {

        stg_street_address.setOptions({
            constraints: {
                locations: {
                    city: null
                }
            }
        });
    }


    // stg_house_address.clear();

    if (stg_house_address) {

        stg_house_address.setOptions({
            constraints: {
                locations: {
                    city: null,
                    street: null
                }
            }
        });
    }


    if (region !== '') {

        city_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');
        district_selector.attr('disabled', 'disabled').html('<option value="">---</option>');

        $.get('/location/region-selector-change', { region: region }, function(data) {

            city_selector.html(data.cities);
            if (data.disabled === 0) {
                city_selector.attr('disabled', null);
            }

        }, 'json');
    } else {
        city_selector.attr('disabled', 'disabled').html('<option value="">---</option>');
    }
});


$('#location_city_selector').on('change', function () {

    // var index = $(this).attr('data-idx');

    var city = $(this).val();
    var city_name = $(this).find(":selected").text();

    var district_selector = $('#location_district_selector');
    var district = $('#district_selector');
    var metro_selector = $('#location_metro_selector');
    var metro = $('#metro_selector');

    var street_address = $('#street_address');
    var house_address = $('#house_address');
    // var apartment = $("#apartment");

    var stg_street_address = street_address.suggestions();
    var stg_house_address = house_address.suggestions();

    // stg_house_address.clear();

    if (stg_house_address) {

        stg_house_address.setOptions({
            constraints: {
                locations: {
                    city: null,
                    street: null
                }
            }
        });
    }


    // house_address.attr('disabled', 'disabled');
    // apartment.val('').attr('disabled', 'disabled');

    if (city !== '') {

        district_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');

        street_address.attr('disabled', null);

        // stg_street_address.clear();

        if (stg_street_address) {

            stg_street_address.setOptions({
                constraints: {
                    label: false,
                    locations: {
                        city: city_name
                    }
                },
                restrict_value: true
            });
        }


        $.get('/location/city-selector-change', { city: city }, function(data) {

            district_selector.html(data.districts);
            metro_selector.html(data.metro);

            if (data.district_disabled === 0) {
                district_selector.attr('disabled', null);
                district.css('display', 'inherit');
            } else {
                district_selector.attr('disabled', 'disabled').html('<option value="">---</option>');
                district.css('display', 'none');
            }

            if (data.metro_disabled === 0) {
                metro_selector.attr('disabled', null);
                metro.css('display', 'inherit');

                metro_selector.multiselect('reload');

            } else {
                metro_selector.attr('disabled', 'disabled').html('');
                metro.css('display', 'none');
            }

        }, 'json');

    } else {

        district_selector.attr('disabled', 'disabled').html('<option value="">---</option>');
        district.css('display', 'none');
        metro_selector.attr('disabled', 'disabled').html('');
        metro.css('display', 'none');

        // street_address.attr('disabled', 'disabled');

        // stg_street_address.clear();

        if (stg_street_address) {

            stg_street_address.setOptions({
                constraints: {
                    locations: {
                        city: null
                    }
                }
            });
        }
    }
});


$('[id ^= search_region_selector_]').on('change', function () {

    var index = $(this).attr('data-idx');

    var region = $(this).val();
    var city_selector = $('#search_city_selector_' + index);

    var district_selector = $('#search_district_selector_' + index);
    var district = $('#district_selector_' + index);
    var metro_selector = $('#search_metro_selector_' + index);
    var metro = $('#metro_selector_' + index);

    district_selector.attr('disabled', 'disabled').html('');
    district.css('display', 'none');

    metro_selector.attr('disabled', 'disabled').html('');
    metro.css('display', 'none');

    if (region !== '') {

        city_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');
        district_selector.attr('disabled', 'disabled').html('');

        $.get('/location/region-selector-change', { region: region }, function(data) {

            city_selector.html(data.cities);
            if (data.disabled === 0) {
                city_selector.attr('disabled', null);
            }

        }, 'json');
    } else {
        city_selector.attr('disabled', 'disabled').html('<option value="">---</option>');
    }
});


$('[id ^= search_city_selector_]').on('change', function () {

    var index = $(this).attr('data-idx');

    var city = $(this).val();

    var district_selector = $('#search_district_selector_' + index);
    var district = $('#district_selector_' + index);

    var metro_selector = $('#search_metro_selector_' + index);
    var metro = $('#metro_selector_' + index);

    if (city !== '') {

        district_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');

        $.get('/location/city-selector-change', { city: city }, function(data) {

            district_selector.html(data.districts);
            metro_selector.html(data.metro);


            if (data.district_disabled === 0) {
                district_selector.attr('disabled', null);
                district.css('display', 'inherit');

                district_selector.multiselect('reload');
            } else {
                district_selector.attr('disabled', 'disabled').html('');
                district.css('display', 'none');
            }

            if (data.metro_disabled === 0) {
                metro_selector.attr('disabled', null);
                metro.css('display', 'inherit');

                metro_selector.multiselect('reload');

            } else {
                metro_selector.attr('disabled', 'disabled').html('');
                metro.css('display', 'none');
            }
        }, 'json');

    } else {

        district_selector.attr('disabled', 'disabled').html('');
        district.css('display', 'none');
        metro_selector.attr('disabled', 'disabled').html('');
        metro.css('display', 'none');
    }
});


$('#type_list').on('change', function () {

    var type = $(this).val();
    var pledge = $('#pledge');
    var rent = $('#rent');

    if (type === '3') {  // сдам
        pledge.css('display', 'inherit');
        rent.css('display', 'inherit');
    } else {
        pledge.css('display', 'none');
        rent.css('display', 'none');
    }
});


$('#telegram_checkbox').on('change', function () {

    var checked = ($(this).prop('checked') === true);
    var telegram_input = $('#telegram_input');
    telegram_input.attr('disabled', !checked);
});


$('#whatsapp_checkbox').on('change', function () {

    var checked = ($(this).prop('checked') === true);
    var whatsapp_input = $('#whatsapp_input');
    whatsapp_input.attr('disabled', !checked);
});


$('#viber_checkbox').on('change', function () {

    var checked = ($(this).prop('checked') === true);
    var viber_input = $('#viber_input');
    viber_input.attr('disabled', !checked);
});


$('#vk_checkbox').on('change', function () {

    var checked = ($(this).prop('checked') === true);
    var vk_input = $('#vk_input');
    vk_input.attr('disabled', !checked);
});


$('#call_back_checkbox').on('change', function () {

    var checked = ($(this).prop('checked') === true);
    var call_back_date = $('#call_back_date');
    call_back_date.attr('disabled', !checked);
});


$('#release_date_checkbox').on('change', function () {

    var checked = ($(this).prop('checked') === true);
    var release_date = $('#release_date');
    release_date.attr('disabled', !checked);
});

$('#contragent_phone').on('input', function () {
    $('#dublication_search_phone').val($(this).val());
});


$('#dublication_search_btn').on('click', function () {

    var phone = $('#dublication_search_phone').val();
    var obj_id = $(this).attr('data-obj_id');
    var copy_id = $(this).attr('data-copy_id');
    var dublication = $('#dublication_info');
    var dublication_heading = $('#dublication_info_heading');

    var re = /^\+7 \(\d{3}\) \d{3} \d{2} \d{2}$/;
    if (!re.test(phone)) {
        alert('Телефон указан неверно.');
        return false;
    }

    $('#dublications').collapse('hide');
    dublication_heading.text('Поиск...');

    showLoader();

    $.ajax({
        url: '/realty-object/dublication-search',
        type: 'post',
        data: {
            phone: phone,
            obj_id: obj_id,
            copy_id: copy_id
        },
        success: function(data) {

            var result = $.parseJSON(data);

            if (result.status === 'success') {

                dublication.html(result.dublication_block);

                $('.view-popup-img').on('click', function () {

                    var target = $(this);
                    var view_popup = $('#view-popup');

                    view_popup.find('.modal-header').append('<h3>' + target.attr('data-title') + '</h3>');
                    view_popup.modal('show')
                        .find('#full-view')
                        .load(target.attr('value'));
                });
            }
        },
        error: function(data){
            console.log(data.responseText);
        },
        complete: function(){
            hideLoader();
        }
    });
});


$('[id ^= info_tab_pjax_]').on(/*'pjax:end'*/ 'pjax:success', function() {

    var index = $(this).attr('data-idx');

    // var search_container = $(this).find('.collapse');
    // search_container.addClass('in');

    var datetimepicker_6ca80f2e = {
        bootcssVer: 3,
        icontype: 'glyphicon',
        fontAwesome: false,
        icons: {
            leftArrow: 'glyphicon-arrow-left',
            rightArrow: 'glyphicon-arrow-right'
        },
        autoclose: true,
        todayHighlight: true,
        format: 'dd.mm.yyyy HH:ii',
        timezone: 'Europe\/Moscow',
        language: 'ru'
    };


    $('#date_from_' + index).datetimepicker(datetimepicker_6ca80f2e);
    $('#date_to_' + index).datetimepicker(datetimepicker_6ca80f2e);
    $('#release_date_from_' + index).datetimepicker(datetimepicker_6ca80f2e);
    $('#release_date_to_' + index).datetimepicker(datetimepicker_6ca80f2e);


    var district_selector = $('#search_district_selector_' + index);
    var metro_selector = $('#search_metro_selector_' + index);
    var property_type_selector = $('#search_property_selector_' + index);


    district_selector.multiselect({
        texts: {
            placeholder: '---',
            search: '',
            selectedOptions: ' выбрано'
        },
        search: true
    });

    metro_selector.multiselect({
        texts: {
            placeholder: '---',
            search: '',
            selectedOptions: ' выбрано'
        },
        search: true
    });

    property_type_selector.multiselect({
        texts: {
            placeholder: '---',
            search: '',
            selectedOptions: ' выбрано'
        },
        search: true
    });


    $('[id ^= search_region_selector_]').on('change', function () {

        var index = $(this).attr('data-idx');

        var region = $(this).val();
        var city_selector = $('#search_city_selector_' + index);

        var district_selector = $('#search_district_selector_' + index);
        var district = $('#district_selector_' + index);
        var metro_selector = $('#search_metro_selector_' + index);
        var metro = $('#metro_selector_' + index);

        district_selector.attr('disabled', 'disabled').html('');
        district.css('display', 'none');

        metro_selector.attr('disabled', 'disabled').html('');
        metro.css('display', 'none');
        // metro_selector.multiselect('reload');


        if (region !== '') {

            city_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');
            district_selector.attr('disabled', 'disabled').html('');

            $.get('/location/region-selector-change', { region: region }, function(data) {

                city_selector.html(data.cities);
                if (data.disabled === 0) {
                    city_selector.attr('disabled', null);
                }

            }, 'json');
        } else {
            city_selector.attr('disabled', 'disabled').html('<option value="">---</option>');
        }
    });


    $('[id ^= search_city_selector_]').on('change', function () {

        var index = $(this).attr('data-idx');

        var city = $(this).val();

        var district_selector = $('#search_district_selector_' + index);
        var district = $('#district_selector_' + index);

        var metro_selector = $('#search_metro_selector_' + index);
        var metro = $('#metro_selector_' + index);

        if (city !== '') {

            district_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');

            $.get('/location/city-selector-change', { city: city }, function(data) {

                district_selector.html(data.districts);
                metro_selector.html(data.metro);

                if (data.district_disabled === 0) {
                    district_selector.attr('disabled', null);
                    district.css('display', 'inherit');

                    district_selector.multiselect('reload');
                } else {
                    district_selector.attr('disabled', 'disabled').html('');
                    district.css('display', 'none');
                }

                if (data.metro_disabled === 0) {
                    metro_selector.attr('disabled', null);
                    metro.css('display', 'inherit');

                    metro_selector.multiselect('reload');

                } else {
                    metro_selector.attr('disabled', 'disabled').html('');
                    metro.css('display', 'none');
                }

                // metro_selector.multiselect('reload');

            }, 'json');

        } else {

            district_selector.attr('disabled', 'disabled').html('');
            district.css('display', 'none');
            metro_selector.attr('disabled', 'disabled').html('');
            metro.css('display', 'none');

            // metro_selector.multiselect('reload');

        }
    });

    $('.view-popup').on('click', function() {

        var view_popup = $('#view-popup');

        view_popup.find('.modal-header').append('<h3>' + $(this).attr('data-title') + '</h3>');
        view_popup.modal('show').find('#full-view').load($(this).attr('value'));
    });

    $("#view-popup").on("hidden.bs.modal", function () {

        var headerModal = $(this).find('.modal-header');
        var removeElements = headerModal.find('h3');

        removeElements.each(function () {
            $(this).remove();
        });
    });


    $("select[id ^= search_][multiple != multiple]").select2({
        width: '100%',
        minimumResultsForSearch: 2
    });
});


function showPhone(key) {

    var button = $('#user_phone_btn_' + key);
    var phone = $('#user_phone_' + key);
    
    var rows = button.closest('tbody').find('tr');
    
    rows.each(function () {
        var key = $(this).attr('data-key');
        $('#user_phone_btn_' + key).css('display', 'block');
        $('#user_phone_' + key).css('display', 'none');
    });

    button.css('display', 'none');
    phone.css('display', 'block');
}




$('#dublication_info').on('click', function () {
    $('#dublications').collapse('toggle');
});



$('.filestyler').on('filestylerProcessItem', function (e) {

    var item = e.item;
    var file = e.file;
    var number = $(item).find('.filestyler__sort-helper').val();
    // $(item).attr('data-image', number);
    $(item).attr('data-image', file.name);
});


$('.filestyler__crop').on('click', function () {

    var modal = $('#crop_image_modal');
    var image = $(this).parent().find('div.filestyler__figure').find('img').attr('src');

    modal.find('#image_src').val(image);
    modal.modal('show');
});


$('#crop_image_modal').on('shown.bs.modal', function () {

    var modal = $(this);
    var image = modal.find('#image_src').val();
    var object_id = modal.find('#crop_object_id').val();

    var cropper_container = '<div class="cropper-container"><img style="max-width: 100%" src="data:image/gif" class="cropper-image" id="cropper_image"></div>';
    var cropper_footer = '<button type="button" id="crop_image_modal_btn" class="btn btn-primary">Сохранить</button>';
    modal.find('.cropper-container').replaceWith(cropper_container);
    modal.find('.cropper-footer').replaceWith(cropper_footer);

    var h = modal.find('.modal-header').innerHeight();
    h += modal.find('.modal-footer').innerHeight();
    modal.find('.cropper-container').prop('style', 'height:' + ($(window).innerHeight() - h * 2) + 'px');

    modal.find('#cropper_image').attr('src', image);

    var cropper = new Cropper(cropper_image, {
        autoCrop: false,
        viewMode: 2,
        background: false,
        guides: false,
        scalable: false,
        zoomable: false,
        preview: '#preview1'

        // crop: function(e) {
        //     console.log(e.detail.x);
        //     console.log(e.detail.y);
        // }
    });

    $('#crop_image_modal_btn').on('click', function () {

        var image_file_name = modal.find('#cropper_image').attr('src');

        cropper.getCroppedCanvas().toBlob(function (blob) {

            var formData = new FormData();
            formData.append('croppedImage', blob);
            formData.append('imageFileName', image_file_name);
            formData.append('object_id', object_id);

            showLoader();

            $.ajax('/realty-object/crop-image', {
                method: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    console.log('Upload success');
                    document.location.reload(true);
                },
                error: function () {
                    console.log('Upload error');
                },
                complete: function(){
                    hideLoader();
                }
            });
        }/*, mimeType*/);

        $('#crop_image_modal').modal('hide');
    });
}).on('hidden.bs.modal', function () {
    $(this).find('.cropper-preview').css('height', '240px').css('width', 'auto');
    $(this).find('.cropper-container').hide();
    $(this).find('.cropper-footer').hide();
});


function showLoader() {
    $('#loader, #fade').fadeIn('fast');
}

function hideLoader() {
    $('#loader, #fade').fadeOut('fast');
}

function goBack() {
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    history.back();
}


function deleteObjects(grid_id) {

    var grid = $('#' + grid_id);
    var checkbox_arr = grid.find('input[type = checkbox][name != selection_all]');

    var delete_objects = [];

    checkbox_arr.each(function () {
        if ($(this).prop('checked')) {
            delete_objects.push($(this).val());
        }
    });

    if (delete_objects.length > 0) {


        var modal = $('#object_delete_modal');

        modal.find('#object_id').val(delete_objects.join(','));
        modal.modal('show');
    }
}


function archiveObjects(grid_id) {

    var grid = $('#' + grid_id);
    var checkbox_arr = grid.find('input[type = checkbox][name != selection_all]');

    var archive_objects = [];

    checkbox_arr.each(function () {
        if ($(this).prop('checked')) {
            archive_objects.push($(this).val());
        }
    });

    if (archive_objects.length > 0) {

        if (confirm('Переместить выбранные объекты в архив?')) {

            var dest_tab = '';

            switch (grid_id) {

                case 'rent_residental_objects_grid' :
                    dest_tab = $('#rent_residental_archive_info_tab').find('table tbody');
                    break;
                case 'sell_residental_objects_grid' :
                    dest_tab = $('#sell_residental_archive_info_tab').find('table tbody');
                    break;
                case 'rent_commercial_objects_grid' :
                    dest_tab = $('#rent_commercial_archive_info_tab').find('table tbody');
                    break;
                case 'sell_commercial_objects_grid' :
                    dest_tab = $('#sell_commercial_archive_info_tab').find('table tbody');
                    break;
            }

            showLoader();

            $.ajax({
                url: '/realty-object/archive-objects',
                type: 'post',
                dataType: 'json',
                data: {
                    objects: archive_objects
                },
                success: function(data) {

                    if (data.status === 'success') {

                        grid.find('input[type = checkbox][name = selection_all]').prop('checked', false);

                        archive_objects.forEach(function (value) {

                            var object_row = $('tr[data-key = ' + value + ']');
                            var button = object_row.find('a.archive-btn');

                            object_row.removeClass('danger');
                            object_row.find('input[type = checkbox]').prop('checked', false);

                            button.removeClass('archive-btn').addClass('restore-btn');
                            button.attr('href', 'javascript:objectRestore("' + value + '")');
                            button.find('span').text('В актуальные');
                            button.attr('title', 'В актуальные');


                            var dest_tab_row = dest_tab.find('tr:first');

                            if (dest_tab_row.attr('data-key') === undefined) {
                                dest_tab_row.remove();
                            }

                            dest_tab.prepend(object_row);

                        });

                        showMessage('success', 'Выбранные объекты перемещены в архив');
                    }
                    if (data.status === 'error') {
                        showMessage('error', 'Не удалось переместить объекты в архив, повторите попытку позже');
                    }
                },
                error: function(data){
                    console.log(data.responseText);
                },
                complete: function(){
                    hideLoader();
                }
            });
        }
    }
}


function restoreObjects(grid_id) {

    var hash = location.hash;
    var dest_tab_name = '';

    switch (hash) {

        case '#deleted_info_tab' :
        case '#deleted_residental_info_tab' :
        case '#rent_residental_archive_info_tab' :
        case '#sell_residental_archive_info_tab' :
            dest_tab_name = '_residental_info_tab';
            break;
        case '#deleted_commercial_info_tab' :
        case '#rent_commercial_archive_info_tab' :
        case '#sell_commercial_archive_info_tab' :
            dest_tab_name = '_commercial_info_tab';
            break;
    }

    var grid = $('#' + grid_id);
    var checkbox_arr = grid.find('input[type = checkbox][name != selection_all]');

    var restore_objects = [];

    checkbox_arr.each(function () {
        if ($(this).prop('checked')) {
            restore_objects.push($(this).val());
        }
    });

    if (restore_objects.length > 0) {

        if (confirm('Переместить выбранные объекты в актуальные?')) {

            showLoader();

            $.ajax({
                url: '/realty-object/restore-objects',
                type: 'post',
                dataType: 'json',
                data: {
                    objects: restore_objects
                },
                success: function(data) {

                    if (data.status === 'success') {

                        grid.find('input[type = checkbox][name = selection_all]').prop('checked', false);

                        var object_row = {};
                        var dest_tab = {};
                        var dest_tab_row = {};
                        var type = '';

                        restore_objects.forEach(function (value) {

                            object_row = $('tr[data-key = ' + value + ']');
                            var button = object_row.find('a.restore-btn');

                            object_row.removeClass('danger');
                            object_row.find('input[type = checkbox]').prop('checked', false);

                            button.removeClass('restore-btn').addClass('archive-btn');
                            button.attr('href', 'javascript:objectArchive("' + value + '")');
                            button.find('span').text('В архив');
                            button.attr('title', 'В архив');

                            type = object_row.find('#type_' + value).attr('data-type');

                            dest_tab = $('#' + type + dest_tab_name).find('table tbody');

                            dest_tab_row = dest_tab.find('tr:first');

                            if (dest_tab_row.attr('data-key') === undefined) {
                                dest_tab_row.remove();
                            }

                            dest_tab.prepend(object_row);
                        });

                        showMessage('success', 'Выбранные объекты перемещены в актуальные.');

                        // location.reload();
                    }
                    if (data.status === 'error') {
                        showMessage('error', 'Не удалось восстановить объекты, повторите попытку позже');
                    }
                },
                error: function(data){
                    console.log(data.responseText);
                },
                complete: function(){
                    hideLoader();
                }
            });
        }
    }
}


function favoriteObjects(grid_id) {

    var grid = $('#' + grid_id);
    var checkbox_arr = grid.find('input[type = checkbox][name != selection_all]');

    var favorite_objects = [];

    checkbox_arr.each(function () {
        if ($(this).prop('checked')) {
            favorite_objects.push($(this).val());
        }
    });

    if (favorite_objects.length > 0) {

        showLoader();

        $.ajax({
            url: '/realty-object/favorite-objects',
            type: 'post',
            dataType: 'json',
            data: {
                objects: favorite_objects
            },
            success: function(data) {

                if (data.status === 'success') {

                    favorite_objects.forEach(function (value) {

                        var object_row = $('tr[data-key = ' + value + ']');
                        var button = object_row.find('a.favorite-btn');

                        object_row.addClass('favorites-row');
                        button.attr('href', 'javascript:objectFavorite("' + value + '", "delete")');
                        button.attr('title', 'Удалить из избранного');
                    });


                    showMessage('success', 'Выбранные объекты добавлены в избранное');
                }
                if (data.status === 'error') {
                    showMessage('error', 'Не удалось добавить объекты в избранное, повторите попытку позже');
                }
            },
            error: function(data){
                console.log(data.responseText);
            },
            complete: function(){
                hideLoader();
            }
        });
    }
}


function objectActual(object_id) {

    var date_cell = $('td:contains(#' + object_id + ')').parents('tr').find('td:eq(3)');      //$('#actual_date_' + object_id);
    var unavailable = $('#unavailable_' + object_id);

    showLoader();

    $.ajax({
        url: '/realty-object/actual?id=' + object_id,
        type: 'post',
        dataType: 'json',
        data: {
            object_id: object_id
        },
        success: function(data) {

            // var result = $.parseJSON(data);

            if (data.status === 'success') {
                date_cell.text(data.actual_date);
                unavailable.html('');
                showMessage('success', 'Дата актуальности обновлена');
            }
            if (data.status === 'error') {
                showMessage('error', 'Не удалось обновить дату актуальности, повторите попытку позже');
            }
        },
        error: function(data){
            console.log(data.responseText);
        },
        complete: function(){
            hideLoader();
        }
    });
}


function objectUnavailable(object_id) {

    var unavailable = $('#unavailable_' + object_id);

    showLoader();

    $.ajax({
        url: '/realty-object/unavailable?id=' + object_id,
        type: 'post',
        dataType: 'json',
        data: {
            object_id: object_id
        },
        success: function(data) {

            // var result = $.parseJSON(data);

            if (data.status === 'success') {
                unavailable.html('<div class="badge" style="margin-left: 0">НД</div>');
                showMessage('success', 'Метка установлена');
            }
            if (data.status === 'error') {
                showMessage('error', 'Не удалось установить метку, повторите попытку позже');
            }
        },
        error: function(data){
            console.log(data.responseText);
        },
        complete: function(){
            hideLoader();
        }
    });
}


function objectArchive(object_id) {

    var hash = location.hash;

    if (hash.indexOf('archive') + 1) {
        alert('Объект уже в архиве.');
        return false;
    }

    if (confirm('Вы действительно хотите переместить объект в архив?')) {

        var object_row = $('tr[data-key = ' + object_id + ']');
        var button = object_row.find('a.archive-btn');
        var dest_tab = {};

        switch (hash) {

            case '' :
            case '#rent_info_tab' :
            case '#rent_residental_info_tab' :
                dest_tab = $('#rent_residental_archive_info_tab').find('table tbody');
                break;
            case '#sell_info_tab' :
            case '#sell_residental_info_tab' :
                dest_tab = $('#sell_residental_archive_info_tab').find('table tbody');
                break;
            case '#rent_commercial_info_tab' :
                dest_tab = $('#rent_commercial_archive_info_tab').find('table tbody');
                break;
            case '#sell_commercial_info_tab' :
                dest_tab = $('#sell_commercial_archive_info_tab').find('table tbody');
                break;
        }

        showLoader();

        $.ajax({
            url: '/realty-object/archive?id=' + object_id,
            type: 'post',
            dataType: 'json',
            data: {
                object_id: object_id
            },
            success: function(data) {

                if (data.status === 'success') {

                    object_row.removeClass('danger');
                    object_row.find('input[type = checkbox]').prop('checked', false);

                    button.removeClass('archive-btn').addClass('restore-btn');
                    button.attr('href', 'javascript:objectRestore("' + object_id + '")');
                    button.find('span').text('В актуальные');
                    button.attr('title', 'В актуальные');

                    var dest_tab_row = dest_tab.find('tr:first');

                    if (dest_tab_row.attr('data-key') === undefined) {
                        dest_tab_row.remove();
                    }

                    dest_tab.prepend(object_row);

                    showMessage('success', 'Объект перемещен в архив');
                }
                if (data.status === 'error') {
                    showMessage('error', 'Ошибка при перемещении объекта, повторите попытку позже');
                }
            },
            error: function(data){
                console.log(data.responseText);
            },
            complete: function(){
                hideLoader();
            }
        });
    }
}


function objectRestore(object_id) {

    var hash = location.hash;
    var dest_tab_name = '';

    switch (hash) {

        case '#deleted_info_tab' :
        case '#deleted_residental_info_tab' :
        case '#rent_residental_archive_info_tab' :
        case '#sell_residental_archive_info_tab' :
            dest_tab_name = '_residental_info_tab';
            break;
        case '#deleted_commercial_info_tab' :
        case '#rent_commercial_archive_info_tab' :
        case '#sell_commercial_archive_info_tab' :
            dest_tab_name = '_commercial_info_tab';
            break;
    }

    if (confirm('Вы действительно хотите переместить объект в актуальные?')) {

        var restore_objects = [object_id];

        showLoader();

        $.ajax({
            url: '/realty-object/restore-objects',
            type: 'post',
            dataType: 'json',
            data: {
                objects: restore_objects
            },
            success: function(data) {

                if (data.status === 'success') {

                    var object_row = $('tr[data-key = ' + object_id + ']');
                    var type = object_row.find('#type_' + object_id).attr('data-type');
                    var button = object_row.find('a.restore-btn');

                    object_row.removeClass('danger');
                    object_row.find('input[type = checkbox]').prop('checked', false);

                    button.removeClass('restore-btn').addClass('archive-btn');
                    button.attr('href', 'javascript:objectArchive("' + object_id + '")');
                    button.find('span').text('В архив');
                    button.attr('title', 'В архив');


                    var dest_tab = $('#' + type + dest_tab_name).find('table tbody');

                    var dest_tab_row = dest_tab.find('tr:first');

                    if (dest_tab_row.attr('data-key') === undefined) {
                        dest_tab_row.remove();
                    }

                    dest_tab.prepend(object_row);


                    showMessage('success', 'Объект перемещен в актуальные');
                }
                if (data.status === 'error') {
                    showMessage('error', 'Ошибка при восстановлении объекта, повторите попытку позже');
                }
            },
            error: function(data){
                console.log(data.responseText);
            },
            complete: function(){
                hideLoader();
            }
        });
    }
}


function objectDelete(object_id) {

    var hash = location.hash;

    if (hash.indexOf('deleted') + 1) {
        alert('Объект уже удален.');
        return false;
    }

    var modal = $('#object_delete_modal');

    modal.find('#object_id').val(object_id);
    modal.modal('show');
}


$('#object_delete_modal').on('shown.bs.modal', function(e) {

    var reason_text = $(this).find('#reason_text');
    reason_text.val('').focus();
});


$('#object_delete_modal_btn').on('click', function () {
    $('#object_delete_modal').modal('hide');
    $('#object_delete_form').submit();
});



$('#object_delete_form').on('beforeSubmit', function() {

    var hash = location.hash;
    var dest_tab = {};
    var grid = {};

    var deleted_residental_info_tab = $('#deleted_residental_info_tab');
    var deleted_commercial_info_tab = $('#deleted_commercial_info_tab');

    switch (hash) {

        case '' :
        case '#rent_info_tab' :
        case '#rent_residental_info_tab' :
            dest_tab = deleted_residental_info_tab.find('table tbody');
            grid = $('#rent_residental_objects_grid');
            break;
        case '#rent_residental_archive_info_tab' :
            dest_tab = deleted_residental_info_tab.find('table tbody');
            grid = $('#rent_residental_archive_objects_grid');
            break;
        case '#sell_info_tab' :
        case '#sell_residental_info_tab' :
            dest_tab = deleted_residental_info_tab.find('table tbody');
            grid = $('#sell_residental_objects_grid');
            break;
        case '#sell_residental_archive_info_tab' :
            dest_tab = deleted_residental_info_tab.find('table tbody');
            grid = $('#sell_residental_archive_objects_grid');
            break;
        case '#sell_commercial_info_tab' :
            dest_tab = deleted_commercial_info_tab.find('table tbody');
            grid = $('#sell_commercial_objects_grid');
            break;
        case '#sell_commercial_archive_info_tab' :
            dest_tab = deleted_commercial_info_tab.find('table tbody');
            grid = $('#sell_commercial_archive_objects_grid');
            break;
        case '#rent_commercial_info_tab' :
            dest_tab = deleted_commercial_info_tab.find('table tbody');
            grid = $('#rent_commercial_objects_grid');
            break;
        case '#rent_commercial_archive_info_tab' :
            dest_tab = deleted_commercial_info_tab.find('table tbody');
            grid = $('#rent_commercial_archive_objects_grid');
            break;
    }

    var modal = $('#object_delete_modal');
    var reason = modal.find('#reason_text').val();
    var target = modal.find('#target').val();

    var object_id = modal.find('#object_id').val();
    var object_ids = object_id.split(',');

    showLoader();

    $.ajax({
        url: '/realty-object/delete',
        type: 'post',
        dataType: 'json',
        data: {
            object_id: object_id,
            reason: reason,
            flash: target === 'view' ? 'true' : 'false'
        },
        success: function(data) {

            if (data.status === 'success') {

                if (target === 'index') {

                    grid.find('input[type = checkbox][name = selection_all]').prop('checked', false);

                    if (object_ids.length === 1) {

                        var object_row = $('tr[data-key = ' + object_id + ']');

                        object_row.removeClass('danger');
                        object_row.find('input[type = checkbox]').prop('checked', false);

                        object_row.find('td:first').remove();
                        object_row.find('td:last').remove();

                        var dest_tab_row = dest_tab.find('tr:first');

                        if (dest_tab_row.attr('data-key') === undefined) {
                            dest_tab_row.remove();
                        }

                        dest_tab.prepend(object_row);

                        showMessage('success', 'Объект удален');
                    }

                    if (object_ids.length > 1) {

                        object_ids.forEach(function (value) {

                            var object_row = $('tr[data-key = ' + value + ']');

                            object_row.removeClass('danger');
                            object_row.find('input[type = checkbox]').prop('checked', false);

                            object_row.find('td:first').remove();
                            object_row.find('td:last').remove();

                            var dest_tab_row = dest_tab.find('tr:first');

                            if (dest_tab_row.attr('data-key') === undefined) {
                                dest_tab_row.remove();
                            }

                            dest_tab.prepend(object_row);
                        });

                        showMessage('success', 'Выбранные объекты удалены');
                    }
                }

                if (target === 'view') {

                    location.reload();
                }
            }

            if (data.status === 'error') {

                if (target === 'index') {

                    showMessage('error', 'Ошибка при удалении объекта, повторите попытку позже');
                }

                if (target === 'view') {

                    location.reload();
                }
            }
        },
        error: function(data) {
            console.log(data.responseText);
        },
        complete: function() {
            // modal.modal('hide');
            hideLoader();
        }
    });
}).on('submit', function(e) {
    e.preventDefault();
});


function objectBlacklist(object_id, action) {

    if (action === 'add') {
        if (!confirm('Вы действительно хотите добавить объект в черный список?')) {
            return false;
        }
    }

    var object_row = $('tr[data-key = ' + object_id + ']');
    var button = object_row.find('a.blacklist-btn');

    showLoader();

    $.ajax({
        url: '/realty-object/blacklist?id=' + object_id + '&action=' + action,
        type: 'post',
        dataType: 'json',
        data: {
            object_id: object_id,
            action: action
        },
        success: function(data) {

            if (data.status === 'success') {

                if (action === 'add') {

                    object_row.addClass('blacklist-row');
                    button.attr('href', 'javascript:objectBlacklist("' + object_id + '", "delete")');
                    button.attr('title', 'Удалить из черного списка');

                    showMessage('success', 'Объект добавлен в черный список');

                } else {

                    object_row.removeClass('blacklist-row');
                    button.attr('href', 'javascript:objectBlacklist("' + object_id + '", "add")');
                    button.attr('title', 'В черный список');

                    showMessage('success', 'Объект удален из черного списка');

                }
            }
        },
        error: function(data){
            console.log(data.responseText);
        },
        complete: function(){
            hideLoader();
        }
    });
}


function objectViewMap(object_id) {

    alert('Посмотреть на карте');
}


function showMessage(key, text) {

    var message = $('#popup_message');

    if (key === 'success') {
        message.css('background-color', '#e1ffe1');
    }
    if (key === 'error') {
        message.css('background-color', '#ffe1e1');
    }

    message.html(text);
    message.fadeIn();

    setTimeout(function(){
        message.fadeOut();
    }, 3000);
}


function objectFavorite(object_id, action) {

    var object_row = $('tr[data-key = ' + object_id + ']');
    var button = object_row.find('a.favorite-btn');

    showLoader();

    $.ajax({
        url: '/realty-object/favorite?id=' + object_id + '&action=' + action,
        type: 'post',
        dataType: 'json',
        data: {
            object_id: object_id,
            action: action
        },
        success: function(data) {

            if (data.status === 'success') {

                if (action === 'add') {

                    object_row.addClass('favorites-row');
                    button.attr('href', 'javascript:objectFavorite("' + object_id + '", "delete")');
                    button.attr('title', 'Удалить из избранного');

                    showMessage('success', 'Объект добавлен в избранное');

                } else {

                    object_row.removeClass('favorites-row');
                    button.attr('href', 'javascript:objectFavorite("' + object_id + '", "add")');
                    button.attr('title', 'Добавить в избранное');

                    showMessage('success', 'Объект удален из избранного');

                }
            }
        },
        error: function(data){
            console.log(data.responseText);
        },
        complete: function(){
            hideLoader();
        }
    });
}


function resetSearchForm(index) {

    var form = $('#search_form_' + index);

    form.find('input[type=text]').val('');

    form.find('#search_region_selector_' + index).val(null).trigger('change.select2');
    form.find('#search_city_selector_' + index).html('<option value="">---</option>');

    form.find('#search_district_selector_' + index).attr('disabled', 'disabled').html('');
    form.find('#district_selector_' + index).css('display', 'none');

    form.find('#search_metro_selector_' + index).attr('disabled', 'disabled').html('');
    form.find('#metro_selector_' + index).css('display', 'none');

    form.find('#search_property_selector_' + index + ' option:selected').prop("selected", false);
    form.find('#search_property_selector_' + index).multiselect('reload');

    form.find('#search_repair_' + index).val(null).trigger('change.select2');
    form.find('#search_furniture_' + index).val(null).trigger('change.select2');
    form.find('#search_class_building_' + index).val(null).trigger('change.select2');
    form.find('#search_type_building_' + index).val(null).trigger('change.select2');
    form.find('#search_utility_' + index).val(null).trigger('change.select2');
    form.find('#search_trade_' + index).val(null).trigger('change.select2');
    form.find('#search_manager_' + index).val(null).trigger('change.select2');
    form.find('#search_stage_' + index).val(null).trigger('change.select2');
    form.find('#search_source_' + index).val(null).trigger('change.select2');
}


// =======================================================


/**
*   Выделение и запоминание объявлений, отмеченных в избранное
*/
function setFavorites( key, user ) {
    
    var parentRow = document.querySelectorAll('[data-key="' + key + '"]')[0];
    var btn = parentRow.querySelector('[class="favorite-btn"]');
    var mes = document.getElementById('message-resalt-favorites');
    var act = btn.getAttribute('data-act');
    
    if ( user === "" ) {
        alert ("В избранное могут добавлять только зарегистрированные пользователи.");
        return false;
    }
    
    if ( act === "add" || act === "del" ) {
            parentRow.classList.toggle('favorites-row');
    }
    
    $.ajax({
        url: '/rooms/wishlist',
        type: 'POST',
        data: "user=" + user + "&key=" + key + "&act=" + act,
        success: function(res){
            if ( act === "add" ) {
                btn.setAttribute('data-act', 'del');
                btn.setAttribute('title', 'Удалить из избранного');
                mes.innerHTML = "Добавлено в избранное";
                mes.style.background = '#e1ffe1';
                mes.style.display = 'block';
                setTimeout(function(){ 
                    mes.style.display = 'none';
                    mes.innerHTML = "";
                    mes.style.background = '';
                }, 2000);
            } 
            if ( act === "del" ) {
                btn.setAttribute('data-act', 'add');
                btn.setAttribute('title', 'В избранное');
                mes.innerHTML = "Удалено из избранного";
                mes.style.background = '#ffe1e1';
                mes.style.display = 'block';
                setTimeout(function(){ 
                    mes.style.display = 'none';
                    mes.innerHTML = "";
                    mes.style.background = '';
                }, 2000);
            }
            if ( act === "delete" ) {
                var parentBody = parentRow.parentElement;
                parentBody.removeChild(parentRow);
            }
        },
        error: function(){
            alert('При занесении объявления в избранное произошла ошибка, попробуйте позже');
        }
    });
}

/**
*   Показ модального окна с галереей изображений
*   перезагрузка галереи для задания высоты окна и изображений.
*/
function galleryShow( images ) {
    
    var modalBody = document.getElementById('gallery-wrapper');
    var wrapperModalBody = modalBody.querySelector('[class=modal-body]');
    
    var arrImgLink = images.split(',');
    
    arrImgLink.forEach(function( item, i, arrImgLink ) {
        arrImgLink[i] = item.trim();
    });
    
    var bodyElem = document.createElement('div');
    bodyElem.className = 'img-body';
    bodyElem.setAttribute('id', 'img-body');
    wrapperModalBody.appendChild(bodyElem);
    
    for (var i = 0; i < arrImgLink.length; i++ ) {
        var newElem = document.createElement('div');
        newElem.innerHTML = '<img src="' + arrImgLink[i] + '">';
        bodyElem.appendChild(newElem);
    }
    
    var bx;
    bx = $('.img-body').bxSlider({
        pager: false,
    });
    
    $(modalBody).modal('show');
    
    $(modalBody).on('shown.bs.modal', function () {
        bx.reloadSlider(); 
    });
    
    
}

/**
*   Добавление в список избранного, при выборе через чекбоксы 
*/
function wishList( user ) {
    var tableBody = document.getElementById('table-rooms');
    var checkboxList = tableBody.querySelectorAll('input[type=checkbox]');
    var checkedString = '';
    var j = 0;
    for ( var i = 1; i < checkboxList.length; i++ ) {
        if ( checkboxList[i].checked ) {
            if ( j === 0 ) {
                checkedString += checkboxList[i].value;
            } else {
                checkedString += ',' + checkboxList[i].value;
            }
            j++;
        }
    }
    
    $.ajax({
        url: '/rooms/wishlist',
        type: 'POST',
        data: "user=" + user + "&add-list=" + checkedString,
        success: function(res){
            var mes = document.getElementById('message-resalt-favorites');
            if ( res === 'success' ) {
                mes.innerHTML = "Добавлено в избранное";
                mes.style.background = '#e1ffe1';
                mes.style.display = 'block';
                setTimeout(function(){ 
                    mes.style.display = 'none';
                    mes.innerHTML = "";
                    mes.style.background = '';
                }, 2000);
            }
            
            if ( res === 'error' ) {
                mes.innerHTML = "Произошла ошибка. Не запомнено.";
                mes.style.background = '#ffe1e1';
                mes.style.display = 'block';
                setTimeout(function(){ 
                    mes.style.display = 'none';
                    mes.innerHTML = "";
                    mes.style.background = '';
                }, 2000);
            }
        },
        error: function(){
            alert('При добавлении объявления в избранное произошла ошибка, попробуйте позже');
        }
    });
}

/**
*   Добавление в чёрный список
*   Перезагрузка страницы
*/
function setBlacklist(phone, userId, key) {
    
    if ( key ) {
        var parentRow = document.querySelectorAll('[data-key="' + key + '"]')[0];
        parentRow.classList.add('blacklist-row');

        $.ajax({
            url: '/rooms/blacklist',
            type: 'POST',
            data: "userId=" + userId + "&phone=" + phone,
            success: function(res){
                if ( res === 'blacklist' ) {
                    window.location.reload();
                }
                if ( res === 'error' ) {
                    alert('При занесении объявления в "Чёрный список" произошла ошибка, попробуйте позже');
                }
            },
            error: function(){
                alert('При занесении объявления в "Чёрный список" произошла ошибка, попробуйте позже');
            }
        });
    } else {
        
        var tableBody = document.getElementById('table-rooms');
        var checkboxList = tableBody.querySelectorAll('input[type=checkbox]');
        var checkedString = '';
        var j = 0;
        for ( var i = 1; i < checkboxList.length; i++ ) {
            if ( checkboxList[i].checked ) {
                var parentRow = document.querySelector('[data-key="' + checkboxList[i].value + '"]');
                var currentPhoneBody = parentRow.querySelector('[class="phone"]');
                var currentPhone = currentPhoneBody.innerHTML;
                
                if ( j === 0 ) {
                    checkedString += currentPhone;
                } else {
                    checkedString += ',' + currentPhone;
                }
                j++;
            }
        }

        $.ajax({
            url: '/rooms/blacklist',
            type: 'POST',
            data: "userId=" + userId + "&add-list=" + checkedString,
            success: function(res){
                if ( res === 'blacklist' ) {
                    window.location.reload();
                }
            },
            error: function(){
                alert('При занесении объявления в "Чёрный список" произошла ошибка, попробуйте позже');
            }

        });
    }
}

function downloadImages(images) {
    
//    var zip = new JSZip();
//    zip.add("Hello.txt", "Hello World\n");
//    content = zip.generate();
//    location.href="data:application/zip;base64,"+content;

//    console.log(images);
    
    $.ajax({
        url: '/rooms/download-images',
        type: 'POST',
        data: "images=" + images,
        success: function(res){
            console.log(res);
        },
        error: function(){
            alert('error');
        }
    });
}