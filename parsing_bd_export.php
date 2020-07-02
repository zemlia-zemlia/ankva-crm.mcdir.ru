<?
//	mkdir("/var/www/domains/rentparser.ru/01", 0777);
$db_host = 'localhost';
$db_login = 'b8816_crm2';
$db_passwd = '888999AD';
$db_name = 'b8816_crm2';

mysql_connect($db_host, $db_login, $db_passwd) or die ("MySQL Error77: " . mysql_error()); //~ устанавливаем подключение с бд
mysql_query("set names utf8") or die ("<br>Invalid query: " . mysql_error()); //~ указываем что передаем данные в utf8
mysql_select_db($db_name) or die ("<br>Invalid query: " . mysql_error()); //~ выбираем базу данных




$result = mysql_query("SELECT * FROM `client` WHERE  `status` = '1' AND  `client_type` = '1' AND `parser_bd` = '1'  ORDER BY `id`  DESC   ");


while($postrow = mysql_fetch_array($result))
{


    // Ловим тип недвижимости


    $type_parametr = $postrow[''];
    $array = ["-","!","?",".", "[", "]"];
    $type_parametr = str_replace($array ,"", $type_parametr); // выдаем тип 3,4

    // от и до стоймость

    // город



    // выбираем список недвижимости: SELECT * FROM `objects` WHERE `type` IN (3,4)







}



public static function cityList($region_id = null)
{
    if ($region_id) {
        $cities = City::find()->select(['id', 'name'])->asArray()->where(['region_id' => $region_id])->all();
        return ArrayHelper::map($cities, 'id', 'name');
    }
    return [];
}


?>