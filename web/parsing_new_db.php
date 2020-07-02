<?
//  mkdir("/var/www/domains/rentparser.ru/01", 0777);

$db_host = 'localhost';
$db_login = 'root';
$db_passwd = 'root';
$db_name = 'crm2';

$link_db = mysqli_connect($db_host, $db_login, $db_passwd, $db_name) or die ("MySQL Error77: " . mysqli_error($link_db)); //~ устанавливаем подключение с бд
if (mysqli_set_charset($link_db, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link_db));
} else {
    printf("Current character set: %s\n", mysqli_character_set_name($link_db));
}

function curlget($url){
    $ch = curl_init(); 
    curl_setopt ($ch, CURLOPT_URL, $url); 

    curl_setopt_array($ch,array(
      CURLOPT_AUTOREFERER=>true,
      CURLOPT_FOLLOWLOCATION=>true,
      CURLOPT_HEADER=>false,
      CURLOPT_RETURNTRANSFER=>true,
      CURLOPT_VERBOSE=>false,
      CURLOPT_SSL_VERIFYPEER=>0,
    ));

    $result = curl_exec($ch);
    curl_close($ch); 
    return $result; 
}

date_default_timezone_set('Europe/Moscow');
$dateAdd = date("Y-m-d H:i:s");


$today1=date("Y-m-d");
$daysone =date("Y-m-d",time()+(1*(24*60*60)));

date_default_timezone_set('Europe/Moscow');
$login = 'msdays@yandex.ru';
$token = '35a8a00930f795c7b22c3dbc8463db14';

//задаем время получаемых объявлений, время отстает на 30 минут.
$date = new DateTime();    //текущее время
$date1 = clone $date;      //копируем объект даты
$date1->sub(new DateInterval('PT46M'));    //текущее минус 46 минут
$date2 = clone $date;      //копируем объект даты
$date2->sub(new DateInterval('PT31M'));   //текущее минус 31 минута
//таким образом интервал $date1 $date2 у нас будет 15 минут, теперь можно делать запрос

//делаем запрос к api
$str = curlget("https://ads-api.ru/main/api?user=".urlencode($login)."&token=".urlencode($token)
                          ."&category_id=1&person_type=3&date1=".urlencode($date1->format('Y-m-d H:i:s'))
                          ."&date2=".urlencode($date2->format('Y-m-d H:i:s')));
//парсим ответ как json
$json = json_decode($str);

//проходим по всем объявлениям
foreach ($json->data as $ad)    //$ad - объект объявления
{
        $avito_id = $ad->avitoid;
/*
$db_povtor_avito = mysqli_query($link_db,"SELECT avito_id FROM `rooms` WHERE `avito_id` = '".$avito_id."'  ");
$db_povtor_avito = mysqli_fetch_array($db_povtor_avito);
$avito_povtor = $db_povtor_avito['avito_id'];
*/
//$count_b2  = $postrow2['ob'];

//    echo '<br><br>';
    $img1 = $ad->images[0]->imgurl;
    $img2 = $ad->images[1]->imgurl;
    $img3 = $ad->images[2]->imgurl;
    $img4 = $ad->images[3]->imgurl;
    $img5 = $ad->images[4]->imgurl;
    $img6 = $ad->images[5]->imgurl;
    $img7 = $ad->images[6]->imgurl;
    $img8 = $ad->images[7]->imgurl;
    $img9 = $ad->images[8]->imgurl;
    $img10 = $ad->images[9]->imgurl;
    $img11 = $ad->images[10]->imgurl;
    $img12 = $ad->images[11]->imgurl;
    $img13 = $ad->images[12]->imgurl;
    $img14 = $ad->images[13]->imgurl;
    $img15 = $ad->images[14]->imgurl;
    $img16 = $ad->images[15]->imgurl;
    $img31 = $ad->images[16]->imgurl;

    $img17 = $ad->images[17]->imgurl;

    $img18 = $ad->images[18]->imgurl;

    $img19 = $ad->images[19]->imgurl;

    $img20 = $ad->images[20]->imgurl;
    $img21 = $ad->images[21]->imgurl;
    $img22 = $ad->images[22]->imgurl;
    $img23 = $ad->images[23]->imgurl;
    $img24 = $ad->images[24]->imgurl;
    $img25 = $ad->images[25]->imgurl;
    $img26 = $ad->images[26]->imgurl;
    $img27 = $ad->images[27]->imgurl;
    $img28 = $ad->images[28]->imgurl;
    $img29 = $ad->images[29]->imgurl;
    $img30 = $ad->images[30]->imgurl;

    echo $ad->images;


    //   echo $img1;
    $id_ads = $ad->id;

//    $avito_id = $ad->avitoid;
    $source = $ad->source; // Источник
    $avito_time = $ad->time; // Время
    $price = $ad->price; // стоимостть
    $description2 = $ad->description;
    $href = $ad->url;
    $seller2 = $ad->person;
    $phone = $ad->phone;
    $city = $ad->city;
    $nedvigimost_type = $ad->nedvigimost_type;
    $category_id = $ad->category_id; // Категория

    $person_type = $ad->person_type; // person_type
    $city_name = $ad->city1;
    $region2 = $ad->region;

    $region = $ad->metro;
    $addr = $ad->address;
    $nedvigimost_type_id = $ad->nedvigimost_type_id; //Тип
    $title = $ad->title;

    $cat1_id = $ad->cat1_id;
    $cat2_id = $ad->cat2_id;
    $cat1 = $ad->cat1;
    $cat2 = $ad->cat2;
    $catid = $ad->catid;
    $phone_protected = $ad->phone_protected;


//Продажа
    $sale_parametr1 = $ad->param_1945; // Количество комнат
    $sale_parametr2 = $ad->param_2009; // Тип дома
    $sale_parametr3 = $ad->param_2113; // Этаж
    $sale_parametr4 = $ad->param_2213; // Этажей в доме
    $sale_parametr5 = $ad->param_2313; // Площадь
    $sale_parametr6 = $ad->param_2314; // Адрес

    $sale_parametr7 = $ad->param_1957;
    $rent_parametr7 = $ad->param_2016;
    $rent_room_parametr8 = $ad->param_2574;
    $rent_home_parametr9 = $ad->param_3433;


//Сдам квартиру

    $pledge = $ad->param_6866; // Залог
    $metr = $ad->param_2515; // Кв. Метры

    $srok = $ad->param_2016;

    $rent_parametr1 = $ad->param_2019; // Количество комнат
    $rent_parametr2 = $ad->param_2078; // Тип дома
    $rent_parametr3 = $ad->param_2315; //Этаж
    $etazhnost = $ad->param_2415; // Этажность
    $rent_parametr4 = $ad->param_2516; //Адрес

//Продажа комнаты

    $sale_room_parametr1 = $ad->param_2545; //Комнат в квартире
    $sale_room_parametr2 = $ad->param_2567; //Тип дома
    $sale_room_parametr3 = $ad->param_2636; //Этаж
    $sale_room_parametr4 = $ad->param_2736; //Этажей в доме
    $sale_room_parametr5 = $ad->param_2836; //Площадь комнаты
    $sale_room_parametr6 = $ad->param_2837; //Адрес


//Сдам комнату

    $rent_room_parametr1 = $ad->param_7188; //Залог
    $rent_room_parametr2 = $ad->param_2603; //Комнат в квартире
    $rent_room_parametr3 = $ad->param_2625; //Тип дома
    $rent_room_parametr4 = $ad->param_2838; //Этаж
    $rent_room_parametr5 = $ad->param_2938; //Этажей в доме
    $rent_room_parametr6 = $ad->param_3038; //Площадь комнаты
    $rent_room_parametr7 = $ad->param_3039; //Адрес


//Дома, дачи, коттеджи

    $sale_home_parametr1 = $ad->param_3042; //Вид объекта
    $sale_home_parametr2 = $ad->param_3837; //этажей
    $sale_home_parametr3 = $ad->param_3843; //материал стен
    $sale_home_parametr4 = $ad->param_3852; //расстояние до города
    $sale_home_parametr5 = $ad->param_4014; //Площадь дома
    $sale_home_parametr6 = $ad->param_4015; //Площадь участка
    $sale_home_parametr7 = $ad->param_7424; //Адрес

// Сдам Дома, дачи, коттеджи

    $rent_home_parametr1 = $ad->param_3428; //Вид объекта
    $rent_home_parametr2 = $ad->param_4016; //этажей
    $rent_home_parametr3 = $ad->param_4022; //материал стен
    $rent_home_parametr4 = $ad->param_4031; //расстояние до города
    $rent_home_parametr5 = $ad->param_4193; //Площадь дома
    $rent_home_parametr6 = $ad->param_4194; //Площадь участка
    $rent_home_parametr7 = $ad->param_7425; //Адрес
    $rent_home_parametr8 = $ad->param_7430; //Залог

// Земельный участки продам

    $sale_land_parametr1 = $ad->param_4313; // Категория земель
    $sale_land_parametr2 = $ad->param_4454; //Расстояние до города
    $sale_land_parametr3 = $ad->param_4616; //Площадь
    $sale_land_parametr4 = $ad->param_7442; //Адрес

// Земельные участки аренда

    $rent_land_parametr1 = $ad->param_4318; // Категория земель
    $rent_land_parametr2 = $ad->param_4617; //Расстояние до города
    $rent_land_parametr3 = $ad->param_4779; //Площадь
    $rent_land_parametr4 = $ad->param_7443; //Адрес

// Гаражи и машиноместа

    $sale_garage_parametr1 = $ad->param_4784; // Тип гаража
    $sale_garage_parametr2 = $ad->param_4789; // Тип машиноместа
    $sale_garage_parametr3 = $ad->param_4794; // Охрана
    $sale_garage_parametr4 = $ad->param_4821; // Площадь
    $sale_garage_parametr5 = $ad->param_7444; // Адрес

// Гаражи и машиноместа Сдам

    $rent_garage_parametr1 = $ad->param_4800; // Тип гаража
    $rent_garage_parametr2 = $ad->param_4805; // Тип машиноместа
    $rent_garage_parametr3 = $ad->param_4810; // Охрана
    $rent_garage_parametr4 = $ad->param_4844; // Площадь
    $rent_garage_parametr5 = $ad->param_7445; // Адрес

// Коммерческая недвижимость 

    $rent_commerc_parametr1 = $ad->param_4869; // Вид объекта
    $rent_commerc_parametr2 = $ad->param_4872; // Класс здания
    $rent_commerc_parametr3 = $ad->param_4880; // Класс здания склад
    $rent_commerc_parametr4 = $ad->param_4920; // Площадь
    $rent_commerc_parametr5 = $ad->param_4921; // Адрес

// Коммерческая недвижимость  СДАМ

    $sale_commerc_parametr1 = $ad->param_4887; // Вид объекта
    $sale_commerc_parametr2 = $ad->param_4890; // Класс здания
    $sale_commerc_parametr3 = $ad->param_4898; // Класс здания склад
    $sale_commerc_parametr4 = $ad->param_4922; // Площадь
    $sale_commerc_parametr5 = $ad->param_4923; // Адрес


    $input = $phone; // исходная строка
    $toDelete = 1; // сколько знаков надо убрать

    $phone = mb_substr($input, $toDelete);   // Телефон в нужный формат
    $description =  mysqli_real_escape_string($link_db, $description2); // Убираем запрещеные знаки

    // ** Фотографии

    if (isset($img1)) {
        // @mkdir("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."", 0777);
        if (isset($img1)) {
            $link = $img1;

//$file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/httpdocs/saved_photos/".$avito_id."/".$avito_id."_1.jpg", $file);
        }
        if (isset($img2)) {
            $link = $img2;
            $link2 = ',' . $img2 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."__2.jpg", $file);
        }
        if (isset($img3)) {
            $link = $img3;
            $link3 = ', ' . $img3 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_3.jpg", $file);
        }
        if (isset($img4)) {
            $link = $img4;
            $link4 = ', ' . $img4 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_4.jpg", $file);
        }
        if (isset($img5)) {
            $link = $img5;
            $link5 = ', ' . $img5 . '';

            //$file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_5.jpg", $file);
        }
        if (isset($img6)) {
            $link = $img6;
            $link6 = ', ' . $img6 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_6.jpg", $file);
        }

        if (isset($img7)) {
            $link = $img7;

            $link7 = ', ' . $img7 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_7.jpg", $file);
        }

        if (isset($img8)) {
            $link = $img8;
            $link8 = ', ' . $img8 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_8.jpg", $file);
        }

        if (isset($img9)) {
            $link = $img9;
            $link9 = ', ' . $img9 . '';

            //$file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_9.jpg", $file);
        }


        if (isset($img10)) {
            $link = $img10;
            $link10 = ', ' . $img10 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_10.jpg", $file);
        }


        if (isset($img11)) {
            $link = $img11;
            $link11 = ', ' . $img11 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }
        if (isset($img12)) {
            $link12 = ', ' . $img12 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img13)) {
            $link13 = ', ' . $img13 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img14)) {
            $link14 = ', ' . $img14 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img15)) {
            $link15 = ', ' . $img15 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img31)) {
            $link31 = ', ' . $img31 . '';
        }
        if (isset($img17)) {
            $link17 = ', ' . $img17 . '';
        }
        if (isset($img18)) {
            $link18 = ', ' . $img18 . '';
        }        

        if (isset($img19)) {
            $link19 = ', ' . $img19 . '';
        }
        if (isset($img20)) {
            $link21 = ', ' . $img21 . '';
        }
        if (isset($img22)) {
            $link22 = ', ' . $img22 . '';
        }
        if (isset($img23)) {
            $link23 = ', ' . $img23 . '';
        }
        if (isset($img24)) {
            $link24 = ', ' . $img24 . '';
        }
        if (isset($img25)) {
            $link25 = ', ' . $img25 . '';
        }
        if (isset($img26)) {
            $link26 = ', ' . $img26 . '';
        }
        if (isset($img27)) {
            $link27 = ', ' . $img27 . '';
        }
        if (isset($img28)) {
            $link28 = ', ' . $img28 . '';
        }
        if (isset($img29)) {
            $link29 = ', ' . $img29 . '';
        }
         if (isset($img30)) {
            $link30 = ', ' . $img30 . '';
        }               





        $images = "$link $link2 $link3 $link4 $link5 $link6 $link7 $link8 $link9 $link10 $link11 $link12 $link13 $link14 $link15 $link16 $link16 $link17 $link31 $link18 $link19 $link20 $link21 $link22 $link23 $link24 $link25 $link26 $link27 $link28 $link29 $link30 ";

    }



    //указание кодировки
    // mysqli_set_charset($link_db, 'utf8');
    $last_id = mysqli_insert_id($link_db);
    echo $last_id;

    mysqli_query($link_db, "INSERT INTO `rooms` (`avito_id`, `nedvigimost_type_id`,`catid`,`cat1_id`,`cat2_id`, `cat1`, `cat2`,`phone_protected`, `title`, `date_avito`, 
`is_company`, `price`, `pledge`, `description`, `href`, `seller`, `phone`, 
`city`, `city_name`, `region`, `region2`, `addr`, `type`, `type_info`, `rooms`, `etazh`, `etazhnost`,
 `metr`, `date_add`, `actual`, `source`, `yandex_id`, `sale_parametr1`, 
 `sale_parametr2`, `sale_parametr3`, `sale_parametr4`, `sale_parametr5`, `sale_parametr6`,`sale_parametr7`,
  `rent_parametr1`, `rent_parametr2`, `rent_parametr3`, `rent_parametr4`, `rent_parametr7`, `sale_room_parametr1`, 
  `sale_room_parametr2`, `sale_room_parametr3`, `sale_room_parametr4`, `sale_room_parametr5`,
   `sale_room_parametr6`, `rent_room_parametr1`, `rent_room_parametr2`, `rent_room_parametr3`, 
   `rent_room_parametr4`, `rent_room_parametr5`, `rent_room_parametr6`, `rent_room_parametr7`, `rent_room_parametr8`, `sale_home_parametr1`,
    `sale_home_parametr2`, `sale_home_parametr3`, `sale_home_parametr4`, `sale_home_parametr5`, `sale_home_parametr6`,
     `sale_home_parametr7`, `rent_home_parametr1`, `rent_home_parametr2`, `rent_home_parametr3`, `rent_home_parametr4`, 
     `rent_home_parametr5`, `rent_home_parametr6`, `rent_home_parametr7`, `rent_home_parametr8`,`rent_home_parametr9`, `sale_land_parametr1`, 
     `sale_land_parametr2`, `sale_land_parametr3`, `sale_land_parametr4`, `rent_land_parametr1`, `rent_land_parametr2`, 
     `rent_land_parametr3`, `rent_land_parametr4`, `sale_garage_parametr1`, `sale_garage_parametr2`, `sale_garage_parametr3`, `sale_garage_parametr4`,
      `sale_garage_parametr5`, `rent_garage_parametr1`, `rent_garage_parametr2`, `rent_garage_parametr3`, `rent_garage_parametr4`, `rent_garage_parametr5`, 
      `rent_commerc_parametr1`, `rent_commerc_parametr2`, `rent_commerc_parametr3`, `rent_commerc_parametr4`, `rent_commerc_parametr5`, `sale_commerc_parametr1`, 
      `sale_commerc_parametr2`, `sale_commerc_parametr3`, `sale_commerc_parametr4`, `sale_commerc_parametr5`, `dop`, `dop2`, `category_id`, `person_type`, `count_ads_same_phone`,
       `blackagent`, `images`, `id_task`, `id_ads`) VALUES ( '" . $avito_id . "',
'" . $nedvigimost_type_id . "',
'" . $catid . "',
'" . $cat1_id . "',
'" . $cat2_id . "',
'" . $cat1 . "',
'" . $cat2 . "',
'" . $phone_protected . "',
'" . $title . "',

'" . $avito_time . "',
'',
 '" . $price . "',
  '" . $pledge . "',
'" . $description . "',
  '" . $href . "',
 '" . $seller2 . "',
   '" . $phone . "',
    '" . $city . "',    '" . $city_name . "',    

      '" . $region . "',     '" . $region2 . "',

     '" . $addr . "',
    '" . $nedvigimost_type . "',
'" . $type_info . "',
  '0',
  '0',
   '" . $etazhnost . "',
     '" . $metr . "',
    '" . $dateAdd . "',
   '',
   '" . $source . "',
      '',

'" . $sale_parametr1 . "',
'" . $sale_parametr2 . "',
 '" . $sale_parametr3 . "',
 '" . $sale_parametr4 . "',
'" . $sale_parametr5 . "',
'" . $sale_parametr6 . "',
'" . $sale_parametr7 . "',

 '" . $rent_parametr1 . "',
'" . $rent_parametr2 . "',
'" . $rent_parametr3 . "',
'" . $rent_parametr4 . "',
'" . $rent_parametr7 . "',

'" . $sale_room_parametr1 . "',
 '" . $sale_room_parametr2 . "',
'" . $sale_room_parametr3 . "',
'" . $sale_room_parametr4 . "',
'" . $sale_room_parametr5 . "',
'" . $sale_room_parametr6 . "',

 '" . $rent_room_parametr1 . "',
 '" . $rent_room_parametr2 . "',
 '" . $rent_room_parametr3 . "',
 '" . $rent_room_parametr4 . "',
 '" . $rent_room_parametr5 . "',
 '" . $rent_room_parametr6 . "',
'" . $rent_room_parametr7 . "',
'" . $rent_room_parametr8 . "',

 '" . $sale_home_parametr1 . "',
 '" . $sale_home_parametr2 . "',
'" . $sale_home_parametr3 . "',
 '" . $sale_home_parametr4 . "',
'" . $sale_home_parametr5 . "',
 '" . $sale_home_parametr6 . "',
  '" . $sale_home_parametr7 . "',

 '" . $rent_home_parametr1 . "',
 '" . $rent_home_parametr2 . "',
'" . $rent_home_parametr3 . "',
 '" . $rent_home_parametr4 . "',
 '" . $rent_home_parametr5 . "',
 '" . $rent_home_parametr6 . "',
  '" . $rent_home_parametr7 . "',
 '" . $rent_home_parametr8 . "',
 '" . $rent_home_parametr9 . "',

  '" . $sale_land_parametr1 . "',
  '" . $sale_land_parametr2 . "',
  '" . $sale_land_parametr3 . "',
 '" . $sale_land_parametr4 . "',

  '" . $rent_land_parametr1 . "',
  '" . $rent_land_parametr2 . "',
 '" . $rent_land_parametr3 . "',
  '" . $rent_land_parametr4 . "',

 '" . $sale_garage_parametr1 . "',
  '" . $sale_garage_parametr2 . "',
 '" . $sale_garage_parametr3 . "',
  '" . $sale_garage_parametr4 . "',
  '" . $sale_garage_parametr5 . "', 

  '" . $rent_garage_parametr1 . "',
  '" . $rent_garage_parametr2 . "',
  '" . $rent_garage_parametr3 . "',
 '" . $rent_garage_parametr4 . "',
 '" . $rent_garage_parametr5 . "',

 '" . $rent_commerc_parametr1 . "',
  '" . $rent_commerc_parametr2 . "',
 '" . $rent_commerc_parametr3 . "',
  '" . $rent_commerc_parametr4 . "',
 '" . $rent_commerc_parametr5 . "',

  '" . $sale_commerc_parametr1 . "',
  '" . $sale_commerc_parametr2 . "',
 '" . $sale_commerc_parametr3 . "',
  '" . $sale_commerc_parametr4 . "',
  '" . $sale_commerc_parametr5 . "',
 
 '',
'',
 '" . $category_id . "', 
 '" . $person_type . "',
'',
 '0',
'" . $images . "',
  '', 
 '" . $id_ads . "')");


   unset($images);
    unset($link, $link2, $link3, $link4, $link5, $link6, $link7, $link8, $link9, $link10, $link11, $link12, $link13, $link14, $link15, $link16, $link17, $link31, $link18, $link19, $link20, $link21, $link22, $link23, $link24, $link25, $link26, $link27, $link28, $link29, $link30);
}      

mysqli_close($link_db);


/*
//делаем запрос к api
$str = file_get_contents("http://ads-api.ru/main/api?user=msdays@yandex.ru&token=35a8a00930f795c7b22c3dbc8463db14&category_id=1&q=&price1=0&price2=&date1=$today1&date2=$daysone&person_type=3&nedvigimost_type=&metro=&phone=&source=&param%5B1943%5D=&");
$json = json_decode($str);

foreach ($json->data as $ad)    //$ad - объект объявления
{
        $avito_id = $ad->avitoid;

$db_povtor_avito = mysqli_query($link_db,"SELECT avito_id FROM `rooms` WHERE `avito_id` = '".$avito_id."'  ");
$db_povtor_avito = mysqli_fetch_array($db_povtor_avito);
$avito_povtor = $db_povtor_avito['avito_id'];

//$count_b2  = $postrow2['ob'];

//    echo '<br><br>';
    $img1 = $ad->images[0]->imgurl;
    $img2 = $ad->images[1]->imgurl;
    $img3 = $ad->images[2]->imgurl;
    $img4 = $ad->images[3]->imgurl;
    $img5 = $ad->images[4]->imgurl;
    $img6 = $ad->images[5]->imgurl;
    $img7 = $ad->images[6]->imgurl;
    $img8 = $ad->images[7]->imgurl;
    $img9 = $ad->images[8]->imgurl;
    $img10 = $ad->images[9]->imgurl;
    $img11 = $ad->images[10]->imgurl;
    $img12 = $ad->images[11]->imgurl;
    $img13 = $ad->images[12]->imgurl;
    $img14 = $ad->images[13]->imgurl;
    $img15 = $ad->images[14]->imgurl;
    $img16 = $ad->images[15]->imgurl;
    $img31 = $ad->images[16]->imgurl;

    $img17 = $ad->images[17]->imgurl;

    $img18 = $ad->images[18]->imgurl;

    $img19 = $ad->images[19]->imgurl;

    $img20 = $ad->images[20]->imgurl;
    $img21 = $ad->images[21]->imgurl;
    $img22 = $ad->images[22]->imgurl;
    $img23 = $ad->images[23]->imgurl;
    $img24 = $ad->images[24]->imgurl;
    $img25 = $ad->images[25]->imgurl;
    $img26 = $ad->images[26]->imgurl;
    $img27 = $ad->images[27]->imgurl;
    $img28 = $ad->images[28]->imgurl;
    $img29 = $ad->images[29]->imgurl;
    $img30 = $ad->images[30]->imgurl;

    echo $ad->images;


    //   echo $img1;
    $id_ads = $ad->id;

//    $avito_id = $ad->avitoid;
    $source = $ad->source; // Источник
    $avito_time = $ad->time; // Время
    $price = $ad->price; // стоимостть
    $description2 = $ad->description;
    $href = $ad->url;
    $seller2 = $ad->person;
    $phone = $ad->phone;
    $city = $ad->city;
    $nedvigimost_type = $ad->nedvigimost_type;
    $category_id = $ad->category_id; // Категория

    $person_type = $ad->person_type; // person_type
    $city_name = $ad->city1;
    $region2 = $ad->region;

    $region = $ad->metro;
    $addr = $ad->address;
    $nedvigimost_type_id = $ad->nedvigimost_type_id; //Тип
    $title = $ad->title;

    $cat1_id = $ad->cat1_id;
    $cat2_id = $ad->cat2_id;
    $cat1 = $ad->cat1;
    $cat2 = $ad->cat2;
    $catid = $ad->catid;
    $phone_protected = $ad->phone_protected;


//Продажа
    $sale_parametr1 = $ad->param_1945; // Количество комнат
    $sale_parametr2 = $ad->param_2009; // Тип дома
    $sale_parametr3 = $ad->param_2113; // Этаж
    $sale_parametr4 = $ad->param_2213; // Этажей в доме
    $sale_parametr5 = $ad->param_2313; // Площадь
    $sale_parametr6 = $ad->param_2314; // Адрес

    $sale_parametr7 = $ad->param_1957;
    $rent_parametr7 = $ad->param_2016;
    $rent_room_parametr8 = $ad->param_2574;
    $rent_home_parametr9 = $ad->param_3433;


//Сдам квартиру

    $pledge = $ad->param_6866; // Залог
    $metr = $ad->param_2515; // Кв. Метры

    $srok = $ad->param_2016;

    $rent_parametr1 = $ad->param_2019; // Количество комнат
    $rent_parametr2 = $ad->param_2078; // Тип дома
    $rent_parametr3 = $ad->param_2315; //Этаж
    $etazhnost = $ad->param_2415; // Этажность
    $rent_parametr4 = $ad->param_2516; //Адрес

//Продажа комнаты

    $sale_room_parametr1 = $ad->param_2545; //Комнат в квартире
    $sale_room_parametr2 = $ad->param_2567; //Тип дома
    $sale_room_parametr3 = $ad->param_2636; //Этаж
    $sale_room_parametr4 = $ad->param_2736; //Этажей в доме
    $sale_room_parametr5 = $ad->param_2836; //Площадь комнаты
    $sale_room_parametr6 = $ad->param_2837; //Адрес


//Сдам комнату

    $rent_room_parametr1 = $ad->param_7188; //Залог
    $rent_room_parametr2 = $ad->param_2603; //Комнат в квартире
    $rent_room_parametr3 = $ad->param_2625; //Тип дома
    $rent_room_parametr4 = $ad->param_2838; //Этаж
    $rent_room_parametr5 = $ad->param_2938; //Этажей в доме
    $rent_room_parametr6 = $ad->param_3038; //Площадь комнаты
    $rent_room_parametr7 = $ad->param_3039; //Адрес


//Дома, дачи, коттеджи

    $sale_home_parametr1 = $ad->param_3042; //Вид объекта
    $sale_home_parametr2 = $ad->param_3837; //этажей
    $sale_home_parametr3 = $ad->param_3843; //материал стен
    $sale_home_parametr4 = $ad->param_3852; //расстояние до города
    $sale_home_parametr5 = $ad->param_4014; //Площадь дома
    $sale_home_parametr6 = $ad->param_4015; //Площадь участка
    $sale_home_parametr7 = $ad->param_7424; //Адрес

// Сдам Дома, дачи, коттеджи

    $rent_home_parametr1 = $ad->param_3428; //Вид объекта
    $rent_home_parametr2 = $ad->param_4016; //этажей
    $rent_home_parametr3 = $ad->param_4022; //материал стен
    $rent_home_parametr4 = $ad->param_4031; //расстояние до города
    $rent_home_parametr5 = $ad->param_4193; //Площадь дома
    $rent_home_parametr6 = $ad->param_4194; //Площадь участка
    $rent_home_parametr7 = $ad->param_7425; //Адрес
    $rent_home_parametr8 = $ad->param_7430; //Залог

// Земельный участки продам

    $sale_land_parametr1 = $ad->param_4313; // Категория земель
    $sale_land_parametr2 = $ad->param_4454; //Расстояние до города
    $sale_land_parametr3 = $ad->param_4616; //Площадь
    $sale_land_parametr4 = $ad->param_7442; //Адрес

// Земельные участки аренда

    $rent_land_parametr1 = $ad->param_4318; // Категория земель
    $rent_land_parametr2 = $ad->param_4617; //Расстояние до города
    $rent_land_parametr3 = $ad->param_4779; //Площадь
    $rent_land_parametr4 = $ad->param_7443; //Адрес

// Гаражи и машиноместа

    $sale_garage_parametr1 = $ad->param_4784; // Тип гаража
    $sale_garage_parametr2 = $ad->param_4789; // Тип машиноместа
    $sale_garage_parametr3 = $ad->param_4794; // Охрана
    $sale_garage_parametr4 = $ad->param_4821; // Площадь
    $sale_garage_parametr5 = $ad->param_7444; // Адрес

// Гаражи и машиноместа Сдам

    $rent_garage_parametr1 = $ad->param_4800; // Тип гаража
    $rent_garage_parametr2 = $ad->param_4805; // Тип машиноместа
    $rent_garage_parametr3 = $ad->param_4810; // Охрана
    $rent_garage_parametr4 = $ad->param_4844; // Площадь
    $rent_garage_parametr5 = $ad->param_7445; // Адрес

// Коммерческая недвижимость 

    $rent_commerc_parametr1 = $ad->param_4869; // Вид объекта
    $rent_commerc_parametr2 = $ad->param_4872; // Класс здания
    $rent_commerc_parametr3 = $ad->param_4880; // Класс здания склад
    $rent_commerc_parametr4 = $ad->param_4920; // Площадь
    $rent_commerc_parametr5 = $ad->param_4921; // Адрес

// Коммерческая недвижимость  СДАМ

    $sale_commerc_parametr1 = $ad->param_4887; // Вид объекта
    $sale_commerc_parametr2 = $ad->param_4890; // Класс здания
    $sale_commerc_parametr3 = $ad->param_4898; // Класс здания склад
    $sale_commerc_parametr4 = $ad->param_4922; // Площадь
    $sale_commerc_parametr5 = $ad->param_4923; // Адрес


    $input = $phone; // исходная строка
    $toDelete = 1; // сколько знаков надо убрать
//mb_internal_encoding("UTF-8");
    $phone = mb_substr($input, $toDelete); // глу скребёт мышь
    $description =  mysqli_real_escape_string($link_db, $description2);

    if (isset($img1)) {
        // @mkdir("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."", 0777);
        if (isset($img1)) {
            $link = $img1;

//$file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/httpdocs/saved_photos/".$avito_id."/".$avito_id."_1.jpg", $file);
        }
        if (isset($img2)) {
            $link = $img2;
            $link2 = ',' . $img2 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."__2.jpg", $file);
        }
        if (isset($img3)) {
            $link = $img3;
            $link3 = ', ' . $img3 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_3.jpg", $file);
        }
        if (isset($img4)) {
            $link = $img4;
            $link4 = ', ' . $img4 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_4.jpg", $file);
        }
        if (isset($img5)) {
            $link = $img5;
            $link5 = ', ' . $img5 . '';

            //$file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_5.jpg", $file);
        }
        if (isset($img6)) {
            $link = $img6;
            $link6 = ', ' . $img6 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_6.jpg", $file);
        }

        if (isset($img7)) {
            $link = $img7;

            $link7 = ', ' . $img7 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_7.jpg", $file);
        }

        if (isset($img8)) {
            $link = $img8;
            $link8 = ', ' . $img8 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_8.jpg", $file);
        }

        if (isset($img9)) {
            $link = $img9;
            $link9 = ', ' . $img9 . '';

            //$file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_9.jpg", $file);
        }


        if (isset($img10)) {
            $link = $img10;
            $link10 = ', ' . $img10 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_10.jpg", $file);
        }


        if (isset($img11)) {
            $link = $img11;
            $link11 = ', ' . $img11 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }
        if (isset($img12)) {
            $link12 = ', ' . $img12 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img13)) {
            $link13 = ', ' . $img13 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img14)) {
            $link14 = ', ' . $img14 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img15)) {
            $link15 = ', ' . $img15 . '';

            // $file = file_get_contents($link);
            // file_put_contents("/home/a88163/web/cp.rentcrm.ru/public_html/saved_photos/".$avito_id."/".$avito_id."_11.jpg", $file);
        }

        if (isset($img31)) {
            $link31 = ', ' . $img31 . '';
        }
        if (isset($img17)) {
            $link17 = ', ' . $img17 . '';
        }
        if (isset($img18)) {
            $link18 = ', ' . $img18 . '';
        }        

        if (isset($img19)) {
            $link19 = ', ' . $img19 . '';
        }
        if (isset($img20)) {
            $link21 = ', ' . $img21 . '';
        }
        if (isset($img22)) {
            $link22 = ', ' . $img22 . '';
        }
        if (isset($img23)) {
            $link23 = ', ' . $img23 . '';
        }
        if (isset($img24)) {
            $link24 = ', ' . $img24 . '';
        }
        if (isset($img25)) {
            $link25 = ', ' . $img25 . '';
        }
        if (isset($img26)) {
            $link26 = ', ' . $img26 . '';
        }
        if (isset($img27)) {
            $link27 = ', ' . $img27 . '';
        }
        if (isset($img28)) {
            $link28 = ', ' . $img28 . '';
        }
        if (isset($img29)) {
            $link29 = ', ' . $img29 . '';
        }
         if (isset($img30)) {
            $link30 = ', ' . $img30 . '';
        }               





        $images = "$link $link2 $link3 $link4 $link5 $link6 $link7 $link8 $link9 $link10 $link11 $link12 $link13 $link14 $link15 $link16 $link16 $link17 $link31 $link18 $link19 $link20 $link21 $link22 $link23 $link24 $link25 $link26 $link27 $link28 $link29 $link30 ";

    }

    if($avito_id!=$avito_povtor){


    //указание кодировки
    // mysqli_set_charset($link_db, 'utf8');
    $last_id = mysqli_insert_id($link_db);
    echo $last_id;
    mysqli_query($link_db, "INSERT INTO `rooms` ( `avito_id`, `nedvigimost_type_id`,`catid`,`cat1_id`,`cat2_id`, `cat1`, `cat2`,`phone_protected`, `title`, `date_avito`, 
`is_company`, `price`, `pledge`, `description`, `href`, `seller`, `phone`, 
`city`, `city_name`, `region`, `region2`, `addr`, `type`, `type_info`, `rooms`, `etazh`, `etazhnost`,
 `metr`, `date_add`, `actual`, `source`, `yandex_id`, `sale_parametr1`, 
 `sale_parametr2`, `sale_parametr3`, `sale_parametr4`, `sale_parametr5`, `sale_parametr6`,`sale_parametr7`,
  `rent_parametr1`, `rent_parametr2`, `rent_parametr3`, `rent_parametr4`, `rent_parametr7`, `sale_room_parametr1`, 
  `sale_room_parametr2`, `sale_room_parametr3`, `sale_room_parametr4`, `sale_room_parametr5`,
   `sale_room_parametr6`, `rent_room_parametr1`, `rent_room_parametr2`, `rent_room_parametr3`, 
   `rent_room_parametr4`, `rent_room_parametr5`, `rent_room_parametr6`, `rent_room_parametr7`, `rent_room_parametr8`, `sale_home_parametr1`,
    `sale_home_parametr2`, `sale_home_parametr3`, `sale_home_parametr4`, `sale_home_parametr5`, `sale_home_parametr6`,
     `sale_home_parametr7`, `rent_home_parametr1`, `rent_home_parametr2`, `rent_home_parametr3`, `rent_home_parametr4`, 
     `rent_home_parametr5`, `rent_home_parametr6`, `rent_home_parametr7`, `rent_home_parametr8`,`rent_home_parametr9`, `sale_land_parametr1`, 
     `sale_land_parametr2`, `sale_land_parametr3`, `sale_land_parametr4`, `rent_land_parametr1`, `rent_land_parametr2`, 
     `rent_land_parametr3`, `rent_land_parametr4`, `sale_garage_parametr1`, `sale_garage_parametr2`, `sale_garage_parametr3`, `sale_garage_parametr4`,
      `sale_garage_parametr5`, `rent_garage_parametr1`, `rent_garage_parametr2`, `rent_garage_parametr3`, `rent_garage_parametr4`, `rent_garage_parametr5`, 
      `rent_commerc_parametr1`, `rent_commerc_parametr2`, `rent_commerc_parametr3`, `rent_commerc_parametr4`, `rent_commerc_parametr5`, `sale_commerc_parametr1`, 
      `sale_commerc_parametr2`, `sale_commerc_parametr3`, `sale_commerc_parametr4`, `sale_commerc_parametr5`, `dop`, `dop2`, `category_id`, `person_type`, `count_ads_same_phone`,
       `blackagent`, `images`, `id_task`, `id_ads`) VALUES ( '" . $avito_id . "',
'" . $nedvigimost_type_id . "',
'" . $catid . "',
'" . $cat1_id . "',
'" . $cat2_id . "',
'" . $cat1 . "',
'" . $cat2 . "',
'" . $phone_protected . "',
'" . $title . "',

'" . $avito_time . "',
'',
 '" . $price . "',
  '" . $pledge . "',
'" . $description . "',
  '" . $href . "',
 '" . $seller2 . "',
   '" . $phone . "',
    '" . $city . "',    '" . $city_name . "',    

      '" . $region . "',     '" . $region2 . "',

     '" . $addr . "',
    '" . $nedvigimost_type . "',
'" . $type_info . "',
  '0',
  '0',
   '" . $etazhnost . "',
     '" . $metr . "',
    '" . $dateAdd . "',
   '',
   '" . $source . "',
      '',

'" . $sale_parametr1 . "',
'" . $sale_parametr2 . "',
 '" . $sale_parametr3 . "',
 '" . $sale_parametr4 . "',
'" . $sale_parametr5 . "',
'" . $sale_parametr6 . "',
'" . $sale_parametr7 . "',

 '" . $rent_parametr1 . "',
'" . $rent_parametr2 . "',
'" . $rent_parametr3 . "',
'" . $rent_parametr4 . "',
'" . $rent_parametr7 . "',

'" . $sale_room_parametr1 . "',
 '" . $sale_room_parametr2 . "',
'" . $sale_room_parametr3 . "',
'" . $sale_room_parametr4 . "',
'" . $sale_room_parametr5 . "',
'" . $sale_room_parametr6 . "',

 '" . $rent_room_parametr1 . "',
 '" . $rent_room_parametr2 . "',
 '" . $rent_room_parametr3 . "',
 '" . $rent_room_parametr4 . "',
 '" . $rent_room_parametr5 . "',
 '" . $rent_room_parametr6 . "',
'" . $rent_room_parametr7 . "',
'" . $rent_room_parametr8 . "',

 '" . $sale_home_parametr1 . "',
 '" . $sale_home_parametr2 . "',
'" . $sale_home_parametr3 . "',
 '" . $sale_home_parametr4 . "',
'" . $sale_home_parametr5 . "',
 '" . $sale_home_parametr6 . "',
  '" . $sale_home_parametr7 . "',

 '" . $rent_home_parametr1 . "',
 '" . $rent_home_parametr2 . "',
'" . $rent_home_parametr3 . "',
 '" . $rent_home_parametr4 . "',
 '" . $rent_home_parametr5 . "',
 '" . $rent_home_parametr6 . "',
  '" . $rent_home_parametr7 . "',
 '" . $rent_home_parametr8 . "',
 '" . $rent_home_parametr9 . "',

  '" . $sale_land_parametr1 . "',
  '" . $sale_land_parametr2 . "',
  '" . $sale_land_parametr3 . "',
 '" . $sale_land_parametr4 . "',

  '" . $rent_land_parametr1 . "',
  '" . $rent_land_parametr2 . "',
 '" . $rent_land_parametr3 . "',
  '" . $rent_land_parametr4 . "',

 '" . $sale_garage_parametr1 . "',
  '" . $sale_garage_parametr2 . "',
 '" . $sale_garage_parametr3 . "',
  '" . $sale_garage_parametr4 . "',
  '" . $sale_garage_parametr5 . "',

  '" . $rent_garage_parametr1 . "',
  '" . $rent_garage_parametr2 . "',
  '" . $rent_garage_parametr3 . "',
 '" . $rent_garage_parametr4 . "',
 '" . $rent_garage_parametr5 . "',

 '" . $rent_commerc_parametr1 . "',
  '" . $rent_commerc_parametr2 . "',
 '" . $rent_commerc_parametr3 . "',
  '" . $rent_commerc_parametr4 . "',
 '" . $rent_commerc_parametr5 . "',

  '" . $sale_commerc_parametr1 . "',
  '" . $sale_commerc_parametr2 . "',
 '" . $sale_commerc_parametr3 . "',
  '" . $sale_commerc_parametr4 . "',
  '" . $sale_commerc_parametr5 . "',
 
 '',
'',
 '" . $category_id . "', 
 '" . $person_type . "',
'',
 '0',
'" . $images . "',
  '', 
 '" . $id_ads . "')");

}
//or die( mysqli_error($link_db))
    unset($images);
    unset($link, $link2, $link3, $link4, $link5, $link6, $link7, $link8, $link9, $link10, $link11, $link12, $link13, $link14, $link15, $link16, $link17, $link31, $link18, $link19, $link20, $link21, $link22, $link23, $link24, $link25, $link26, $link27, $link28, $link29, $link30);
}
//echo "<br>!!!=".count($json->data);
mysqli_close($link_db);

?>