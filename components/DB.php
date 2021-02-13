<?php


class DB
{
    public static function getConnection()
    {
        //Подключение файла с параметрами:
        $paramsPath = ROOT . '/config/db_params.php';

        //Сохранение данных из него в переменную:
        $params = include($paramsPath);

        //dd($params['host']);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'"]);

//        $sql = "ALTER DATABASE `{$params['dbname']}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
//        $res = $db->query($sql);
//        while($row = $res->fetch()){
//            $sql = "ALTER TABLE {$params['dbname']}.`{$row[0]}` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
//            $db->query($sql);
//            $sql = "ALTER TABLE {$params['dbname']}.`{$row[0]}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
//            $db->query($sql);
//
//        }

        return $db;
    }


}

/*

$dbname = 'my_databaseName';
mysql_connect('127.0.0.1', 'root', '');
mysql_query("ALTER DATABASE `$dbname` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
$res = mysql_query("SHOW TABLES FROM `$dbname`");
while($row = mysql_fetch_row($res)) {
   $query = "ALTER TABLE {$dbname}.`{$row[0]}` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
   mysql_query($query);
   $query = "ALTER TABLE {$dbname}.`{$row[0]}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
   mysql_query($query);
}
echo 'all tables converted';



 */