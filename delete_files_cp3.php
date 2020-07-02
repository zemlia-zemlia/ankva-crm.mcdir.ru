<?
$db_host = 'localhost';
$db_login = 'a88163_cp3';
$db_passwd = '55230Ab1';
$db_name = 'a88163_cp3';


mysql_connect($db_host, $db_login, $db_passwd) or die ("MySQL Error77: " . mysql_error()); //~ устанавливаем подключение с бд
mysql_query("set names utf8") or die ("<br>Invalid query: " . mysql_error()); //~ указываем что передаем данные в utf8
mysql_select_db($db_name) or die ("<br>Invalid query: " . mysql_error()); //~ выбираем базу данных


/*


38

39

18

29




*/
//$dir3 = 'photo/4642';
/*
        if (!is_dir($dir3)) {
 rmdir($dir3);
}
*/
function recursiveRemoveDir($dir) {

    $includes = glob($dir.'/{,.}*', GLOB_BRACE);
    $systemDots = preg_grep('/\.+$/', $includes);

    foreach ($systemDots as $index => $dot) {

        unset($includes[$index]);
    }

    foreach ($includes as $include) {

        if(is_dir($include) && !is_link($include)) {

            recursiveRemoveDir($include);
        }

        else {

            unlink($include);
        }
    }

    rmdir($dir);
}

//Удалим из текущей директории директорию tmp




$result = mysql_query("SELECT id,id_c FROM `objects` WHERE id_company = '10' LIMIT 100");


while($postrow = mysql_fetch_array($result))
{

    $id_object = $postrow['id']; // В
    echo $id_object;
    echo '(';
    echo $postrow['id_c'];

    echo ')';
    echo '<hr>';


    $result2 = mysql_query("SELECT id, url FROM `photo` WHERE id_object = '$id_object'");

    while($postrow2 = mysql_fetch_array($result2))
    {
        echo '<br>----<br>';

        $id = $postrow2['id'];
        echo $postrow2['url'];

        $image = "photo/".$postrow2['url']."";
        if(isset($image)) {

            $explodingLimit = 2;
            $string = $image;
            $stringArray = explode ("/", $string);
            $neededElements = array_slice($stringArray, 0, $explodingLimit);
            $dir2 = implode("/", $neededElements);



            echo '<br> Папка:';
            echo $dir2;
            echo "<br> Файл: ";

            echo 'из:  <br>';
            echo $image;
            echo '<br>----<br>';

            //   unlink($image);

            recursiveRemoveDir($dir2);




            echo '<br>----<br>';
        }

        // $result5 = mysql_query ("DELETE FROM photo WHERE id='$id'"); if ($result5 == 'true') { echo "Данные удалены успешно!"; } else { echo "Данные не удалены!"; }

        echo '<br>';

    }

//        $result3 = mysql_query ("DELETE FROM objects WHERE id='$id_object'");

}





