<?
//	mkdir("/var/www/domains/rentparser.ru/01", 0777);
$db_host = 'localhost';
$db_login = 'a88163_cp3';
$db_passwd = '55230Ab1';
$db_name = 'a88163_cp3';

mysql_connect($db_host, $db_login, $db_passwd) or die ("MySQL Error77: " . mysql_error()); //~ устанавливаем подключение с бд
mysql_query("set names utf8") or die ("<br>Invalid query: " . mysql_error()); //~ указываем что передаем данные в utf8
mysql_select_db($db_name) or die ("<br>Invalid query: " . mysql_error()); //~ выбираем базу данных




$result = mysql_query("SELECT * FROM `client` WHERE  `status` = '1' AND  `client_type` = '1' ORDER BY `id`  DESC   ");


	while($postrow = mysql_fetch_array($result))
				{


$cl = $postrow['date_registration'];
$time1 = time();

$v1 = $cl + (86400 * $postrow['access_days']);



if ($timel >= $v1){
echo $postrow2['id'];


mysql_query("UPDATE `client` SET 
          `status` = '0' ,  `client_type` = '0'
         WHERE   `id` = '".$postrow['id']."'")
        or die(mysql_error());

echo '<br>';


}



}






?>