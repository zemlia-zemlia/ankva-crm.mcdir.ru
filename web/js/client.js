


$('#client_region_selector').on('change', function () {

    // var index = $(this).attr('data-idx');

    var region = $(this).val();
    var city_selector = $('#client_city_selector');

    var district_selector = $('#client-district');





    // stg_house_address.clear();



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



$('#client_city_selector').on('change', function () {



    var city = $(this).val();


    var district_selector = $('#client-district');

    if (city !== '') {

        district_selector.attr('disabled', 'disabled').html('<option>загрузка...</option>');


        $.get('/location/city-selector-change', { city: city }, function(data) {

            district_selector.html(data.districts);
            if (data.district_disabled === 0) {
                district_selector.attr('disabled', null);
            }

        }, 'json');
    } else {
        district_selector.attr('disabled', 'disabled').html('<option value="">---</option>');
    }
});






function addToSms(sms){

    $('.field-usersms-message > textarea').text(sms);

    alert('Объявление добавлено!');

}


$('#deleteObjects').on('click', function () {
    var keys = $ ( '#objects' ). yiiGridView ( 'getSelectedRows' );

keys = JSON.stringify(keys);
    console.log(keys);
    window.location.href = "/client/realty-object/delete-batch?ids="+keys;

});


$('#updateObjects').on('click', function () {
    var keys = $ ( '#objects' ). yiiGridView ( 'getSelectedRows' );

    keys = JSON.stringify(keys);

    window.location.href = "/client/realty-object/change-status?ids="+keys+"&act=1";

});

// $('#updateAll').on('click', function () {
//
//
//     window.location.href = "http://crm.abriss.pro/client/realty-object/change-status-all";
//
// });

$('#updateAll').on('click', function () {
    var keys = $ ( '#objects' ). yiiGridView ( 'getSelectedRows' );

    keys = JSON.stringify(keys);

    window.location.href = "/client/realty-object/change-status?ids="+keys+"&act=0";

});



//var client_district_selector = $('#client_district');
//
//client_district_selector.multiselect({
//    texts: {
//        placeholder: '---',
//        search: '',
//        selectedOptions: ' выбрано'
//    },
//    search: true
//});