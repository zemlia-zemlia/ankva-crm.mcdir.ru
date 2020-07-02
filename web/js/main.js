$(document).ready(function(){

    //    var country = document.getElementById('rooms-countrysearch');
    // if($("body").is("#rooms-districtsearch")) {

        var district = document.getElementById('rooms-districtsearch');
        var districtName = document.getElementById('rooms-districtnamesearch');
        var city = document.getElementById('rooms-citysearch');
        var cityName = document.getElementById('rooms-citynamesearch');
        var category = document.getElementById('rooms-catsearch');
        var typeAction = document.getElementById('rooms-typeads');
        var newFieldsBody = document.getElementById('add-fields');
    // }
    // if($("body").is("#client-region")) {
    //    var district = document.getElementById('client-region');
    //    var districtName = document.getElementById('rooms-districtnamesearch');
    //    var city = document.getElementById('rooms-citysearch');
    //    var cityName = document.getElementById('rooms-citynamesearch');
    //    var category = document.getElementById('rooms-catsearch');
    //    var typeAction = document.getElementById('rooms-typeads');
    //    var newFieldsBody = document.getElementById('add-fields');
    // }



    var arrDistrictName = {};
    var arrCityName = {};

    var arrDistrictOption = district.querySelectorAll('option');

    for ( var i = 1; i < arrDistrictOption.length; i++ ) {
        arrDistrictName[arrDistrictOption[i].value] = arrDistrictOption[i].innerHTML;
    }

    var issetCategory = GetURLParameter('Rooms[catSearch]');
    var issetAction = GetURLParameter('Rooms[typeAds]');

//    console.log(decodeURIComponent(window.location.search.substring(1)));
    if( issetCategory && issetAction ) {
        addFieldsSearch();
    }

    typeAction.onchange = function() {
        if( category.value !== '' && typeAction.value !== '' ) {
           addFieldsSearch();
        } else {
            newFieldsBody.innerHTML = '';
        }
    };

    category.onchange = function() {
        
        if( category.value !== '' && typeAction.value !== '' ) {
           addFieldsSearch();
        } else {
            newFieldsBody.innerHTML = '';
        }
    };

    district.onchange = function() {
        changeDistrict();
    };

    city.onchange = function(){
        if( city.value !== "" ) {

            var arrCityOption = city.querySelectorAll('option');

            for ( var i = 1; i < arrCityOption.length; i++ ) {
                arrCityName[arrCityOption[i].value] = arrCityOption[i].innerHTML;
            }

            cityName.value = arrCityName[city.value];
            
        }
    }
    
    
    function changeDistrict() {
        
        city.innerHTML = "";

        if( district.value !== '' ) {

            districtName.value = arrDistrictName[district.value];

            $.ajax({
                url: '/rooms/district-change',
                type: 'get',
                data: "id=" + district.value,
                success: function(res){
                    addOption(res, city, cityName);
                },
                error: function(){
                    alert('Ошибка!');
                }
            });
        } else {
            var newOption = document.createElement('option');
            newOption.innerHTML = 'Город';
            city.appendChild(newOption);
            city.setAttribute('disabled', 'true');
        }
}


    function addOption(data, city, cityName) {
        var arr = data.split(',');

        var newOption = document.createElement('option');
        newOption.innerHTML = 'Город';
        city.appendChild(newOption);

        for ( var i = 0; i < arr.length - 1; i++ ) {
            var j = arr[i].split(':');
            newOption = document.createElement('option');
            newOption.value = j[0];
            newOption.innerHTML = j[1];
            city.appendChild(newOption);
        }
        city.removeAttribute('disabled');

    };

    function addFieldsSearch() {

        var numberCategory = category.value;
        var numberTypeAction = typeAction.value;
        var addFields = '';
        
        if (location.search) {
            var getParams = location.search;
            var tmp = (getParams.substr(1)).split('&');
            var arrGetParams = [];

            tmp.forEach(function(item, i, tmp) {
                var j = item.split('=');
                j[0] = j[0].slice(8, -3);
                j[1] = decodeURI(j[1]);
                j[1] = j[1].replace(/\+/g, " ");
                j[1] = j[1].replace(/%2C/g, ",");
                arrGetParams[j[0]] = j[1];
            });
        }

        //количество комнат в квартире
        var arrNumberRooms = [ 'Студия', '1', '2', '3', '4', '5', '6', '7', '8', '9' ];
        //тип дома
        var arrHouseType = [ 'Вторичка', 'Новостройка' ];
        //площадь квартир
        var arrAreaFlat = [ '10', '15', '20', '30', '40', '50', '60', '70', '80', '90', '100', '110', '120', '130', '140', '160', '170', '180', '190', '200', '200+' ];
        //тип дома
        var arrHouseType2 = [ 'Кирпичный', 'Панельный', 'Блочный', 'Монолитный', 'Деревянный'];
        //количество этажей в доме (многоэтажном)
        var arrFloor = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31+' ];
        //срок аренды
        var arrLeaseTerm = [ 'На длительный срок', 'Посуточно' ];
        //площадь комнаты
        var arrAreaRoom = [ '8', '10', '12', '14', '16', '18', '20', '30', '40', '50', '50+' ];
        //тип дома, дачи, коттеджа
        var arrСottageType = [ 'Дом', 'Дача', 'Коттедж', 'Таунхаус' ];
        //Площадь дома
        var arrHomeArea = [ '50', '75', '100', '150', '200', '250', '300', '350', '400', '450', '500', '500+' ];
        //Расстояние до города
        var arrDistanceCity = [ 'В черте города', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100', '100+' ];
        //количество этажей в частном доме
        var arrFloorsHouse = [ '1', '2', '3', '4', '5', '5+' ];
        //площадь участка
        var arrLandArea = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '15', '20', '25', '30', '35', '40', '45', '50', '60', '70', '80', '90', '100', '100+' ];
        //площадь земельного участка
        var arrLandArea2 = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '15', '20', '25', '30', '35', '40', '45', '50', '60', '70', '80', '90', '100', '100', '200', '300', '400', '500', '600', '700', '800', '900', '1000', '1000+' ];
        //Категория земель
        var arrLandCategory = [ 'Поселений (ИЖС)', 'Сельхозназначения (СНТ, ДНП)', 'Промназначения' ];
        //вид коммерческого помещения
        var arrCommercialType = [ 'Гостиница', 'Офисное помещение', 'Помещение свободного назначения', 'Производственное помещение', 'Складское помещение', 'Торговое помещение'];
        //площадь коммерческого помещения
        var arrCommercArea = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '15', '20', '25', '30', '35', '40', '45', '50', '60', '70', '80', '90', '100', '100', '200', '300', '400', '500', '600', '700', '800', '900', '1000', '2000', '3000', '4000', '5000', '6000', '7000', '8000', '9000', '10000', '10000+' ];

        // квартиры продажа
        if( numberCategory == '2' & numberTypeAction == '1' ) {

            // Количество комнат
            addFields += '<div class="field-rooms-saleparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr1" class="form-control" name="Rooms[saleparametr1]"><option value="">Количество комнат</option>';
            arrNumberRooms.forEach(function(item, i, arrNumberRooms){
                if ( location.search && item == arrGetParams['saleparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Вид объекта
            addFields += '<div class="field-rooms-saleparametr7" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr7" class="form-control" name="Rooms[saleparametr7]"><option value="">Вид объекта</option>';
            arrHouseType.forEach(function(item, i, arrHouseType){
                if ( location.search && item == arrGetParams['saleparametr7'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, от
            addFields += '<div class="field-rooms-saleparametr5" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr5" class="form-control" name="Rooms[saleparametr5]"><option value="">Площадь, от</option>';
            arrAreaFlat.forEach(function(item, i, arrAreaFlat){
                if ( location.search && item == arrGetParams['saleparametr5'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, до
            addFields += '<div class="field-rooms-saleparametr52" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr5_2" class="form-control" name="Rooms[saleparametr5_2]"><option value="">Площадь, до</option>';
            arrAreaFlat.forEach(function(item, i, arrAreaFlat){
                if ( location.search && item == arrGetParams['saleparametr5_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Тип дома
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr2" class="form-control" name="Rooms[saleparametr2]"><option value="">Тип дома</option>';
            arrHouseType2.forEach(function(item, i, arrHouseType2){
                if ( location.search && item == arrGetParams['saleparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, от
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr3" class="form-control" name="Rooms[saleparametr3]"><option value="">Этаж, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleparametr3'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, до
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr3_2" class="form-control" name="Rooms[saleparametr3_2]"><option value="">Этаж, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleparametr3_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этажей в доме, от
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr4" class="form-control" name="Rooms[saleparametr4]"><option value="">Этажей в доме, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleparametr4'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Этажей в доме, до
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleparametr4_2" class="form-control" name="Rooms[saleparametr4_2]"><option value="">Этажей в доме, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleparametr4_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

        }
         // квартиры аренда
        if( numberCategory == '2' & numberTypeAction == '2' ) {

            //Срок аренды
            addFields += '<div class="field-rooms-saleparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentparametr7" class="form-control" name="Rooms[rentparametr7]"><option value="">Срок аренды</option>';
            arrLeaseTerm.forEach(function(item, i, arrLeaseTerm){
                if ( location.search && item == arrGetParams['rentparametr7'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Количество комнат
            addFields += '<div class="field-rooms-saleparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentparametr1" class="form-control" name="Rooms[rentparametr1]"><option value="">Количество комнат</option>';
            arrNumberRooms.forEach(function(item, i, arrNumberRooms){
                if ( location.search && item == arrGetParams['rentparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, от
            addFields += '<div class="field-rooms-saleparametr5" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-metr" class="form-control" name="Rooms[metr]"><option value="">Площадь, от</option>';
            arrAreaFlat.forEach(function(item, i, arrAreaFlat){
                if ( location.search && item == arrGetParams['metr'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, до
            addFields += '<div class="field-rooms-saleparametr52" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-metr_2" class="form-control" name="Rooms[metr_2]"><option value="">Площадь, до</option>';
            arrAreaFlat.forEach(function(item, i, arrAreaFlat){
                if ( location.search && item == arrGetParams['metr_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Тип дома
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentparametr2" class="form-control" name="Rooms[rentparametr2]"><option value="">Тип дома</option>';
            arrHouseType2.forEach(function(item, i, arrHouseType2){
                if ( location.search && item == arrGetParams['rentparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, от
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentparametr3" class="form-control" name="Rooms[rentparametr3]"><option value="">Этаж, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['rentparametr3'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, до
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentparametr3_2" class="form-control" name="Rooms[rentparametr3_2]"><option value="">Этаж, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['rentparametr3_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этажей в доме, от
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-etazhnost" class="form-control" name="Rooms[etazhnost]"><option value="">Этажей в доме, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['etazhnost'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Этажей в доме, до
            addFields += '<div class="field-rooms-saleparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-etazhnost_2" class="form-control" name="Rooms[etazhnost_2]"><option value="">Этажей в доме, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['etazhnost_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

        }

        // комнаты продажа
        if( numberCategory == '3' & numberTypeAction == '1' ) {

             // Площадь комнаты, от
            addFields += '<div class="field-rooms-saleroomparametr5" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr5" class="form-control" name="Rooms[saleroomparametr5]"><option value="">Площадь комнаты, от</option>';
            arrAreaRoom.forEach(function(item, i, arrAreaRoom){
                if ( location.search && item == arrGetParams['saleroomparametr5'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь комнаты, до
            addFields += '<div class="field-rooms-saleroomparametr5-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr5_2" class="form-control" name="Rooms[saleroomparametr5_2]"><option value="">Площадь комнаты, до</option>';
            arrAreaRoom.forEach(function(item, i, arrAreaRoom){
                if ( location.search && item == arrGetParams['saleroomparametr5_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Комнат в квартире
            addFields += '<div class="field-rooms-saleroomparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr1" class="form-control" name="Rooms[saleroomparametr1]"><option value="">Комнат в квартире</option>';
            arrNumberRooms.forEach(function(item, i, arrNumberRooms){
                if ( location.search && item == arrGetParams['saleroomparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Тип дома
            addFields += '<div class="field-rooms-saleroomparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr2" class="form-control" name="Rooms[saleroomparametr2]"><option value="">Тип дома</option>';
            arrHouseType2.forEach(function(item, i, arrHouseType2){
                if ( location.search && item == arrGetParams['saleroomparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, от
            addFields += '<div class="field-rooms-saleroomparametr3" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr3" class="form-control" name="Rooms[saleroomparametr3]"><option value="">Этаж, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleroomparametr3'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, до
            addFields += '<div class="field-rooms-saleroomparametr3" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr3_2" class="form-control" name="Rooms[saleroomparametr3_2]"><option value="">Этаж, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleroomparametr3_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этажей в доме, от
            addFields += '<div class="field-rooms-saleroomparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr4" class="form-control" name="Rooms[saleroomparametr4]"><option value="">Этажей в доме, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleroomparametr4'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Этажей в доме, до
            addFields += '<div class="field-rooms-saleroomparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-saleroomparametr4_2" class="form-control" name="Rooms[saleroomparametr4_2]"><option value="">Этажей в доме, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['saleroomparametr4_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

        }

         // комнаты аренда
        if( numberCategory == '3' & numberTypeAction == '2' ) {

            //Срок аренды
            addFields += '<div class="field-rooms-rentparametr8" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr8" class="form-control" name="Rooms[rentroomparametr8]"><option value="">Срок аренды</option>';
            arrLeaseTerm.forEach(function(item, i, arrLeaseTerm){
                if ( location.search && item == arrGetParams['rentroomparametr8'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Площадь комнаты, от
            addFields += '<div class="field-rooms-rentroomparametr6" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr6" class="form-control" name="Rooms[rentroomparametr6]"><option value="">Площадь комнаты, от</option>';
            arrAreaRoom.forEach(function(item, i, arrAreaRoom){
                if ( location.search && item == arrGetParams['rentroomparametr6'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь комнаты, до
            addFields += '<div class="field-rooms-rentroomparametr6-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr6_2" class="form-control" name="Rooms[rentroomparametr6_2]"><option value="">Площадь комнаты, до</option>';
            arrAreaRoom.forEach(function(item, i, arrAreaRoom){
                if ( location.search && item == arrGetParams['rentroomparametr6_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Комнат в квартире
            addFields += '<div class="field-rooms-rentroomparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr2" class="form-control" name="Rooms[rentroomparametr2]"><option value="">Комнат в квартире</option>';
            arrNumberRooms.forEach(function(item, i, arrNumberRooms){
                if ( location.search && item == arrGetParams['rentroomparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Тип дома
            addFields += '<div class="field-rooms-rentroomparametr3" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr3" class="form-control" name="Rooms[rentroomparametr3]"><option value="">Тип дома</option>';
            arrHouseType2.forEach(function(item, i, arrHouseType2){
                if ( location.search && item == arrGetParams['rentroomparametr3'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, от
            addFields += '<div class="field-rooms-rentroomparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr4" class="form-control" name="Rooms[rentroomparametr4]"><option value="">Этаж, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['rentroomparametr4'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этаж, до
            addFields += '<div class="field-rooms-rentroomparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr4_2" class="form-control" name="Rooms[rentroomparametr4_2]"><option value="">Этаж, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['rentroomparametr4_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этажей в доме, от
            addFields += '<div class="field-rooms-rentroomparametr5" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr5" class="form-control" name="Rooms[rentroomparametr5]"><option value="">Этажей в доме, от</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['rentroomparametr5'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Этажей в доме, до
            addFields += '<div class="field-rooms-rentroomparametr5" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentroomparametr5_2" class="form-control" name="Rooms[rentroomparametr5_2]"><option value="">Этажей в доме, до</option>';
            arrFloor.forEach(function(item, i, arrFloor){
                if ( location.search && item == arrGetParams['rentroomparametr5_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

        }

        // Дома, Дачи, Коттеджи продажа
        if( numberCategory == '4' & numberTypeAction == '1' ) {

             // Вид объекта
            addFields += '<div class="field-rooms-salehomeparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr1" class="form-control" name="Rooms[salehomeparametr1]"><option value="">Вид объекта</option>';
            arrСottageType.forEach(function(item, i, arrСottageType){
                if ( location.search && item == arrGetParams['salehomeparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Площадь дома, от
            addFields += '<div class="field-rooms-salehomeparametr5" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr5" class="form-control" name="Rooms[salehomeparametr5]"><option value="">Площадь дома, от</option>';
            arrHomeArea.forEach(function(item, i, arrHomeArea){
                if ( location.search && item == arrGetParams['salehomeparametr5'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь дома, до
            addFields += '<div class="field-rooms-salehomeparametr5-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr5_2" class="form-control" name="Rooms[salehomeparametr5_2]"><option value="">Площадь дома, до</option>';
            arrHomeArea.forEach(function(item, i, arrHomeArea){
                if ( location.search && item == arrGetParams['salehomeparametr5_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Расстояние до города, от
            addFields += '<div class="field-rooms-salehomeparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr4" class="form-control" name="Rooms[salehomeparametr4]"><option value="">Расстояние до города, от</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['salehomeparametr4'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Расстояние до города, до
            addFields += '<div class="field-rooms-salehomeparametr4-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr4_2" class="form-control" name="Rooms[salehomeparametr4_2]"><option value="">Расстояние до города, до</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['salehomeparametr4_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этажей в доме, от
            addFields += '<div class="field-rooms-salehomeparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr2" class="form-control" name="Rooms[salehomeparametr2]"><option value="">Этажей в доме, от</option>';
            arrFloorsHouse.forEach(function(item, i, arrFloorsHouse){
                if ( location.search && item == arrGetParams['salehomeparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Этажей в доме, до
            addFields += '<div class="field-rooms-salehomeparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr2_2" class="form-control" name="Rooms[salehomeparametr2_2]"><option value="">Этажей в доме, до</option>';
            arrFloorsHouse.forEach(function(item, i, arrFloorsHouse){
                if ( location.search && item == arrGetParams['salehomeparametr2_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь участка, от
            addFields += '<div class="field-rooms-salehomeparametr6" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr6" class="form-control" name="Rooms[salehomeparametr6]"><option value="">Площадь участка, от</option>';
            arrLandArea.forEach(function(item, i, arrLandArea){
                if ( location.search && item == arrGetParams['salehomeparametr6'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь участка, до
            addFields += '<div class="field-rooms-salehomeparametr6" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr6_2" class="form-control" name="Rooms[salehomeparametr6_2]"><option value="">Площадь участка, до</option>';
            arrLandArea.forEach(function(item, i, arrLandArea){
                if ( location.search && item == arrGetParams['salehomeparametr6_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';
        }

        // Дома, Дачи, Коттеджи аренда
        if( numberCategory == '4' & numberTypeAction == '2' ) {

             // Вид объекта
            addFields += '<div class="field-rooms-salehomeparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salehomeparametr1" class="form-control" name="Rooms[salehomeparametr1]"><option value="">Вид объекта</option>';
            arrСottageType.forEach(function(item, i, arrСottageType){
                if ( location.search && item == arrGetParams['salehomeparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            //Срок аренды
            addFields += '<div class="field-rooms-renthomeparametr9" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr9" class="form-control" name="Rooms[renthomeparametr9]"><option value="">Срок аренды</option>';
            arrLeaseTerm.forEach(function(item, i, arrLeaseTerm){
                if ( location.search && item == arrGetParams['renthomeparametr9'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Площадь дома, от
            addFields += '<div class="field-rooms-renthomeparametr5" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr5" class="form-control" name="Rooms[renthomeparametr5]"><option value="">Площадь дома, от</option>';
            arrHomeArea.forEach(function(item, i, arrHomeArea){
                if ( location.search && item == arrGetParams['renthomeparametr5'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь дома, до
            addFields += '<div class="field-rooms-renthomeparametr5-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr5_2" class="form-control" name="Rooms[renthomeparametr5_2]"><option value="">Площадь дома, до</option>';
            arrHomeArea.forEach(function(item, i, arrHomeArea){
                if ( location.search && item == arrGetParams['renthomeparametr5_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Расстояние до города, от
            addFields += '<div class="field-rooms-renthomeparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr4" class="form-control" name="Rooms[renthomeparametr4]"><option value="">Расстояние до города, от</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['renthomeparametr4'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Расстояние до города, до
            addFields += '<div class="field-rooms-renthomeparametr4-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr4_2" class="form-control" name="Rooms[renthomeparametr4_2]"><option value="">Расстояние до города, до</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['renthomeparametr4_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Этажей в доме, от
            addFields += '<div class="field-rooms-renthomeparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr2" class="form-control" name="Rooms[renthomeparametr2]"><option value="">Этажей в доме, от</option>';
            arrFloorsHouse.forEach(function(item, i, arrFloorsHouse){
                if ( location.search && item == arrGetParams['renthomeparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Этажей в доме, до
            addFields += '<div class="field-rooms-renthomeparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr2_2" class="form-control" name="Rooms[renthomeparametr2_2]"><option value="">Этажей в доме, до</option>';
            arrFloorsHouse.forEach(function(item, i, arrFloorsHouse){
                if ( location.search && item == arrGetParams['renthomeparametr2_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь участка, от
            addFields += '<div class="field-rooms-renthomeparametr6" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr6" class="form-control" name="Rooms[renthomeparametr6]"><option value="">Площадь участка, от</option>';
            arrLandArea.forEach(function(item, i, arrLandArea){
                if ( location.search && item == arrGetParams['renthomeparametr6'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь участка, до
            addFields += '<div class="field-rooms-renthomeparametr6" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-renthomeparametr6_2" class="form-control" name="Rooms[renthomeparametr6_2]"><option value="">Площадь участка, до</option>';
            arrLandArea.forEach(function(item, i, arrLandArea){
                if ( location.search && item == arrGetParams['renthomeparametr6_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';
        }

        // Земельные участки продажа
        if( numberCategory == '5' & numberTypeAction == '1' ) {

             // Площадь, от
            addFields += '<div class="field-rooms-salelandparametr3" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salelandparametr3" class="form-control" name="Rooms[salelandparametr3]"><option value="">Площадь, от</option>';
            arrLandArea2.forEach(function(item, i, arrLandArea2){
                if ( location.search && item == arrGetParams['salelandparametr3'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, до
            addFields += '<div class="field-rooms-salelandparametr3-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salelandparametr3_2" class="form-control" name="Rooms[salelandparametr3_2]"><option value="">Площадь, до</option>';
            arrLandArea2.forEach(function(item, i, arrLandArea2){
                if ( location.search && item == arrGetParams['salelandparametr3_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Расстояние до города, от
            addFields += '<div class="field-rooms-salelandparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salelandparametr2" class="form-control" name="Rooms[salelandparametr2]"><option value="">Расстояние до города, от</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['salelandparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Расстояние до города, до
            addFields += '<div class="field-rooms-salelandparametr2-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salelandparametr2_2" class="form-control" name="Rooms[salelandparametr2_2]"><option value="">Расстояние до города, до</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['salelandparametr2_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Категория земель
            addFields += '<div class="field-rooms-salelandparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salelandparametr1" class="form-control" name="Rooms[salelandparametr1]"><option value="">Категория земель</option>';
            arrLandCategory.forEach(function(item, i, arrLandCategory){
                if ( location.search && item == arrGetParams['salelandparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';
        }

        // Земельные участки аренда
        if( numberCategory == '5' & numberTypeAction == '2' ) {

             // Площадь, от
            addFields += '<div class="field-rooms-rentlandparametr3" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentlandparametr3" class="form-control" name="Rooms[rentlandparametr3]"><option value="">Площадь, от</option>';
            arrLandArea2.forEach(function(item, i, arrLandArea2){
                if ( location.search && item == arrGetParams['rentlandparametr3'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, до
            addFields += '<div class="field-rooms-rentlandparametr3-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentlandparametr3_2" class="form-control" name="Rooms[rentlandparametr3_2]"><option value="">Площадь, до</option>';
            arrLandArea2.forEach(function(item, i, arrLandArea2){
                if ( location.search && item == arrGetParams['rentlandparametr3_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Расстояние до города, от
            addFields += '<div class="field-rooms-rentlandparametr2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentlandparametr2" class="form-control" name="Rooms[rentlandparametr2]"><option value="">Расстояние до города, от</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['rentlandparametr2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Расстояние до города, до
            addFields += '<div class="field-rooms-rentlandparametr2-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentlandparametr2_2" class="form-control" name="Rooms[rentlandparametr2_2]"><option value="">Расстояние до города, до</option>';
            arrDistanceCity.forEach(function(item, i, arrDistanceCity){
                if ( location.search && item == arrGetParams['rentlandparametr2_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

             // Категория земель
            addFields += '<div class="field-rooms-rentlandparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentlandparametr1" class="form-control" name="Rooms[rentlandparametr1]"><option value="">Категория земель</option>';
            arrLandCategory.forEach(function(item, i, arrLandCategory){
                if ( location.search && item == arrGetParams['rentlandparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';
        }

        // Коммерческая недвижимость продажа
        if( numberCategory == '7' & numberTypeAction == '1' ) {

             // Вид объекта
            addFields += '<div class="field-rooms-rentcommercparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentcommercparametr1" class="form-control" name="Rooms[rentcommercparametr1]"><option value="">Вид объекта</option>';
            arrCommercialType.forEach(function(item, i, arrCommercialType){
                if ( location.search && item == arrGetParams['rentcommercparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, от
            addFields += '<div class="field-rooms-rentcommercparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentcommercparametr4" class="form-control" name="Rooms[rentcommercparametr4]"><option value="">Площадь, от</option>';
            arrCommercArea.forEach(function(item, i, arrCommercArea){
                if ( location.search && item == arrGetParams['rentcommercparametr4'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, до
            addFields += '<div class="field-rooms-rentcommercparametr4-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-rentcommercparametr4_2" class="form-control" name="Rooms[rentcommercparametr4_2]"><option value="">Площадь, до</option>';
            arrCommercArea.forEach(function(item, i, arrCommercArea){
               if ( location.search && item == arrGetParams['rentcommercparametr4_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';
        }

        // Коммерческая недвижимость аренда
        if( numberCategory == '7' & numberTypeAction == '2' ) {

             // Вид объекта
            addFields += '<div class="field-rooms-salecommercparametr1" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salecommercparametr1" class="form-control" name="Rooms[salecommercparametr1]"><option value="">Вид объекта</option>';
            arrCommercialType.forEach(function(item, i, arrCommercialType){
                if ( location.search && item == arrGetParams['salecommercparametr1'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, от
            addFields += '<div class="field-rooms-salecommercparametr4" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salecommercparametr4" class="form-control" name="Rooms[salecommercparametr4]"><option value="">Площадь, от</option>';
            arrCommercArea.forEach(function(item, i, arrCommercArea){
                if ( location.search && item == arrGetParams['salecommercparametr4'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';

            // Площадь, до
            addFields += '<div class="field-rooms-salecommercparametr4-2" style="display: inline-block; margin: 10px 15px 0 0;"><select id="rooms-salecommercparametr4_2" class="form-control" name="Rooms[salecommercparametr4_2]"><option value="">Площадь, до</option>';
            arrCommercArea.forEach(function(item, i, arrCommercArea){
                if ( location.search && item == arrGetParams['salecommercparametr4_2'] ) {
                    addFields += '<option value="' + item + '" selected>' + item + '</option>';
                } else {
                    addFields += '<option value="' + item + '">' + item + '</option>';
                }
            });
            addFields += '</select></div>';
        }

        newFieldsBody.innerHTML = addFields;
    }

    function GetURLParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    }
});